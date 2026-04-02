<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('GET');
requireAdmin();
session_write_close();

$db = getDB();
$stmt = $db->query('SELECT id, nome, email, role, telefone, created_at, updated_at FROM users ORDER BY created_at DESC');
$users = $stmt->fetchAll();

jsonResponse(['ok' => true, 'users' => $users]);
