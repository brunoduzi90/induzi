<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('POST');
$session = requireAuth();
$input = getJsonInput();
requireFields($input, ['id']);

$db = getDB();
$stmt = $db->prepare('DELETE FROM mensagens WHERE id = ?');
$stmt->execute([(int)$input['id']]);

logActivity($db, $session['userId'], 'mensagem_delete', ['id' => (int)$input['id']]);

jsonResponse(['ok' => true, 'msg' => 'Mensagem excluida.']);
