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

if (!empty($_GET['status']) && in_array($_GET['status'], ['novo', 'contatado', 'convertido', 'descartado'])) {
    $where .= ' AND status = ?';
    $params[] = $_GET['status'];
}

if (!empty($_GET['origem'])) {
    $where .= ' AND origem = ?';
    $params[] = $_GET['origem'];
}

$stmt = $db->prepare("SELECT * FROM leads WHERE $where ORDER BY created_at DESC");
$stmt->execute($params);
$items = $stmt->fetchAll();

// Buscar origens distintas para o filtro
$origens = $db->query("SELECT DISTINCT origem FROM leads WHERE origem IS NOT NULL ORDER BY origem")->fetchAll(PDO::FETCH_COLUMN);

jsonResponse(['ok' => true, 'items' => $items, 'origens' => $origens]);
