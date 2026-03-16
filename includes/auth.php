<?php
/**
 * Induzi — Guards de autenticacao para API
 */
$isSecure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
         || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.sid_length', '48');
    ini_set('session.sid_bits_per_character', '6');
    session_set_cookie_params([
        'lifetime'  => 28800,
        'path'      => '/',
        'httponly'   => true,
        'samesite'   => 'Lax',
        'secure'     => $isSecure,
    ]);
    session_start();
}

$maxIdle = 7200;
if (!empty($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $maxIdle) {
    $_SESSION = [];
    session_destroy();
    session_start();
}
$_SESSION['last_activity'] = time();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function getSessionData(): ?array {
    return $_SESSION['induzi_user'] ?? null;
}

function requireAuth(): array {
    $session = getSessionData();
    if (!$session || empty($session['userId'])) {
        jsonResponse(['ok' => false, 'msg' => 'Nao autenticado.'], 401);
    }
    return $session;
}

function requireProject(): array {
    $session = requireAuth();
    if (empty($session['projectId'])) {
        jsonResponse(['ok' => false, 'msg' => 'Nenhum projeto selecionado.'], 403);
    }
    return $session;
}

function requireAdmin(): array {
    $session = requireAuth();
    if (($session['role'] ?? '') !== 'admin') {
        jsonResponse(['ok' => false, 'msg' => 'Acesso restrito a administradores.'], 403);
    }
    return $session;
}

function isReadOnly(): bool {
    $session = getSessionData();
    if (!$session || empty($session['userId']) || empty($session['projectId'])) return true;
    $projectId = (int)$session['projectId'];
    $db = getDB();
    $stmt = $db->prepare('SELECT user_id FROM projects WHERE id = ?');
    $stmt->execute([$projectId]);
    $project = $stmt->fetch();
    if ($project && (int)$project['user_id'] === (int)$session['userId']) return false;
    $stmt = $db->prepare('SELECT permissao FROM project_users WHERE project_id = ? AND user_id = ?');
    $stmt->execute([$projectId, $session['userId']]);
    $row = $stmt->fetch();
    return !$row || $row['permissao'] === 'visualizar';
}
