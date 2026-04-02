<?php
/**
 * INDUZI - Baixar e aplicar atualizacao remota
 * POST admin-only + CSRF
 * Recebe URL de download, hash SHA-256 e versao remota
 */
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/update-helpers.php';
require_once __DIR__ . '/../../../version.php';

if (!defined('INDUZI_ROOT_DIR')) {
    define('INDUZI_ROOT_DIR', realpath(__DIR__ . '/../../../'));
}

requireMethod('POST');
$session = requireAdmin();

set_time_limit(300);
ignore_user_abort(true);

$pdo = getDB();

// Buscar token de update
$stmtToken = $pdo->prepare("SELECT valor FROM configuracoes WHERE chave = 'update_token'");
$stmtToken->execute();
$updateToken = ($stmtToken->fetch()['valor'] ?? '') ?: '';

$input = getJsonInput();

$downloadUrl = trim($input['download_url'] ?? '');
$expectedHash = trim($input['sha256'] ?? '');
$remoteVersion = trim($input['remote_version'] ?? '');

if (empty($downloadUrl)) {
    jsonResponse(['ok' => false, 'msg' => 'URL de download nao informada.'], 400);
}

// Para repos privados do GitHub, converter browser_download_url para API URL
if ($updateToken && preg_match('#^https://github\.com/([^/]+)/([^/]+)/releases/download/([^/]+)/(.+)$#', $downloadUrl, $m)) {
    $owner = $m[1];
    $repo = $m[2];
    $tag = $m[3];
    $filename = $m[4];

    $releaseResult = fetchRemoteData("https://api.github.com/repos/$owner/$repo/releases/tags/$tag", 15, $updateToken);
    if ($releaseResult['ok']) {
        $releaseData = json_decode($releaseResult['body'], true);
        if (is_array($releaseData) && !empty($releaseData['assets'])) {
            foreach ($releaseData['assets'] as $asset) {
                if ($asset['name'] === $filename) {
                    $downloadUrl = $asset['url'];
                    break;
                }
            }
        }
    }
}

if (empty($remoteVersion)) {
    jsonResponse(['ok' => false, 'msg' => 'Versao remota nao informada.'], 400);
}

$rootDir = realpath(__DIR__ . '/../../../');
$tempDir = $rootDir . DIRECTORY_SEPARATOR . 'sys_temp';
$zipPath = $tempDir . DIRECTORY_SEPARATOR . 'remote_update.zip';
$extractDir = $tempDir . DIRECTORY_SEPARATOR . 'update_temp';

if (!is_dir($tempDir)) {
    mkdir($tempDir, 0755, true);
}

// Verificar espaco em disco
$freeSpace = @disk_free_space($tempDir);
if ($freeSpace !== false && $freeSpace < 104857600) {
    jsonResponse(['ok' => false, 'msg' => 'Espaco em disco insuficiente (minimo 100MB).'], 500);
}

// Limpar arquivos temporarios anteriores
if (file_exists($zipPath)) {
    @unlink($zipPath);
}
if (is_dir($extractDir)) {
    deleteDirectory($extractDir);
}

// Detectar se URL aponta para o proprio servidor
$localFile = null;
$serverHost = $_SERVER['HTTP_HOST'] ?? '';
$parsedUrl = parse_url($downloadUrl);
$urlHost = $parsedUrl['host'] ?? '';

if ($serverHost && strcasecmp($urlHost, $serverHost) === 0) {
    $urlPath = $parsedUrl['path'] ?? '';
    $scriptDir = dirname(dirname(dirname($_SERVER['SCRIPT_NAME'])));
    if ($scriptDir !== '/' && strpos($urlPath, $scriptDir) === 0) {
        $relativePath = substr($urlPath, strlen($scriptDir) + 1);
    } else {
        $relativePath = ltrim($urlPath, '/');
    }
    $candidatePath = $rootDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
    if (file_exists($candidatePath)) {
        $localFile = $candidatePath;
    }
}

if ($localFile) {
    if (!copy($localFile, $zipPath)) {
        jsonResponse(['ok' => false, 'msg' => 'Erro ao copiar pacote local: ' . $localFile], 500);
    }
} else {
    $downloadResult = downloadRemoteFile($downloadUrl, $zipPath, 300, $updateToken);
    if (!$downloadResult['ok']) {
        jsonResponse(['ok' => false, 'msg' => 'Erro ao baixar pacote: ' . $downloadResult['error']], 500);
    }
}

// Verificar se arquivo foi baixado
if (!file_exists($zipPath) || filesize($zipPath) < 100) {
    @unlink($zipPath);
    jsonResponse(['ok' => false, 'msg' => 'Arquivo baixado esta vazio ou corrompido.'], 500);
}

