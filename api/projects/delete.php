<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('POST');
$session = requireAuth();
$input = getJsonInput();

$projectId = (int)($input['projectId'] ?? 0);
if (!$projectId) jsonResponse(['ok' => false, 'msg' => 'projectId obrigatorio.'], 400);

$db = getDB();
$stmt = $db->prepare('SELECT * FROM projects WHERE id = ?');
$stmt->execute([$projectId]);
$project = $stmt->fetch();

if (!$project || (int)$project['user_id'] !== (int)$session['userId']) {
    jsonResponse(['ok' => false, 'msg' => 'Projeto nao encontrado ou sem permissao.'], 404);
}

logActivity($db, $projectId, (int)$session['userId'], 'project.delete', ['nome' => $project['nome'] ?? null]);

// CASCADE deleta project_data e project_users
$stmt = $db->prepare('DELETE FROM projects WHERE id = ?');
$stmt->execute([$projectId]);

if (($session['projectId'] ?? null) == $projectId) {
    $_SESSION['induzi_user']['projectId'] = null;
}

jsonResponse(['ok' => true]);
