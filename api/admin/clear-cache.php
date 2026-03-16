<?php
/**
 * Induzi - Limpar cache do servidor (admin-only)
 * POST: executa opcache_reset() se disponivel
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('POST');
$session = requireAdmin();

$results = [];

// OPcache
if (function_exists('opcache_reset')) {
    $ok = @opcache_reset();
    $results['opcache'] = $ok ? 'limpo' : 'erro';
} else {
    $results['opcache'] = 'indisponivel';
}

$db = getDB();
logActivity($db, null, $session['userId'], 'cache_clear', [
    'opcache' => $results['opcache'],
]);

jsonResponse(['ok' => true, 'msg' => 'Cache limpo com sucesso.', 'data' => $results]);