// Verificar hash SHA-256 (obrigatorio)
if (empty($expectedHash)) {
    @unlink($zipPath);
    jsonResponse(['ok' => false, 'msg' => 'Hash SHA-256 ausente no manifest. Atualizacao recusada por seguranca.'], 400);
}
$actualHash = hash_file('sha256', $zipPath);
if (!hash_equals(strtolower($expectedHash), strtolower($actualHash))) {
    @unlink($zipPath);
    jsonResponse(['ok' => false, 'msg' => 'Verificacao de integridade falhou (hash SHA-256 nao confere).'], 500);
}

// Validar que e um ZIP valido
$zip = new ZipArchive();
$result = $zip->open($zipPath);

if ($result !== true) {
    @unlink($zipPath);
    jsonResponse(['ok' => false, 'msg' => 'Arquivo baixado nao e um ZIP valido.'], 500);
}

// Verificar se contem version.php
$hasVersion = false;
for ($i = 0; $i < $zip->numFiles; $i++) {
    $name = $zip->getNameIndex($i);
    if ($name === 'version.php') {
        $hasVersion = true;
        break;
    }
}

if (!$hasVersion) {
    $zip->close();
    @unlink($zipPath);
    jsonResponse(['ok' => false, 'msg' => 'Pacote invalido: version.php nao encontrado no ZIP.'], 400);
}

// Extrair
mkdir($extractDir, 0755, true);

if (!$zip->extractTo($extractDir)) {
    $zip->close();
    @unlink($zipPath);
    deleteDirectory($extractDir);
    jsonResponse(['ok' => false, 'msg' => 'Erro ao extrair pacote.'], 500);
}
$zip->close();

// Ler a nova versao do pacote extraido
$newVersion = 'desconhecida';
$newVersionDate = '';
$versionFile = $extractDir . DIRECTORY_SEPARATOR . 'version.php';
if (file_exists($versionFile)) {
    $versionContent = file_get_contents($versionFile);
    if (preg_match("/INDUZI_VERSION',\s*'([^']+)'/", $versionContent, $m)) {
        $newVersion = $m[1];
    }
    if (preg_match("/INDUZI_VERSION_DATE',\s*'([^']+)'/", $versionContent, $m)) {
        $newVersionDate = $m[1];
    }
}

// Criar backup antes de atualizar
$backupResult = createBackupZip($rootDir, INDUZI_VERSION);
if (!$backupResult['ok']) {
    deleteDirectory($extractDir);
    @unlink($zipPath);
    jsonResponse(['ok' => false, 'msg' => 'Erro ao criar backup: ' . $backupResult['msg']], 500);
}

// Copiar arquivos (com protecao)
$protectedItems = getProtectedItems();
$oldVersion = INDUZI_VERSION;
$updatedFiles = copyUpdateFiles($extractDir, $rootDir, $rootDir, $protectedItems);

// Limpar temporarios
deleteDirectory($extractDir);
@unlink($zipPath);

// Executar migracoes automaticamente
$migrationResult = null;
try {
    $migrationResult = runPendingMigrations($pdo);
} catch (Exception $e) {
    $migrationResult = [
        'ok' => false,
        'msg' => 'Erro ao executar migracoes: ' . $e->getMessage(),
        'results' => [],
    ];
}

logActivity($pdo, $session['userId'], 'atualizacao_remota', [
    'from' => $oldVersion,
    'to' => $newVersion,
    'files' => count($updatedFiles),
    'migrations' => $migrationResult['ok'] ?? false,
]);

$msg = "Atualizacao aplicada com sucesso. Versao: $oldVersion -> $newVersion.";

if ($migrationResult && !$migrationResult['ok']) {
    $msg .= ' Atencao: algumas migracoes falharam. Verifique o atualizador do sistema.';
}

$filesCreated = [];
$filesUpdatedList = [];
foreach ($updatedFiles as $f) {
    if ($f['action'] === 'criado') {
        $filesCreated[] = $f['path'];
    } else {
        $filesUpdatedList[] = $f['path'];
    }
}

jsonResponse([
    'ok' => true,
    'msg' => $msg,
    'data' => [
        'oldVersion' => $oldVersion,
        'newVersion' => $newVersion,
        'newVersionDate' => $newVersionDate,
        'filesUpdated' => count($updatedFiles),
        'files' => $updatedFiles,
        'filesCreated' => $filesCreated,
        'filesModified' => $filesUpdatedList,
        'migrations' => $migrationResult,
        'backupFile' => $backupResult['file'] ?? null,
    ]
]);
