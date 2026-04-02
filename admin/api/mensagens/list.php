<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('GET');
requireAuth();
session_write_close();

$db = getDB();
$stmt = $db->query('SELECT * FROM mensagens ORDER BY created_at DESC');
$mensagens = $stmt->fetchAll();

jsonResponse(['ok' => true, 'mensagens' => $mensagens]);
