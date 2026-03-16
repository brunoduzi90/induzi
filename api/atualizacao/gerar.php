<?php
/**
 * Induzi - Gerar pacote de atualizacao (ZIP)
 * POST admin-only + CSRF
 * Cria ZIP e envia como download direto na resposta
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../version.php';

requireMethod('POST');
$session = requireAdmin();

$rootDir = realpath(__DIR__ . '/../../');

// Auto-incrementar versao (patch) antes de gerar
$versionFile = $rootDir . DIRECTORY_SEPARATOR . 'version.php';
$versionContent = file_get_contents($versionFile);
$parts = explode('.', INDUZI_VERSION);
$parts[2] = (int)$parts[2] + 1;
$newVersion = implode('.', $parts);
$newDate = date('Y-m-d');
$versionContent = preg_replace("/INDUZI_VERSION',\s*'[^']+'/", "INDUZI_VERSION', '$newVersion'", $versionContent);
$versionContent = preg_replace("/INDUZI_VERSION_DATE',\s*'[^']+'/", "INDUZI_VERSION_DATE', '$newDate'", $versionContent);
file_put_contents($versionFile, $versionContent);

// Recarregar constantes com novos valores
// (as constantes ja definidas nao mudam, usar variaveis)
$currentVersion = $newVersion;
$currentDate = $newDate;

$tempDir = $rootDir . DIRECTORY_SEPARATOR . 'sys_temp';

// Criar diretorio temporario se nao existir
if (!is_dir($tempDir)) {
    mkdir($tempDir, 0755, true);
}

$zipName = 'induzi-update-' . $currentVersion . '.zip';
$zipPath = $tempDir . DIRECTORY_SEPARATOR . $zipName;

// Remover ZIP anterior se existir
if (file_exists($zipPath)) {
    unlink($zipPath);
}

$zip = new ZipArchive();
$result = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

if ($result !== true) {
    jsonResponse(['ok' => false, 'msg' => 'Erro ao criar arquivo ZIP.'], 500);
}

// Prefixos de diretorios a excluir (match por strpos === 0)
$excludeDirPrefixes = [
    'uploads',
    'sys_temp',
    '.claude',
    '.git',
    'node_modules',
];

$excludeFiles = [
    'config.php',
    'install.php',
];

// Arquivos dentro de diretorios excluidos que devem ser incluidos mesmo assim
$forceInclude = [
    'uploads/.htaccess',
];

/**
 * Adiciona arquivos recursivamente ao ZIP
 */
function addFilesToZip(ZipArchive $zip, string $dir, string $rootDir, array $excludePrefixes, array $excludeFiles, array $forceInclude): void {
    $iterator = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);

    foreach ($files as $file) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootDir) + 1);
        // Normalizar separadores para /
        $relativePath = str_replace('\\', '/', $relativePath);

        // Verificar se esta na lista de inclusao forcada
        if (in_array($relativePath, $forceInclude)) {
            $zip->addFile($filePath, $relativePath);
            continue;
        }

        // Verificar se esta em diretorio excluido (match por prefixo)
        $skip = false;
        foreach ($excludePrefixes as $prefix) {
            if (strpos($relativePath, $prefix) === 0) {
                $skip = true;
                break;
            }
        }
        if ($skip) continue;

        // Verificar arquivo excluido (apenas na raiz)
        if ($file->isFile()) {
            $basename = basename($relativePath);
            $dirPart = dirname($relativePath);
            if ($dirPart === '.' && in_array($basename, $excludeFiles)) {
                continue;
            }

            $zip->addFile($filePath, $relativePath);
        } elseif ($file->isDir()) {
            $zip->addEmptyDir($relativePath);
        }
    }
}

addFilesToZip($zip, $rootDir, $rootDir, $excludeDirPrefixes, $excludeFiles, $forceInclude);

$fileCount = $zip->numFiles;
$zip->close();

if (!file_exists($zipPath)) {
    jsonResponse(['ok' => false, 'msg' => 'Erro ao gerar pacote ZIP.'], 500);
}

$fileSize = filesize($zipPath);

$db = getDB();
logActivity($db, null, $session['userId'], 'gerar_pacote', [
    'versao' => $currentVersion,
    'arquivos' => $fileCount,
]);

// Enviar ZIP como download direto
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zipName . '"');
header('Content-Length: ' . $fileSize);
header('X-File-Count: ' . $fileCount);
header('X-Version: ' . $currentVersion);
header('Cache-Control: no-store');

readfile($zipPath);

// Limpar arquivo temporario
unlink($zipPath);
exit;
