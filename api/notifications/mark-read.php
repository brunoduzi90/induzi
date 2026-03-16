<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('POST');
$session = requireAuth();
$input = getJsonInput();

$db = getDB();

// Check if table exists
try {
    $db->query("SELECT 1 FROM notifications LIMIT 1");
} catch (PDOException $e) {
    jsonResponse(['ok' => true]);
}

if (!empty($input['all'])) {
    $stmt = $db->prepare('UPDATE notifications SET lida = 1 WHERE user_id = ? AND lida = 0');
    $stmt->execute([$session['userId']]);
} elseif (!empty($input['id'])) {
    $stmt = $db->prepare('UPDATE notifications SET lida = 1 WHERE id = ? AND user_id = ?');
    $stmt->execute([(int)$input['id'], $session['userId']]);
}

jsonResponse(['ok' => true]);
