<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

if (session_status() === PHP_SESSION_NONE) session_start();

requireMethod('POST');

$input = getJsonInput();
$token = trim($input['token'] ?? '');
$novaSenha = $input['senha'] ?? '';

if (!$token) {
    jsonResponse(['ok' => false, 'msg' => 'Token obrigatorio.'], 400);
}
if (strlen($novaSenha) < 8) {
    jsonResponse(['ok' => false, 'msg' => 'Senha deve ter no minimo 8 caracteres.'], 400);
}

$db = getDB();
$tokenHash = hash('sha256', $token);

$stmt = $db->prepare('SELECT * FROM password_resets WHERE token_hash = ? AND usado = 0 AND expires_at > NOW() ORDER BY id DESC LIMIT 1');
$stmt->execute([$tokenHash]);
$reset = $stmt->fetch();

if (!$reset) {
    jsonResponse(['ok' => false, 'msg' => 'Token invalido ou expirado.'], 400);
}

// Update password
$stmt = $db->prepare('UPDATE users SET senha_hash = ? WHERE email = ?');
$stmt->execute([password_hash($novaSenha, PASSWORD_BCRYPT), $reset['email']]);

// Mark token as used
$stmt = $db->prepare('UPDATE password_resets SET usado = 1 WHERE id = ?');
$stmt->execute([$reset['id']]);

// Invalidate all other tokens for this email
$stmt = $db->prepare('UPDATE password_resets SET usado = 1 WHERE email = ? AND usado = 0');
$stmt->execute([$reset['email']]);

jsonResponse(['ok' => true, 'msg' => 'Senha alterada com sucesso!']);
