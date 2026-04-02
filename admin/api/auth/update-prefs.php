<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('POST');
$session = requireAuth();
$input = getJsonInput();

$db = getDB();
$stmt = $db->prepare('SELECT preferencias FROM users WHERE id = ?');
$stmt->execute([$session['userId']]);
$user = $stmt->fetch();

$prefs = json_decode($user['preferencias'] ?? '{}', true) ?: [];
$prefs = array_merge($prefs, $input);

$stmt = $db->prepare('UPDATE users SET preferencias = ? WHERE id = ?');
$stmt->execute([json_encode($prefs, JSON_UNESCAPED_UNICODE), $session['userId']]);

$_SESSION['induzi_user']['preferencias'] = $prefs;

jsonResponse(['ok' => true]);
