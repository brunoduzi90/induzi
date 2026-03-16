<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('GET');
$session = requireAuth();

$projectId = (int)($_GET['projectId'] ?? 0);
if (!$projectId) jsonResponse(['ok' => false, 'msg' => 'projectId obrigatorio.'], 400);

$db = getDB();

// Check ownership or membership
$stmt = $db->prepare('SELECT user_id FROM projects WHERE id = ?');
$stmt->execute([$projectId]);
$project = $stmt->fetch();
if (!$project) jsonResponse(['ok' => false, 'msg' => 'Projeto nao encontrado.'], 404);

$isOwner = (int)$project['user_id'] === (int)$session['userId'];

// Get shared users
$stmt = $db->prepare('
    SELECT u.id, u.nome, u.email, pu.permissao
    FROM project_users pu
    JOIN users u ON u.id = pu.user_id
    WHERE pu.project_id = ?
    ORDER BY u.nome
');
$stmt->execute([$projectId]);
$users = $stmt->fetchAll();

// Get owner info
$stmt = $db->prepare('SELECT id, nome, email FROM users WHERE id = ?');
$stmt->execute([$project['user_id']]);
$owner = $stmt->fetch();

foreach ($users as &$u) {
    $u['id'] = (int)$u['id'];
}

jsonResponse([
    'ok' => true,
    'owner' => $owner ? ['id' => (int)$owner['id'], 'nome' => $owner['nome'], 'email' => $owner['email']] : null,
    'users' => $users,
    'isOwner' => $isOwner
]);
