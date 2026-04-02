<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('POST');
requireAuth();
$input = getJsonInput();
requireFields($input, ['filename']);

$filename = basename($input['filename']);
$filepath = __DIR__ . '/../../../storage/uploads/' . $filename;

if (file_exists($filepath)) {
    unlink($filepath);
    jsonResponse(['ok' => true, 'msg' => 'Arquivo excluido.']);
}

jsonResponse(['ok' => false, 'msg' => 'Arquivo nao encontrado.'], 404);
