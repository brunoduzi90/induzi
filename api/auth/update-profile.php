<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('POST');
$session = requireAuth();
$input = getJsonInput();

$nome = trim($input['nome'] ?? '');
if (!$nome) jsonResponse(['ok' => false, 'msg' => 'Nome é obrigatório.'], 400);
if (strlen($nome) > 100) jsonResponse(['ok' => false, 'msg' => 'Nome muito longo.'], 400);

$db = getDB();
$stmt = $db->prepare('UPDATE users SET nome = ? WHERE id = ?');
$stmt->execute([$nome, $session['userId']]);

$_SESSION['induzi_user']['nome'] = $nome;

jsonResponse(['ok' => true]);
