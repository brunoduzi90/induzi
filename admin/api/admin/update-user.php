<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('POST');
$session = requireAdmin();
$input = getJsonInput();
requireFields($input, ['id', 'nome', 'email']);

$db = getDB();
$id = (int)$input['id'];

$stmt = $db->prepare('SELECT id FROM users WHERE email = ? AND id != ?');
$stmt->execute([$input['email'], $id]);
if ($stmt->fetch()) {
    jsonResponse(['ok' => false, 'msg' => 'Email ja usado por outro usuario.'], 409);
}

$role = in_array($input['role'] ?? '', ['admin', 'editor']) ? $input['role'] : 'editor';

$stmt = $db->prepare('UPDATE users SET nome=?, email=?, role=?, telefone=? WHERE id=?');
$stmt->execute([$input['nome'], $input['email'], $role, $input['telefone'] ?? '', $id]);

if (!empty($input['senha']) && strlen($input['senha']) >= 6) {
    $hash = password_hash($input['senha'], PASSWORD_BCRYPT);
    $stmt = $db->prepare('UPDATE users SET senha_hash = ? WHERE id = ?');
    $stmt->execute([$hash, $id]);
}

logActivity($db, $session['userId'], 'user_update', ['id' => $id]);

jsonResponse(['ok' => true, 'msg' => 'Usuario atualizado.']);
