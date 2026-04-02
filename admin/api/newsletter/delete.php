<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('POST');
$session = requireAuth();
$input = getJsonInput();
requireFields($input, ['id']);

$db = getDB();
$id = (int)$input['id'];

$stmt = $db->prepare('DELETE FROM newsletter WHERE id = ?');
$stmt->execute([$id]);

logActivity($db, $session['userId'], 'newsletter_delete', ['id' => $id]);

jsonResponse(['ok' => true, 'msg' => 'Inscrito removido.']);
