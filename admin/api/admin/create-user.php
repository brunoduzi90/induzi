<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('POST');
$session = requireAdmin();
$input = getJsonInput();
requireFields($input, ['nome', 'email', 'senha']);

if (strlen($input['senha']) < 6) {
    jsonResponse(['ok' => false, 'msg' => 'Senha deve ter no minimo 6 caracteres.'], 400);
}

$db = getDB();

$stmt = $db->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$input['email']]);
if ($stmt->fetch()) {
    jsonResponse(['ok' => false, 'msg' => 'Email ja cadastrado.'], 409);
}

$hash = password_hash($input['senha'], PASSWORD_BCRYPT);
$role = in_array($input['role'] ?? '', ['admin', 'editor']) ? $input['role'] : 'editor';

$stmt = $db->prepare('INSERT INTO users (nome, email, senha_hash, role, telefone) VALUES (?, ?, ?, ?, ?)');
$stmt->execute([$input['nome'], $input['email'], $hash, $role, $input['telefone'] ?? '']);

$id = (int)$db->lastInsertId();
logActivity($db, $session['userId'], 'user_create', ['id' => $id, 'email' => $input['email']]);

jsonResponse(['ok' => true, 'id' => $id, 'msg' => 'Usuario criado.']);
