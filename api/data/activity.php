<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('GET');
$session = requireProject();

$projectId = $session['projectId'];
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 30;
$offset = ($page - 1) * $perPage;

$db = getDB();

// Check if table exists
try {
    $db->query("SELECT 1 FROM activity_log LIMIT 1");
} catch (PDOException $e) {
    jsonResponse(['ok' => true, 'activities' => [], 'total' => 0, 'page' => $page, 'perPage' => $perPage]);
}

// Count total
$stmt = $db->prepare('SELECT COUNT(*) FROM activity_log WHERE project_id = ?');
$stmt->execute([$projectId]);
$total = (int)$stmt->fetchColumn();

// Fetch page
$stmt = $db->prepare('
    SELECT al.id, al.action, al.details, al.created_at, u.nome AS user_nome
    FROM activity_log al
    LEFT JOIN users u ON u.id = al.user_id
    WHERE al.project_id = ?
    ORDER BY al.created_at DESC
    LIMIT ? OFFSET ?
');
$stmt->bindValue(1, $projectId, PDO::PARAM_INT);
$stmt->bindValue(2, $perPage, PDO::PARAM_INT);
$stmt->bindValue(3, $offset, PDO::PARAM_INT);
$stmt->execute();
$activities = $stmt->fetchAll();

foreach ($activities as &$a) {
    $a['id'] = (int)$a['id'];
    $a['details'] = $a['details'] ? json_decode($a['details'], true) : null;
}

jsonResponse([
    'ok' => true,
    'activities' => $activities,
    'total' => $total,
    'page' => $page,
    'perPage' => $perPage
]);
