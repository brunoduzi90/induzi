<?php
/**
 * Induzi - Listar e deletar backups
 * GET admin-only
 * POST admin-only + CSRF para deletar um backup
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireAdmin();

$rootDir = realpath(__DIR__ . '/../../');
$backupDir = $rootDir . DIRECTORY_SEPARATOR . 'sys_temp' . DIRECTORY_SEPARATOR . 'backups';

// Acao de deletar (POST com CSRF)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();
    $input = getJsonInput();
    $file = $input['file'] ?? '';

    // Validar nome do arquivo (prevenir path traversal)
    if (empty($file) || preg_match('/[\/\\\\]/', $file) || strpos($file, '..') !== false) {
        jsonResponse(['ok' => false, 'msg' => 'Nome de arquivo invalido.'], 400);
    }

    // Verificar que e um backup valido
    if (!preg_match('/^backup-v[\w._-]+-\d{8}-\d{6}\.zip$/', $file)) {
        jsonResponse(['ok' => false, 'msg' => 'Nome de arquivo invalido.'], 400);
    }

    $filePath = $backupDir . DIRECTORY_SEPARATOR . $file;

    if (!file_exists($filePath)) {
        jsonResponse(['ok' => false, 'msg' => 'Backup nao encontrado.'], 404);
    }

    if (@unlink($filePath)) {
        jsonResponse(['ok' => true, 'msg' => 'Backup excluido com sucesso.']);
    } else {
        jsonResponse(['ok' => false, 'msg' => 'Erro ao excluir backup.'], 500);
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(['ok' => false, 'msg' => 'Metodo nao permitido.'], 405);
}

// Listar backups
$backups = [];

if (is_dir($backupDir)) {
    $files = glob($backupDir . DIRECTORY_SEPARATOR . 'backup-v*.zip');
    if ($files !== false) {
        foreach ($files as $filePath) {
            $fileName = basename($filePath);
            $size = filesize($filePath);
            $mtime = filemtime($filePath);

            // Extrair versao do nome: backup-vVERSAO-TIMESTAMP.zip
            $version = '?';
            if (preg_match('/^backup-v(.+)-\d{8}-\d{6}\.zip$/', $fileName, $m)) {
                $version = $m[1];
            }

            $backups[] = [
                'file' => $fileName,
                'version' => $version,
                'size' => $size,
                'date' => date('Y-m-d H:i:s', $mtime),
                'timestamp' => $mtime,
            ];
        }

        // Ordenar por data (mais recente primeiro)
        usort($backups, function($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });
    }
}

jsonResponse([
    'ok' => true,
    'data' => $backups,
]);
