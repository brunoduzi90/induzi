<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('GET');

$key = $_GET['key'] ?? '';
if (!$key) jsonResponse(['ok' => false, 'msg' => 'Chave obrigatoria.'], 400);

$session = requireProject();
$projectId = $session['projectId'];
$db = getDB();

$allowed = getAllowedDataKeys();
if (!in_array($key, $allowed)) {
    jsonResponse(['ok' => false, 'msg' => 'Chave nao permitida.'], 400);
}

$stmt = $db->prepare('SELECT data_value FROM project_data WHERE project_id = ? AND data_key = ?');
$stmt->execute([$projectId, $key]);
$row = $stmt->fetch();
$value = $row ? json_decode($row['data_value'], true) : null;

jsonResponse(['ok' => true, 'key' => $key, 'value' => $value]);
