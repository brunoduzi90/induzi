<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('GET');
$session = requireAuth();
$db = getDB();

// Own projects
$stmt = $db->prepare('
    SELECT p.id, p.nome, p.descricao, p.user_id, p.criado_em, u.nome AS owner_name, \'dono\' AS permissao
    FROM projects p
    JOIN users u ON u.id = p.user_id
    WHERE p.user_id = ?
');
$stmt->execute([$session['userId']]);
$own = $stmt->fetchAll();

// Shared projects
$stmt = $db->prepare('
    SELECT p.id, p.nome, p.descricao, p.user_id, p.criado_em, u.nome AS owner_name, pu.permissao
    FROM projects p
    JOIN project_users pu ON pu.project_id = p.id
    JOIN users u ON u.id = p.user_id
    WHERE pu.user_id = ?
');
$stmt->execute([$session['userId']]);
$shared = $stmt->fetchAll();

$projects = array_merge($own, $shared);

// Sort by name
usort($projects, function($a, $b) { return strcasecmp($a['nome'], $b['nome']); });

foreach ($projects as &$p) {
    $p['id'] = (int)$p['id'];
    $p['user_id'] = (int)$p['user_id'];
}

jsonResponse(['ok' => true, 'projects' => $projects]);
