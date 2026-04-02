<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('POST');
$input = getJsonInput();
requireFields($input, ['email', 'senha']);

$db = getDB();
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

if (!checkRateLimit($db, $ip, $input['email'])) {
    jsonResponse(['ok' => false, 'msg' => 'Muitas tentativas. Aguarde 15 minutos.'], 429);
}

$stmt = $db->prepare('SELECT id, nome, email, senha_hash, role, preferencias FROM users WHERE email = ?');
$stmt->execute([$input['email']]);
$user = $stmt->fetch();

if (!$user || !password_verify($input['senha'], $user['senha_hash'])) {
    logLoginAttempt($db, $ip, $input['email']);
    jsonResponse(['ok' => false, 'msg' => 'Email ou senha incorretos.'], 401);
}

session_regenerate_id(true);
$_SESSION['induzi_user'] = [
    'userId'       => (int)$user['id'],
    'nome'         => $user['nome'],
    'email'        => $user['email'],
    'role'         => $user['role'],
    'preferencias' => json_decode($user['preferencias'] ?? '{}', true) ?: [],
];
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$_SESSION['last_activity'] = time();

logActivity($db, (int)$user['id'], 'login', ['ip' => $ip]);

jsonResponse([
    'ok' => true,
    'user' => ['id' => (int)$user['id'], 'nome' => $user['nome'], 'email' => $user['email'], 'role' => $user['role']],
    'csrfToken' => $_SESSION['csrf_token'],
]);
