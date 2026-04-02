<?php
/**
 * INDUZI - Verificar atualizacoes remotas
 * GET admin-only
 * Busca manifest JSON do servidor de atualizacoes
 */
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/helpers.php';
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../includes/update-helpers.php';
require_once __DIR__ . '/../../../version.php';

requireMethod('GET');
requireAdmin();

$pdo = getDB();
$currentVersion = defined('INDUZI_VERSION') ? INDUZI_VERSION : '0.0.0';

// Buscar config de update na tabela configuracoes
$stmtUrl = $pdo->prepare("SELECT valor FROM configuracoes WHERE chave = 'update_url'");
$stmtUrl->execute();
$updateUrl = ($stmtUrl->fetch()['valor'] ?? '') ?: '';

$stmtToken = $pdo->prepare("SELECT valor FROM configuracoes WHERE chave = 'update_token'");
$stmtToken->execute();
$updateToken = ($stmtToken->fetch()['valor'] ?? '') ?: '';

// Verificar se URL esta configurada
if (empty($updateUrl)) {
    jsonResponse([
        'ok' => true,
        'data' => [
            'configured' => false,
            'currentVersion' => $currentVersion,
            'msg' => 'URL de atualizacao nao configurada. Defina update_url em Configuracoes.',
        ]
    ]);
}

// Buscar manifest remoto
$result = fetchRemoteData($updateUrl, 15, $updateToken);

if (!$result['ok']) {
    jsonResponse([
        'ok' => false,
        'msg' => 'Nao foi possivel conectar ao servidor de atualizacoes: ' . $result['error'],
        'data' => [
            'configured' => true,
            'currentVersion' => $currentVersion,
        ]
    ]);
}

// Parsear resposta (suporte a GitHub API que retorna conteudo em base64)
$responseData = json_decode($result['body'], true);

if (is_array($responseData) && isset($responseData['content'], $responseData['encoding']) && $responseData['encoding'] === 'base64') {
    $manifestJson = base64_decode($responseData['content']);
    $manifest = json_decode($manifestJson, true);
} else {
    $manifest = $responseData;
}

if (!is_array($manifest) || empty($manifest['version'])) {
    jsonResponse([
        'ok' => false,
        'msg' => 'Resposta do servidor de atualizacoes invalida (JSON malformado ou sem campo version).',
        'data' => [
            'configured' => true,
            'currentVersion' => $currentVersion,
        ]
    ]);
}

$remoteVersion = $manifest['version'];
$hasUpdate = version_compare($remoteVersion, $currentVersion, '>');

// Verificar compatibilidade PHP
$phpCompatible = true;
$phpMsg = '';
if (!empty($manifest['min_php'])) {
    $phpCompatible = version_compare(phpversion(), $manifest['min_php'], '>=');
    if (!$phpCompatible) {
        $phpMsg = 'Requer PHP ' . $manifest['min_php'] . ' (atual: ' . phpversion() . ')';
    }
}

// Full changelog mode
if (!empty($_GET['full_changelog'])) {
    $fullChangelog = [];
    if (!empty($manifest['changelog']) && is_array($manifest['changelog'])) {
        $fullChangelog = $manifest['changelog'];
    }
    jsonResponse([
        'ok' => true,
        'data' => [
            'changelog' => $fullChangelog,
            'currentVersion' => $currentVersion,
        ]
    ]);
}

// Filtrar changelog: apenas versoes entre atual e remota
$changelog = [];
if (!empty($manifest['changelog']) && is_array($manifest['changelog'])) {
    foreach ($manifest['changelog'] as $entry) {
        if (!empty($entry['version']) && version_compare($entry['version'], $currentVersion, '>')) {
            $changelog[] = $entry;
        }
    }
}

jsonResponse([
    'ok' => true,
    'data' => [
        'configured' => true,
        'currentVersion' => $currentVersion,
        'remoteVersion' => $remoteVersion,
        'hasUpdate' => $hasUpdate,
        'phpCompatible' => $phpCompatible,
        'phpMsg' => $phpMsg,
        'downloadUrl' => $manifest['download_url'] ?? '',
        'fileSize' => $manifest['file_size'] ?? 0,
        'sha256' => $manifest['sha256'] ?? '',
        'date' => $manifest['date'] ?? '',
        'changelog' => $changelog,
    ]
]);
