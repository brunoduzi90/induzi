<?php
/**
 * Helpers da API — funcoes utilitarias para todos os endpoints — INDUZI
 */

/**
 * Resposta JSON e encerra
 */
function jsonResponse(array $data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, private, max-age=0');
    header('Pragma: no-cache');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * Le JSON do body (max 1MB, depth 64)
 */
function getJsonInput(): array {
    $raw = file_get_contents('php://input');
    if (strlen($raw) > 1048576) {
        jsonResponse(['ok' => false, 'msg' => 'Payload muito grande.'], 413);
    }
    $data = json_decode($raw, true, 64);
    return is_array($data) ? $data : [];
}

/**
 * Valida CSRF
 */
function requireCsrf(): void {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        return;
    }
    if (!empty($_SESSION['induzi_user']['userId'])) {
        return;
    }
    $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!empty($token) && hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        return;
    }
    jsonResponse(['ok' => false, 'msg' => 'CSRF invalido.'], 403);
}

/**
 * Valida metodo HTTP (CSRF automatico para POST)
 */
function requireMethod(string $method): void {
    if ($_SERVER['REQUEST_METHOD'] !== strtoupper($method)) {
        jsonResponse(['ok' => false, 'msg' => 'Metodo nao permitido.'], 405);
    }
    if (strtoupper($method) === 'POST') {
        requireCsrf();
    }
}

/**
 * Valida campos obrigatorios
 */
function requireFields(array $input, array $fields): void {
    foreach ($fields as $f) {
        if (!isset($input[$f]) || (is_string($input[$f]) && trim($input[$f]) === '')) {
            jsonResponse(['ok' => false, 'msg' => "Campo obrigatorio: $f"], 400);
        }
    }
}

/**
 * Registra atividade no log
 */
function logActivity(PDO $db, ?int $userId, string $action, array $details = []): void {
    $stmt = $db->prepare('INSERT INTO activity_log (user_id, action, details, created_at) VALUES (?, ?, ?, NOW())');
    $stmt->execute([$userId, $action, json_encode($details, JSON_UNESCAPED_UNICODE)]);
}

/**
 * Rate limiting
 */
function checkRateLimit(PDO $db, string $ip, ?string $email = null): bool {
    $db->exec("DELETE FROM login_attempts WHERE attempted_at < DATE_SUB(NOW(), INTERVAL 1 HOUR)");

    $stmt = $db->prepare('SELECT COUNT(*) as c FROM login_attempts WHERE ip_address = ? AND attempted_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)');
    $stmt->execute([$ip]);
    if ((int)$stmt->fetch()['c'] >= 20) return false;

    if ($email) {
        $stmt = $db->prepare('SELECT COUNT(*) as c FROM login_attempts WHERE email = ? AND attempted_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)');
        $stmt->execute([$email]);
        if ((int)$stmt->fetch()['c'] >= 5) return false;
    }

    return true;
}

/**
 * Registra tentativa de login
 */
function logLoginAttempt(PDO $db, string $ip, string $email): void {
    $stmt = $db->prepare('INSERT INTO login_attempts (ip_address, email, attempted_at) VALUES (?, ?, NOW())');
    $stmt->execute([$ip, $email]);
}

/**
 * Gera slug URL-safe a partir de string
 */
function slugify(string $text): string {
    $text = mb_strtolower($text, 'UTF-8');
    $text = preg_replace('/[áàãâä]/u', 'a', $text);
    $text = preg_replace('/[éèêë]/u', 'e', $text);
    $text = preg_replace('/[íìîï]/u', 'i', $text);
    $text = preg_replace('/[óòõôö]/u', 'o', $text);
    $text = preg_replace('/[úùûü]/u', 'u', $text);
    $text = preg_replace('/[ç]/u', 'c', $text);
    $text = preg_replace('/[ñ]/u', 'n', $text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

/**
 * Escapa string para HTML
 */
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
