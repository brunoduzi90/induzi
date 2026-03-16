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

// Check ownership or access
$stmt = $db->prepare('SELECT * FROM projects WHERE id = ?');
$stmt->execute([$projectId]);
$project = $stmt->fetch();

if (!$project) {
    jsonResponse(['ok' => false, 'msg' => 'Projeto nao encontrado.'], 404);
}

$isOwner = (int)$project['user_id'] === (int)$session['userId'];
if (!$isOwner) {
    $stmt = $db->prepare('SELECT 1 FROM project_users WHERE project_id = ? AND user_id = ?');
    $stmt->execute([$projectId, $session['userId']]);
    if (!$stmt->fetch()) {
        jsonResponse(['ok' => false, 'msg' => 'Sem permissao para duplicar este projeto.'], 403);
    }
}

// Create new project
$newNome = $project['nome'] . ' (copia)';
$stmt = $db->prepare('INSERT INTO projects (nome, descricao, user_id) VALUES (?, ?, ?)');
$stmt->execute([$newNome, $project['descricao'], $session['userId']]);
$newId = (int)$db->lastInsertId();

// Copy all project_data
$stmt = $db->prepare('SELECT data_key, data_value FROM project_data WHERE project_id = ?');
$stmt->execute([$projectId]);
$allData = $stmt->fetchAll();

if (!empty($allData)) {
    $insertStmt = $db->prepare('INSERT INTO project_data (project_id, data_key, data_value, updated_by) VALUES (?, ?, ?, ?)');
    foreach ($allData as $row) {
        $insertStmt->execute([$newId, $row['data_key'], $row['data_value'], $session['userId']]);
    }
}

jsonResponse([
    'ok' => true,
    'msg' => 'Projeto duplicado!',
    'project' => [
        'id' => $newId,
        'nome' => $newNome,
        'descricao' => $project['descricao'],
        'user_id' => (int)$session['userId'],
    ]
]);
