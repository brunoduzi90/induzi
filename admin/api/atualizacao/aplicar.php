<?php
/**
 * INDUZI - Aplicar pacote de atualizacao (ZIP upload)
 * POST admin-only + CSRF
 * Recebe ZIP via multipart, extrai e copia arquivos
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

$pdo = getDB();
$rootDir = realpath(__DIR__ . '/../../../');
$tempDir = $rootDir . DIRECTORY_SEPARATOR . 'sys_temp';
$extractDir = $tempDir . DIRECTORY_SEPARATOR . 'update_temp';

if (!is_dir($tempDir)) {
    mkdir($tempDir, 0755, true);
}

// Verificar se arquivo foi enviado
if (!isset($_FILES['zipfile']) || $_FILES['zipfile']['error'] !== UPLOAD_ERR_OK) {
    $errorMsg = 'Erro no upload do arquivo.';
    if (isset($_FILES['zipfile'])) {
        switch ($_FILES['zipfile']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $errorMsg = 'Arquivo muito grande.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $errorMsg = 'Nenhum arquivo enviado.';
                break;
        }
    }
    jsonResponse(['ok' => false, 'msg' => $errorMsg], 400);
}

$uploadedFile = $_FILES['zipfile']['tmp_name'];
$fileSize = $_FILES['zipfile']['size'];

// Limite de 50MB
if ($fileSize > 52428800) {
    jsonResponse(['ok' => false, 'msg' => 'Arquivo muito grande (max 50MB).'], 400);
}

// Validar que e um ZIP
$zip = new ZipArchive();
$result = $zip->open($uploadedFile);

if ($result !== true) {
    jsonResponse(['ok' => false, 'msg' => 'Arquivo ZIP invalido.'], 400);
}

// Verificar se contem version.php (validacao de pacote)
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
    jsonResponse(['ok' => false, 'msg' => 'Pacote invalido: version.php nao encontrado.'], 400);
}

// Limpar diretorio temporario anterior
if (is_dir($extractDir)) {
    deleteDirectory($extractDir);
}
mkdir($extractDir, 0755, true);

// Extrair ZIP
if (!$zip->extractTo($extractDir)) {
    $zip->close();
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
    jsonResponse(['ok' => false, 'msg' => 'Erro ao criar backup: ' . $backupResult['msg']], 500);
}

// Usar lista de protecao compartilhada
$protectedItems = getProtectedItems();

$oldVersion = INDUZI_VERSION;
$updatedFiles = copyUpdateFiles($extractDir, $rootDir, $rootDir, $protectedItems);

// Limpar temporarios
deleteDirectory($extractDir);

// Executar migracoes automaticamente
$migrationResult = null;
try {
    $migrationResult = runPendingMigrations($pdo);
} catch (Exception $e) {
    $migrationResult = ['ok' => false, 'msg' => 'Erro ao executar migracoes: ' . $e->getMessage(), 'results' => []];
}

logActivity($pdo, $session['userId'], 'aplicar_atualizacao', [
    'from' => $oldVersion,
    'to' => $newVersion,
    'files' => count($updatedFiles),
]);

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
    'msg' => 'Atualizacao aplicada com sucesso.',
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
