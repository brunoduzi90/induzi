<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('POST');
$session = requireAuth();
$input = getJsonInput();

$projectId = (int)($input['projectId'] ?? 0);
$action = $input['action'] ?? 'add'; // add | remove
$email = trim(strtolower($input['email'] ?? ''));
$permissao = $input['permissao'] ?? 'editar';

if (!$projectId) jsonResponse(['ok' => false, 'msg' => 'projectId obrigatorio.'], 400);
if (!$email) jsonResponse(['ok' => false, 'msg' => 'Email obrigatorio.'], 400);
if (!in_array($permissao, ['editar', 'visualizar'])) $permissao = 'editar';

$db = getDB();

// Check ownership
$stmt = $db->prepare('SELECT * FROM projects WHERE id = ? AND user_id = ?');
$stmt->execute([$projectId, $session['userId']]);
if (!$stmt->fetch()) {
    jsonResponse(['ok' => false, 'msg' => 'Apenas o dono pode compartilhar o projeto.'], 403);
}

// Find target user
$stmt = $db->prepare('SELECT id, nome, email FROM users WHERE email = ?');
$stmt->execute([$email]);
$targetUser = $stmt->fetch();

if (!$targetUser) {
    jsonResponse(['ok' => false, 'msg' => 'Usuario nao encontrado com este email.'], 404);
}

if ((int)$targetUser['id'] === (int)$session['userId']) {
    jsonResponse(['ok' => false, 'msg' => 'Voce ja e o dono deste projeto.'], 400);
}

if ($action === 'remove') {
    $stmt = $db->prepare('DELETE FROM project_users WHERE project_id = ? AND user_id = ?');
    $stmt->execute([$projectId, $targetUser['id']]);
    jsonResponse(['ok' => true, 'msg' => 'Compartilhamento removido.']);
}

// Add/update sharing
$stmt = $db->prepare('INSERT INTO project_users (project_id, user_id, permissao) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE permissao = VALUES(permissao)');
$stmt->execute([$projectId, $targetUser['id'], $permissao]);

// Create notification for target user
try {
    $stmt2 = $db->prepare("SELECT nome FROM projects WHERE id = ?");
    $stmt2->execute([$projectId]);
    $proj = $stmt2->fetch();
    $projNome = $proj ? $proj['nome'] : 'Projeto';
    $sharerNome = $session['nome'] ?? 'Alguem';

    // Check if notifications table exists
    $tables = $db->query("SHOW TABLES LIKE 'notifications'")->fetchAll();
    if (count($tables) > 0) {
        $stmt3 = $db->prepare('INSERT INTO notifications (user_id, tipo, titulo, mensagem, link) VALUES (?, ?, ?, ?, ?)');
        $stmt3->execute([
            $targetUser['id'],
            'share',
            'Projeto compartilhado',
            $sharerNome . ' compartilhou o projeto "' . $projNome . '" com voce (' . $permissao . ').',
            '#projetos'
        ]);
    }
} catch (PDOException $e) {}

jsonResponse(['ok' => true, 'msg' => 'Projeto compartilhado com ' . $targetUser['nome'] . '!']);
