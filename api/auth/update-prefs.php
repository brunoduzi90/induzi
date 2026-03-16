<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('POST');
$session = requireAuth();
$input = getJsonInput();

$prefs = $input['preferencias'] ?? [];
if (!is_array($prefs)) jsonResponse(['ok' => false, 'msg' => 'Preferencias invalidas.'], 400);

$db = getDB();
$stmt = $db->prepare('SELECT preferencias FROM users WHERE id = ?');
$stmt->execute([$session['userId']]);
$row = $stmt->fetch();

$current = $row && $row['preferencias'] ? json_decode($row['preferencias'], true) : [];
if (!is_array($current)) $current = [];
$merged = array_merge($current, $prefs);

$stmt = $db->prepare('UPDATE users SET preferencias = ? WHERE id = ?');
$stmt->execute([json_encode($merged, JSON_UNESCAPED_UNICODE), $session['userId']]);

jsonResponse(['ok' => true]);
