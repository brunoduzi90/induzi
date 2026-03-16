<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('POST');
$session = requireAuth();
$input = getJsonInput();

$senhaAtual = $input['senha_atual'] ?? '';
$novaSenha = $input['nova_senha'] ?? '';

if (!$senhaAtual) jsonResponse(['ok' => false, 'msg' => 'Informe a senha atual.'], 400);
if (strlen($novaSenha) < 8) jsonResponse(['ok' => false, 'msg' => 'Nova senha deve ter no mínimo 8 caracteres.'], 400);

$db = getDB();
$stmt = $db->prepare('SELECT senha_hash FROM users WHERE id = ?');
$stmt->execute([$session['userId']]);
$row = $stmt->fetch();

if (!$row || !password_verify($senhaAtual, $row['senha_hash'])) {
    jsonResponse(['ok' => false, 'msg' => 'Senha atual incorreta.'], 403);
}

$hash = password_hash($novaSenha, PASSWORD_DEFAULT);
$stmt = $db->prepare('UPDATE users SET senha_hash = ? WHERE id = ?');
$stmt->execute([$hash, $session['userId']]);

jsonResponse(['ok' => true]);
