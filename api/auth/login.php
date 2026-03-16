<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('POST');
$input = getJsonInput();
requireFields($input, ['identificador', 'senha']);

$db = getDB();
$id = strtolower(trim($input['identificador']));
$senha = $input['senha'];
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

if (!checkRateLimit($db, $ip, $id)) {
    jsonResponse(['ok' => false, 'msg' => 'Muitas tentativas de login. Tente novamente em 15 minutos.'], 429);
}

$stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user || !password_verify($senha, $user['senha_hash'])) {
    recordLoginAttempt($db, $ip, $id);
    jsonResponse(['ok' => false, 'msg' => 'Email ou senha incorretos.'], 401);
}

clearLoginAttempts($db, $id);
session_regenerate_id(true);
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

$_SESSION['induzi_user'] = [
    'userId'    => $user['id'],
    'projectId' => null,
    'role'      => $user['role'],
    'nome'      => $user['nome'],
    'loginTime' => date('c'),
];

jsonResponse([
    'ok'   => true,
    'user' => [
        'id'    => (int)$user['id'],
        'nome'  => $user['nome'],
        'email' => $user['email'],
        'role'  => $user['role'],
    ],
    'csrfToken' => $_SESSION['csrf_token'],
]);
