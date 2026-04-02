<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('GET');
requireAuth();
session_write_close();

$db = getDB();
$stmt = $db->query('SELECT chave, valor FROM configuracoes');
$config = [];
while ($row = $stmt->fetch()) {
    $config[$row['chave']] = $row['valor'];
}

jsonResponse(['ok' => true, 'config' => $config]);
