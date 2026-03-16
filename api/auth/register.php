<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('POST');
$session = requireAdmin();
$input = getJsonInput();
requireFields($input, ['nome', 'email', 'senha']);

$db = getDB();
$nome  = trim($input['nome']);
$email = strtolower(trim($input['email']));
$senha = $input['senha'];
$role  = $input['role'] ?? 'cliente';

if (!in_array($role, ['admin', 'cliente'])) {
    jsonResponse(['ok' => false, 'msg' => 'Role invalido.'], 400);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['ok' => false, 'msg' => 'Email invalido.'], 400);
}
if (strlen($senha) < 8) {
    jsonResponse(['ok' => false, 'msg' => 'Senha deve ter no minimo 8 caracteres.'], 400);
}

$stmt = $db->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    jsonResponse(['ok' => false, 'msg' => 'Email ja cadastrado.'], 409);
}

$stmt = $db->prepare('INSERT INTO users (nome, email, senha_hash, role) VALUES (?, ?, ?, ?)');
$stmt->execute([$nome, $email, password_hash($senha, PASSWORD_BCRYPT), $role]);

jsonResponse([
    'ok'   => true,
    'user' => [
        'id'    => (int)$db->lastInsertId(),
        'nome'  => $nome,
        'email' => $email,
        'role'  => $role,
    ]
]);
