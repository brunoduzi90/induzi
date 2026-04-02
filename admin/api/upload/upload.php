<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['ok' => false, 'msg' => 'Metodo nao permitido.'], 405);
}

if (empty($_FILES['file'])) {
    jsonResponse(['ok' => false, 'msg' => 'Nenhum arquivo enviado.'], 400);
}

$file = $_FILES['file'];
$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif', 'image/svg+xml'];
$maxSize = 10 * 1024 * 1024; // 10MB

if ($file['error'] !== UPLOAD_ERR_OK) {
    jsonResponse(['ok' => false, 'msg' => 'Erro no upload.'], 400);
}

if ($file['size'] > $maxSize) {
    jsonResponse(['ok' => false, 'msg' => 'Arquivo muito grande (max 10MB).'], 400);
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);

if (!in_array($mime, $allowed, true)) {
    jsonResponse(['ok' => false, 'msg' => 'Tipo de arquivo nao permitido.'], 400);
}

$ext = match($mime) {
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/gif'  => 'gif',
    'image/webp' => 'webp',
    'image/avif' => 'avif',
    'image/svg+xml' => 'svg',
    default => 'bin',
};

$uploadDir = __DIR__ . '/../../../storage/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$filename = date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
$destination = $uploadDir . $filename;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    jsonResponse(['ok' => false, 'msg' => 'Erro ao salvar arquivo.'], 500);
}

$publicUrl = '/Site/storage/uploads/' . $filename;

jsonResponse(['ok' => true, 'url' => $publicUrl, 'filename' => $filename]);
