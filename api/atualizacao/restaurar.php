<?php
/**
 * Induzi - Restaurar backup
 * POST admin-only + CSRF
 * Recebe { "file": "backup-v1.0.0-20260315-120000.zip" }
 * Extrai e aplica usando copyUpdateFiles()
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/update-helpers.php';
require_once __DIR__ . '/../../version.php';

requireMethod('POST');
$session = requireAdmin();

$input = getJsonInput();
$file = trim($input['file'] ?? '');

if (empty($file)) {
    jsonResponse(['ok' => false, 'msg' => 'Nome do backup nao informado.'], 400);
}

// Validar nome do arquivo (prevenir path traversal)
if (preg_match('/[\/\\\\]/', $file) || strpos($file, '..') !== false) {
    jsonResponse(['ok' => false, 'msg' => 'Nome de arquivo invalido.'], 400);
}

if (!preg_match('/^backup-v[\w._-]+-\d{8}-\d{6}\.zip$/', $file)) {
    jsonResponse(['ok' => false, 'msg' => 'Nome de arquivo invalido.'], 400);
}

$rootDir = realpath(__DIR__ . '/../../');
$backupDir = $rootDir . DIRECTORY_SEPARATOR . 'sys_temp' . DIRECTORY_SEPARATOR . 'backups';
$zipPath = $backupDir . DIRECTORY_SEPARATOR . $file;

if (!file_exists($zipPath)) {
    jsonResponse(['ok' => false, 'msg' => 'Backup nao encontrado.'], 404);
}

// Extrair backup
$tempDir = $rootDir . DIRECTORY_SEPARATOR . 'sys_temp';
$extractDir = $tempDir . DIRECTORY_SEPARATOR . 'restore_temp';

if (is_dir($extractDir)) {
    deleteDirectory($extractDir);
}
mkdir($extractDir, 0755, true);

$zip = new ZipArchive();
$result = $zip->open($zipPath);

if ($result !== true) {
    jsonResponse(['ok' => false, 'msg' => 'Erro ao abrir arquivo de backup.'], 500);
}

if (!$zip->extractTo($extractDir)) {
    $zip->close();
    deleteDirectory($extractDir);
    jsonResponse(['ok' => false, 'msg' => 'Erro ao extrair backup.'], 500);
}
$zip->close();

// Ler versao do backup
$restoredVersion = 'desconhecida';
$restoredDate = '';
$versionFile = $extractDir . DIRECTORY_SEPARATOR . 'version.php';
if (file_exists($versionFile)) {
    $versionContent = file_get_contents($versionFile);
    if (preg_match("/INDUZI_VERSION',\s*'([^']+)'/", $versionContent, $m)) {
        $restoredVersion = $m[1];
    }
    if (preg_match("/INDUZI_VERSION_DATE',\s*'([^']+)'/", $versionContent, $m)) {
        $restoredDate = $m[1];
    }
}

// Aplicar arquivos do backup
$protectedItems = getProtectedItems();
$oldVersion = INDUZI_VERSION;
$updatedFiles = copyUpdateFiles($extractDir, $rootDir, $rootDir, $protectedItems);

// Limpar temporarios
deleteDirectory($extractDir);

// Executar migracoes pendentes
$migrationResult = null;
try {
    $pdo = getDB();
    $migrationResult = runPendingMigrations($pdo);
} catch (Exception $e) {
    $migrationResult = [
        'ok' => false,
        'msg' => 'Erro ao executar migracoes: ' . $e->getMessage(),
        'results' => [],
    ];
}

$db = getDB();
logActivity($db, null, $session['userId'], 'restaurar_backup', [
    'backup' => $file,
    'de' => $oldVersion,
    'para' => $restoredVersion,
    'arquivos' => count($updatedFiles),
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
    'msg' => 'Backup restaurado com sucesso.',
    'data' => [
        'oldVersion' => $oldVersion,
        'restoredVersion' => $restoredVersion,
        'restoredDate' => $restoredDate,
        'filesUpdated' => count($updatedFiles),
        'files' => $updatedFiles,
        'filesCreated' => $filesCreated,
        'filesModified' => $filesUpdatedList,
        'migrations' => $migrationResult,
        'backupFile' => $file,
    ]
]);
