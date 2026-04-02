<?php
/**
 * Endpoint publico — inscricao na newsletter (sem auth)
 */
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['ok' => false, 'msg' => 'Metodo nao permitido.'], 405);
}

$input = getJsonInput();

$email = trim($input['email'] ?? '');
$nome = trim($input['nome'] ?? '');
$origem = trim($input['origem'] ?? 'site');

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['ok' => false, 'msg' => 'Email invalido.'], 400);
}

$db = getDB();

// Verifica se ja existe
$stmt = $db->prepare('SELECT id, status FROM newsletter WHERE email = ?');
$stmt->execute([$email]);
$existing = $stmt->fetch();

if ($existing) {
    if ($existing['status'] === 'inativo') {
        $db->prepare('UPDATE newsletter SET status = ?, nome = COALESCE(NULLIF(?, ?), nome) WHERE id = ?')
           ->execute(['ativo', $nome, '', $existing['id']]);
        jsonResponse(['ok' => true, 'msg' => 'Inscricao reativada!']);
    }
    jsonResponse(['ok' => true, 'msg' => 'Email ja inscrito.']);
}

$stmt = $db->prepare('INSERT INTO newsletter (nome, email, origem) VALUES (?, ?, ?)');
$stmt->execute([$nome ?: null, $email, $origem]);

jsonResponse(['ok' => true, 'msg' => 'Inscricao realizada com sucesso!']);
