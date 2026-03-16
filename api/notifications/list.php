<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('GET');
$session = requireAuth();

$db = getDB();

// Check if table exists
try {
    $db->query("SELECT 1 FROM notifications LIMIT 1");
} catch (PDOException $e) {
    jsonResponse(['ok' => true, 'notifications' => []]);
}

$stmt = $db->prepare('SELECT id, tipo, titulo, mensagem, link, lida, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 50');
$stmt->execute([$session['userId']]);
$notifications = $stmt->fetchAll();

foreach ($notifications as &$n) {
    $n['id'] = (int)$n['id'];
    $n['lida'] = (int)$n['lida'];
}

jsonResponse(['ok' => true, 'notifications' => $notifications]);
