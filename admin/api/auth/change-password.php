<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('POST');
$session = requireAuth();
$input = getJsonInput();
requireFields($input, ['senha_atual', 'nova_senha']);

if (strlen($input['nova_senha']) < 6) {
    jsonResponse(['ok' => false, 'msg' => 'Nova senha deve ter no minimo 6 caracteres.'], 400);
}

$db = getDB();
$stmt = $db->prepare('SELECT senha_hash FROM users WHERE id = ?');
$stmt->execute([$session['userId']]);
$user = $stmt->fetch();

if (!$user || !password_verify($input['senha_atual'], $user['senha_hash'])) {
    jsonResponse(['ok' => false, 'msg' => 'Senha atual incorreta.'], 401);
}

$hash = password_hash($input['nova_senha'], PASSWORD_BCRYPT);
$stmt = $db->prepare('UPDATE users SET senha_hash = ? WHERE id = ?');
$stmt->execute([$hash, $session['userId']]);

logActivity($db, $session['userId'], 'change_password', []);

jsonResponse(['ok' => true, 'msg' => 'Senha alterada com sucesso.']);
