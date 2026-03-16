<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('POST');

$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
$raw = file_get_contents('php://input');

if (stripos($contentType, 'text/plain') !== false && !empty($raw) && $raw[0] !== '{') {
    $b64 = strtr($raw, '-_', '+/');
    $pad = strlen($b64) % 4;
    if ($pad) $b64 .= str_repeat('=', 4 - $pad);
    $decoded = base64_decode($b64, true);
    if ($decoded === false) jsonResponse(['ok' => false, 'msg' => 'Payload base64 invalido.'], 400);
    $input = json_decode($decoded, true);
    if (!is_array($input)) jsonResponse(['ok' => false, 'msg' => 'JSON invalido.'], 400);
} else {
    $input = json_decode($raw, true);
    if (!is_array($input)) jsonResponse(['ok' => false, 'msg' => 'Payload invalido.'], 400);
}

$key   = $input['key'] ?? '';
$value = $input['value'] ?? null;
if (!$key) jsonResponse(['ok' => false, 'msg' => 'Chave obrigatoria.'], 400);

$session = requireProject();
if (isReadOnly()) {
    jsonResponse(['ok' => false, 'msg' => 'Modo somente leitura.'], 403);
}

$projectId = $session['projectId'];
$db = getDB();

$allowed = getAllowedDataKeys();
if (!in_array($key, $allowed)) {
    jsonResponse(['ok' => false, 'msg' => 'Chave nao permitida.'], 400);
}

$jsonValue = json_encode($value, JSON_UNESCAPED_UNICODE);
$userId = $session['userId'] ?? null;
$stmt = $db->prepare('INSERT INTO project_data (project_id, data_key, data_value, updated_by) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE data_value = VALUES(data_value), updated_by = VALUES(updated_by)');
$stmt->execute([$projectId, $key, $jsonValue, $userId]);

logActivity($db, $projectId, $userId, 'data.save', ['key' => $key]);

jsonResponse(['ok' => true]);
