<?php
/**
 * Sessao, CSRF e Guards de autorizacao — INDUZI
 */

if (session_status() === PHP_SESSION_NONE) {
    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    ini_set('session.sid_length', '48');
    ini_set('session.sid_bits_per_character', '6');
    session_set_cookie_params([
        'lifetime'  => 28800,
        'path'      => '/',
        'httponly'   => true,
        'samesite'  => 'Lax',
        'secure'    => $isSecure,
    ]);
    session_start();
}

// Idle timeout: 2 horas (normal) ou 30 dias (manter conectado)
$maxIdle = !empty($_SESSION['remember_me']) ? 2592000 : 7200;
if (!empty($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $maxIdle) {
    $_SESSION = [];
    session_destroy();
    session_start();
}
$_SESSION['last_activity'] = time();

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Requer autenticacao — redireciona ou retorna 401
 */
function requireAuth(): array {
    if (empty($_SESSION['induzi_user']['userId'])) {
        $isApi = strpos($_SERVER['REQUEST_URI'], '/api/') !== false;
        if ($isApi) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['ok' => false, 'msg' => 'Nao autenticado.']);
            exit;
        }
        header('Location: ' . getBasePath() . 'login.php');
        exit;
    }
    return $_SESSION['induzi_user'];
}

/**
 * Requer role admin
 */
function requireAdmin(): array {
    $session = requireAuth();
    if (($session['role'] ?? '') !== 'admin') {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(['ok' => false, 'msg' => 'Acesso restrito.']);
        exit;
    }
    return $session;
}

/**
 * Retorna dados da sessao
 */
function getSessionData(): ?array {
    return $_SESSION['induzi_user'] ?? null;
}

/**
 * Calcula base path do projeto
 */
function getBasePath(): string {
    $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
    if (strpos($scriptDir, '/api/') !== false || strpos($scriptDir, '/pages/') !== false) {
        return dirname($scriptDir, 2) . '/';
    }
    if (strpos($scriptDir, '/includes/') !== false) {
        return dirname($scriptDir) . '/';
    }
    return rtrim($scriptDir, '/') . '/';
}
