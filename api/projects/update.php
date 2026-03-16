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

$updates = [];
$params = [];
if (isset($input['nome'])) { $updates[] = 'nome = ?'; $params[] = trim($input['nome']); }
if (isset($input['descricao'])) { $updates[] = 'descricao = ?'; $params[] = trim($input['descricao']); }

if (!empty($updates)) {
    $params[] = $projectId;
    $stmt = $db->prepare('UPDATE projects SET ' . implode(', ', $updates) . ' WHERE id = ?');
    $stmt->execute($params);
}

logActivity($db, $projectId, (int)$session['userId'], 'project.update', ['nome' => $input['nome'] ?? null]);

jsonResponse(['ok' => true]);
