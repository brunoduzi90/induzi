<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('GET');
$session = requireProject();

$projectId = $session['projectId'];
$db = getDB();

// Get project info
$stmt = $db->prepare('SELECT nome, descricao, criado_em FROM projects WHERE id = ?');
$stmt->execute([$projectId]);
$project = $stmt->fetch();

// Get all project data
$stmt = $db->prepare('SELECT data_key, data_value, updated_at FROM project_data WHERE project_id = ? ORDER BY data_key');
$stmt->execute([$projectId]);
$rows = $stmt->fetchAll();

$data = [];
foreach ($rows as $row) {
    $val = json_decode($row['data_value'], true);
    $data[$row['data_key']] = [
        'value' => $val,
        'updated_at' => $row['updated_at']
    ];
}

jsonResponse([
    'ok' => true,
    'project' => [
        'nome' => $project['nome'] ?? '',
        'descricao' => $project['descricao'] ?? '',
        'criado_em' => $project['criado_em'] ?? ''
    ],
    'data' => $data,
    'exported_at' => date('Y-m-d H:i:s')
]);
