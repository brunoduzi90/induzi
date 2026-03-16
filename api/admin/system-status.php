<?php
/**
 * Induzi - Status do sistema (admin-only)
 * GET: retorna informacoes sobre servidor, banco, armazenamento e aplicacao
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('GET');
$session = requireAdmin();

$db = getDB();
$info = [];

// ===== Servidor =====
$info['server'] = [
    'php_version'        => phpversion(),
    'sapi'               => php_sapi_name(),
    'memory_limit'       => ini_get('memory_limit'),
    'max_execution_time' => ini_get('max_execution_time'),
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size'      => ini_get('post_max_size'),
    'opcache_enabled'    => function_exists('opcache_get_status') && !empty(@opcache_get_status(false)),
];

// ===== Banco de Dados =====
try {
    $mysqlVersion = $db->query("SELECT VERSION() AS v")->fetchColumn();

    $dbName = defined('DB_NAME') ? DB_NAME : 'induzi';
    $stmtSize = $db->prepare("SELECT
        COUNT(*) AS table_count,
        COALESCE(SUM(data_length + index_length), 0) AS total_bytes
        FROM information_schema.TABLES
        WHERE table_schema = ?");
    $stmtSize->execute([$dbName]);
    $dbStats = $stmtSize->fetch(PDO::FETCH_ASSOC);

    $projectDataCount = $db->query("SELECT COUNT(*) FROM project_data")->fetchColumn();
    $usersCount = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $projectsCount = $db->query("SELECT COUNT(*) FROM projects")->fetchColumn();

    $info['database'] = [
        'mysql_version'      => $mysqlVersion,
        'db_name'            => $dbName,
        'table_count'        => (int) $dbStats['table_count'],
        'total_size'         => (int) $dbStats['total_bytes'],
        'project_data_rows'  => (int) $projectDataCount,
        'users_count'        => (int) $usersCount,
        'projects_count'     => (int) $projectsCount,
    ];
} catch (Exception $e) {
    $info['database'] = ['error' => 'Erro ao consultar banco de dados.'];
}

// ===== Armazenamento =====
$uploadsDir = __DIR__ . '/../../uploads';
$info['storage'] = ['total_size' => 0, 'file_count' => 0, 'folders' => []];

if (is_dir($uploadsDir)) {
    $folders = ['users', 'projects'];
    $totalSize = 0;
    $totalFiles = 0;

    foreach ($folders as $folder) {
        $folderPath = $uploadsDir . '/' . $folder;
        if (!is_dir($folderPath)) {
            $info['storage']['folders'][$folder] = ['size' => 0, 'files' => 0];
            continue;
        }
        $fSize = 0;
        $fCount = 0;
        $iter = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($folderPath, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($iter as $file) {
            if ($file->isFile()) {
                $fSize += $file->getSize();
                $fCount++;
            }
        }
        $info['storage']['folders'][$folder] = ['size' => $fSize, 'files' => $fCount];
        $totalSize += $fSize;
        $totalFiles += $fCount;
    }

    $info['storage']['total_size'] = $totalSize;
    $info['storage']['file_count'] = $totalFiles;
}

// ===== Aplicacao =====
$version = '?';
$versionDate = '';
$versionFile = __DIR__ . '/../../version.php';
if (file_exists($versionFile)) {
    include $versionFile;
    if (defined('INDUZI_VERSION')) $version = INDUZI_VERSION;
    if (defined('INDUZI_VERSION_DATE')) $versionDate = INDUZI_VERSION_DATE;
}

$dataKeysCount = 0;
try {
    $dataKeysCount = (int) $db->query("SELECT COUNT(DISTINCT data_key) FROM project_data")->fetchColumn();
} catch (Exception $e) {}

$info['app'] = [
    'version'      => $version,
    'version_date' => $versionDate,
    'users'        => $info['database']['users_count'] ?? 0,
    'projects'     => $info['database']['projects_count'] ?? 0,
    'data_keys'    => $dataKeysCount,
];

jsonResponse(['ok' => true, 'data' => $info]);
