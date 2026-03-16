<?php
/**
 * Induzi — Funcoes auxiliares para API
 */
function jsonResponse(array $data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, private, max-age=0');
    header('Pragma: no-cache');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function _getRawInput(): string {
    static $raw = null;
    if ($raw === null) {
        $raw = file_get_contents('php://input') ?: '';
    }
    return $raw;
}

function getJsonInput(): array {
    $raw = _getRawInput();
    if (strlen($raw) > 1048576) {
        jsonResponse(['ok' => false, 'msg' => 'Payload muito grande.'], 413);
    }
    $data = json_decode($raw, true, 64);
    return is_array($data) ? $data : [];
}

function requireCsrf(): void {
    $xrw = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
    if (strcasecmp($xrw, 'XMLHttpRequest') === 0) return;
    if (!empty($_SESSION['induzi_user']['userId'])) return;
    $fromHeader = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    $sessionToken = $_SESSION['csrf_token'] ?? '';
    if (!empty($fromHeader) && !empty($sessionToken) && hash_equals($sessionToken, $fromHeader)) return;
    jsonResponse(['ok' => false, 'msg' => 'CSRF validation failed.'], 403);
}

function requireMethod(string $method): void {
    if ($_SERVER['REQUEST_METHOD'] !== strtoupper($method)) {
        jsonResponse(['ok' => false, 'msg' => 'Metodo nao permitido.'], 405);
    }
    if (strtoupper($method) === 'POST') requireCsrf();
}

function requireFields(array $input, array $fields): void {
    foreach ($fields as $f) {
        if (!isset($input[$f]) || (is_string($input[$f]) && trim($input[$f]) === '')) {
            jsonResponse(['ok' => false, 'msg' => "Campo obrigatorio: $f"], 400);
        }
    }
}

function getAllowedDataKeys(): array {
    return [
        'induziCopywriter',
        'induziEstrutura',
        'induziSeguranca',
        'induziSeo',
        'induziShopee',
        'induziTarefas',
        'induziLinks',
        'induziConcorrentes',
        'induziNotas',
        'induziConfig',
        'induziProgressHistory',
        'induziBranding',
        'induziGoogleAds',
        'induziPerformance',
        'induziAnalytics',
        'induziUxDesign',
        'induziAcessibilidade',
        'induziConteudo',
        'induziCro',
        'induziEmailMarketing',
        'induziRedesSociais',
        'induziMetaAds',
        'induziInfraestrutura',
        'induziSiteAudit',
        'induziMercadoLivre',
    ];
}

function logActivity(PDO $db, ?int $projectId, ?int $userId, string $action, ?array $details = null): void {
    try {
        // Check if table exists
        $tables = $db->query("SHOW TABLES LIKE 'activity_log'")->fetchAll();
        if (empty($tables)) return;
        $stmt = $db->prepare('INSERT INTO activity_log (project_id, user_id, action, details) VALUES (?, ?, ?, ?)');
        $stmt->execute([$projectId, $userId, $action, $details ? json_encode($details, JSON_UNESCAPED_UNICODE) : null]);
    } catch (PDOException $e) {}
}

function checkRateLimit(PDO $db, string $ip, ?string $email = null): bool {
    try {
        $db->exec("DELETE FROM login_attempts WHERE attempted_at < DATE_SUB(NOW(), INTERVAL 1 HOUR)");
    } catch (PDOException $e) { return true; }
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

function recordLoginAttempt(PDO $db, string $ip, string $email): void {
    try {
        $stmt = $db->prepare('INSERT INTO login_attempts (ip_address, email) VALUES (?, ?)');
        $stmt->execute([$ip, $email]);
    } catch (PDOException $e) {}
}

function clearLoginAttempts(PDO $db, string $email): void {
    try {
        $stmt = $db->prepare('DELETE FROM login_attempts WHERE email = ?');
        $stmt->execute([$email]);
    } catch (PDOException $e) {}
}
