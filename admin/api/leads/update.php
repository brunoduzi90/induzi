<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('POST');
$session = requireAuth();
$input = getJsonInput();
requireFields($input, ['id', 'status']);

$validStatuses = ['novo', 'contatado', 'convertido', 'descartado'];
if (!in_array($input['status'], $validStatuses)) {
    jsonResponse(['ok' => false, 'msg' => 'Status invalido.'], 400);
}

$db = getDB();
$id = (int)$input['id'];

$stmt = $db->prepare('UPDATE leads SET status = ? WHERE id = ?');
$stmt->execute([$input['status'], $id]);

logActivity($db, $session['userId'], 'lead_status_update', ['id' => $id, 'status' => $input['status']]);

jsonResponse(['ok' => true, 'msg' => 'Status atualizado.']);
