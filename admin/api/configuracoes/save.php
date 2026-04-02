<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireMethod('POST');
$session = requireAuth();
$input = getJsonInput();
requireFields($input, ['config']);

if (!is_array($input['config'])) {
    jsonResponse(['ok' => false, 'msg' => 'Formato invalido.'], 400);
}

$allowed = [
    'site_titulo', 'site_descricao', 'site_email', 'site_telefone',
    'site_instagram', 'site_whatsapp', 'site_facebook', 'site_linkedin',
    'seo_keywords', 'seo_og_image', 'google_analytics',
    'endereco', 'horario_funcionamento',
    'update_url', 'update_token',
];

$db = getDB();
$stmt = $db->prepare('INSERT INTO configuracoes (chave, valor) VALUES (?, ?) ON DUPLICATE KEY UPDATE valor = VALUES(valor)');

foreach ($input['config'] as $key => $value) {
    if (in_array($key, $allowed, true)) {
        $stmt->execute([$key, $value]);
    }
}

logActivity($db, $session['userId'], 'config_save', ['keys' => array_keys($input['config'])]);

jsonResponse(['ok' => true, 'msg' => 'Configuracoes salvas.']);
