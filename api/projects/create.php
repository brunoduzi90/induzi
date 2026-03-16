<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('POST');
$session = requireAuth();
$input = getJsonInput();
requireFields($input, ['nome']);

$nome = trim($input['nome']);
$descricao = trim($input['descricao'] ?? '');
if (mb_strlen($nome) > 100) {
    jsonResponse(['ok' => false, 'msg' => 'Nome muito longo (max 100 caracteres).'], 400);
}

$db = getDB();
$stmt = $db->prepare('INSERT INTO projects (nome, descricao, user_id) VALUES (?, ?, ?)');
$stmt->execute([$nome, $descricao, $session['userId']]);

$projectId = (int)$db->lastInsertId();

logActivity($db, $projectId, (int)$session['userId'], 'project.create', ['nome' => $nome]);

jsonResponse([
    'ok'      => true,
    'project' => [
        'id'        => $projectId,
        'nome'      => $nome,
        'descricao' => $descricao,
        'user_id'   => (int)$session['userId'],
    ]
]);
