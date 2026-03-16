<?php
/**
 * SPA Fragment Helper — Induzi
 */
$_spaIsFragment = isset($_GET['fragment']) && $_GET['fragment'] === '1';

$_spaRouteMap = [
    'index.php'          => 'painel',
    'projetos.php'       => 'projetos',
    'copywriter.php'     => 'copywriter',
    'estrutura.php'      => 'estrutura',
    'seguranca.php'      => 'seguranca',
    'seo.php'            => 'seo',
    'shopee.php'         => 'shopee',
    'icones.php'         => 'icones',
    'configuracoes.php'  => 'configuracoes',
    'atividades.php'     => 'atividades',
    'branding.php'       => 'branding',
    'google-ads.php'     => 'google-ads',
    'performance.php'    => 'performance',
    'analytics.php'      => 'analytics',
    'ux-design.php'      => 'ux-design',
    'acessibilidade.php' => 'acessibilidade',
    'conteudo.php'       => 'conteudo',
    'cro.php'            => 'cro',
    'email-marketing.php'=> 'email-marketing',
    'redes-sociais.php'  => 'redes-sociais',
    'meta-ads.php'       => 'meta-ads',
    'infraestrutura.php' => 'infraestrutura',
    'site-audit.php'     => 'site-audit',
    'mercado-livre.php'  => 'mercado-livre',
    'atualizacao.php'    => 'atualizacao',
];

function spaFragmentStart() {
    global $_spaIsFragment, $_spaRouteMap;
    if ($_spaIsFragment) {
        ob_start();
        return;
    }
    if (session_status() === PHP_SESSION_NONE) @session_start();
    if (!empty($_SESSION['induzi_user']['userId'])) {
        $currentFile = basename($_SERVER['SCRIPT_NAME']);
        if (isset($_spaRouteMap[$currentFile])) {
            $route = $_spaRouteMap[$currentFile];
            $inPages = strpos($_SERVER['SCRIPT_NAME'], '/pages/') !== false;
            $base = $inPages ? '../' : './';
            header('Location: ' . $base . '#' . $route);
            exit;
        }
    }
}

function spaFragmentEnd() {
    global $_spaIsFragment;
    if (!$_spaIsFragment) return;
    $html = ob_get_clean();
    while (ob_get_level() > 0) ob_end_clean();

    preg_match_all('/<style[^>]*>(.*?)<\/style>/s', $html, $styleMatches);
    $styles = implode("\n", $styleMatches[1] ?? []);

    preg_match('/<div class="main-content">(.*)/s', $html, $contentMatch);
    $content = $contentMatch[1] ?? '';

    $content = preg_replace('/<script[^>]+\bsrc\b[^>]*><\/script>/s', '', $content);
    preg_match_all('/<script(?![^>]*\bsrc\b)[^>]*>(.*?)<\/script>/s', $content, $scriptMatches);
    $scripts = implode("\n", $scriptMatches[1] ?? []);
    $content = preg_replace('/<script(?![^>]*\bsrc\b)[^>]*>.*?<\/script>/s', '', $content);
    $content = preg_replace('/\s*<\/div>\s*<\/div>\s*<\/body>\s*$/s', '', $content);

    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, private, max-age=0');
    echo json_encode([
        'ok' => true,
        'styles' => $styles,
        'html' => trim($content),
        'scripts' => $scripts
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
