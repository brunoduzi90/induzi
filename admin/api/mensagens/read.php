<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('POST');
requireAuth();
$input = getJsonInput();
requireFields($input, ['id']);

$db = getDB();
$stmt = $db->prepare('UPDATE mensagens SET lida = 1 WHERE id = ?');
$stmt->execute([(int)$input['id']]);

$stmt = $db->prepare('SELECT * FROM mensagens WHERE id = ?');
$stmt->execute([(int)$input['id']]);
$msg = $stmt->fetch();

jsonResponse(['ok' => true, 'mensagem' => $msg]);
