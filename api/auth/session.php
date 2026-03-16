<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('GET');

$session = getSessionData();
if (!$session || empty($session['userId'])) {
    jsonResponse(['ok' => false, 'loggedIn' => false, 'csrfToken' => $_SESSION['csrf_token'] ?? '']);
}

$db = getDB();
$stmt = $db->prepare('SELECT id, nome, email, role, preferencias, criado_em FROM users WHERE id = ?');
$stmt->execute([$session['userId']]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION = [];
    jsonResponse(['ok' => false, 'loggedIn' => false]);
}

$project = null;
$readOnly = false;
if (!empty($session['projectId'])) {
    $stmt = $db->prepare('SELECT id, nome, descricao, user_id FROM projects WHERE id = ?');
    $stmt->execute([$session['projectId']]);
    $project = $stmt->fetch();
    if ($project) {
        if ((int)$project['user_id'] === (int)$user['id']) {
            $readOnly = false;
        } else {
            $stmt = $db->prepare('SELECT permissao FROM project_users WHERE project_id = ? AND user_id = ?');
            $stmt->execute([$session['projectId'], $user['id']]);
            $perm = $stmt->fetch();
            $readOnly = !$perm || $perm['permissao'] === 'visualizar';
        }
    } else {
        $_SESSION['induzi_user']['projectId'] = null;
    }
}

jsonResponse([
    'ok'        => true,
    'loggedIn'  => true,
    'user'      => [
        'id'           => (int)$user['id'],
        'nome'         => $user['nome'],
        'email'        => $user['email'],
        'role'         => $user['role'],
        'preferencias' => $user['preferencias'] ? json_decode($user['preferencias'], true) : null,
    ],
    'project'   => $project ? [
        'id'        => (int)$project['id'],
        'nome'      => $project['nome'],
        'descricao' => $project['descricao'],
    ] : null,
    'projectId' => $session['projectId'] ? (int)$session['projectId'] : null,
    'readOnly'  => $readOnly,
    'csrfToken' => $_SESSION['csrf_token'] ?? '',
]);
