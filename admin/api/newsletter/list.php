<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('GET');
requireAuth();
session_write_close();

$db = getDB();

$where = '1=1';
$params = [];

if (!empty($_GET['status']) && in_array($_GET['status'], ['ativo', 'inativo'])) {
    $where .= ' AND status = ?';
    $params[] = $_GET['status'];
}

$stmt = $db->prepare("SELECT * FROM newsletter WHERE $where ORDER BY created_at DESC");
$stmt->execute($params);
$items = $stmt->fetchAll();

jsonResponse(['ok' => true, 'items' => $items]);
