<?php
/**
 * Endpoint publico — captura de leads de landing pages (sem auth)
 */
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['ok' => false, 'msg' => 'Metodo nao permitido.'], 405);
}

$input = getJsonInput();

$email = trim($input['email'] ?? '');
$nome = trim($input['nome'] ?? '');
$telefone = trim($input['telefone'] ?? '');
$origem = trim($input['origem'] ?? '');
$dados = $input['dados'] ?? null;

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['ok' => false, 'msg' => 'Email invalido.'], 400);
}

$db = getDB();

$stmt = $db->prepare('INSERT INTO leads (nome, email, telefone, origem, dados) VALUES (?, ?, ?, ?, ?)');
$stmt->execute([
    $nome ?: null,
    $email,
    $telefone ?: null,
    $origem ?: null,
    $dados ? json_encode($dados, JSON_UNESCAPED_UNICODE) : null,
]);

jsonResponse(['ok' => true, 'msg' => 'Lead registrado com sucesso!']);
