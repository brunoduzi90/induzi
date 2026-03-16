<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('POST');
$session = requireAuth();
$input = getJsonInput();

$projectId = $input['projectId'] ?? null;

if ($projectId === null) {
    $_SESSION['induzi_user']['projectId'] = null;
    jsonResponse(['ok' => true]);
}

$db = getDB();
$projectId = (int)$projectId;

$stmt = $db->prepare('SELECT id, nome, user_id FROM projects WHERE id = ?');
$stmt->execute([$projectId]);
$project = $stmt->fetch();

if (!$project) {
    jsonResponse(['ok' => false, 'msg' => 'Projeto nao encontrado.'], 404);
}

$isOwner = (int)$project['user_id'] === (int)$session['userId'];
if (!$isOwner) {
    $stmt = $db->prepare('SELECT permissao FROM project_users WHERE project_id = ? AND user_id = ?');
    $stmt->execute([$projectId, $session['userId']]);
    if (!$stmt->fetch()) {
        jsonResponse(['ok' => false, 'msg' => 'Voce nao tem acesso a este projeto.'], 403);
    }
}

session_regenerate_id(true);
$_SESSION['induzi_user']['projectId'] = $projectId;

jsonResponse([
    'ok'      => true,
    'project' => [
        'id'   => (int)$project['id'],
        'nome' => $project['nome'],
    ]
]);
