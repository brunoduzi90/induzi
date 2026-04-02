<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('POST');
$session = requireAdmin();
$input = getJsonInput();
requireFields($input, ['id']);

$id = (int)$input['id'];

if ($id === $session['userId']) {
    jsonResponse(['ok' => false, 'msg' => 'Nao pode excluir sua propria conta.'], 400);
}

$db = getDB();
$stmt = $db->prepare('DELETE FROM users WHERE id = ?');
$stmt->execute([$id]);

logActivity($db, $session['userId'], 'user_delete', ['id' => $id]);

jsonResponse(['ok' => true, 'msg' => 'Usuario excluido.']);
