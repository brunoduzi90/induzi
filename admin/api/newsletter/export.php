<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('GET');
requireAuth();

$db = getDB();
$stmt = $db->query("SELECT nome, email, origem, status, created_at FROM newsletter ORDER BY created_at DESC");
$rows = $stmt->fetchAll();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="newsletter_' . date('Y-m-d') . '.csv"');

$out = fopen('php://output', 'w');
fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8
fputcsv($out, ['Nome', 'Email', 'Origem', 'Status', 'Data Inscricao']);

foreach ($rows as $r) {
    fputcsv($out, [$r['nome'], $r['email'], $r['origem'], $r['status'], $r['created_at']]);
}

fclose($out);
exit;
