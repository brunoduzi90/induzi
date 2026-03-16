<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

if (session_status() === PHP_SESSION_NONE) session_start();

requireMethod('POST');

$input = getJsonInput();
$email = trim(strtolower($input['email'] ?? ''));

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['ok' => false, 'msg' => 'Email invalido.'], 400);
}

$db = getDB();

// Rate limit: max 3 resets per email per hour
$stmt = $db->prepare('SELECT COUNT(*) as c FROM password_resets WHERE email = ? AND expires_at > NOW() AND usado = 0');
$stmt->execute([$email]);
if ((int)$stmt->fetch()['c'] >= 3) {
    jsonResponse(['ok' => false, 'msg' => 'Muitas tentativas. Aguarde antes de tentar novamente.'], 429);
}

// Check if user exists
$stmt = $db->prepare('SELECT id, nome FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    // Don't reveal if email exists — return success anyway
    jsonResponse(['ok' => true, 'msg' => 'Se o email estiver cadastrado, o link de recuperacao sera gerado.']);
}

// Generate token
$token = bin2hex(random_bytes(32));
$tokenHash = hash('sha256', $token);
$expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1 hour

$stmt = $db->prepare('INSERT INTO password_resets (email, token_hash, expires_at) VALUES (?, ?, ?)');
$stmt->execute([$email, $tokenHash, $expiresAt]);

// Build reset link (local XAMPP — show directly)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$basePath = dirname(dirname(dirname($_SERVER['SCRIPT_NAME'])));
$resetLink = $protocol . '://' . $host . $basePath . '/reset-password.php?token=' . $token;

jsonResponse([
    'ok' => true,
    'msg' => 'Link de recuperacao gerado!',
    'resetLink' => $resetLink
]);
