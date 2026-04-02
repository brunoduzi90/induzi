<?php
/**
 * Sistema de Fragmentos SPA — INDUZI Admin
 * Permite que cada pagina funcione tanto standalone quanto como fragmento JSON
 */

$_spaIsFragment = false;
$_spaPreloaded = null;

$_spaRouteMap = [
    'index.php'          => 'painel',
    'mensagens.php'      => 'mensagens',
    'newsletter.php'     => 'newsletter',
    'leads.php'          => 'leads',
    'configuracoes.php'  => 'configuracoes',
    'contas.php'         => 'contas',
    'atualizacao.php'    => 'atualizacao',
];

/**
 * Inicio do fragmento — chame no inicio de cada pagina
 */
function spaFragmentStart(): void {
    global $_spaIsFragment, $_spaRouteMap;

    if (!empty($_GET['fragment'])) {
        $_spaIsFragment = true;
        ob_start();
        return;
    }

    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!empty($_SESSION['induzi_user']['userId'])) {
        $arquivo = basename($_SERVER['SCRIPT_FILENAME']);
        $rota = $_spaRouteMap[$arquivo] ?? str_replace('.php', '', $arquivo);
        $base = dirname($_SERVER['SCRIPT_NAME'], 2);
        header('Location: ' . $base . '/' . $rota);
        exit;
    }
}

/**
 * Pre-carrega dados para injetar no fragment (elimina segundo fetch)
 */
function spaPreload(array $data): void {
    global $_spaPreloaded;
    $_spaPreloaded = $data;
}

/**
 * Final do fragmento — chame no final de cada pagina
 */
function spaFragmentEnd(): void {
    global $_spaIsFragment, $_spaPreloaded;
    if (!$_spaIsFragment) return;

    $html = ob_get_clean();

    preg_match_all('/<style[^>]*>(.*?)<\/style>/s', $html, $styleMatches);
    $styles = implode("\n", $styleMatches[1] ?? []);

    if (preg_match('/<div class="main-content"[^>]*>(.*)/s', $html, $contentMatch)) {
        $content = $contentMatch[1];
        // Strip the closing </div> for main-content (may not be at very end if styles/scripts follow)
        $content = preg_replace('/<\/div>(\s*(<style[\s\S]*?<\/style>|<script[\s\S]*?<\/script>|\s)*)$/s', '$1', $content);
    } else {
        $content = $html;
    }

    // Remove style tags from content (already extracted above)
    $content = preg_replace('/<style[^>]*>.*?<\/style>/s', '', $content);

    $content = preg_replace('/<script[^>]+\bsrc\b[^>]*><\/script>/s', '', $content);

    preg_match_all('/<script(?![^>]*\bsrc\b)[^>]*>(.*?)<\/script>/s', $content, $scriptMatches);
    $scripts = implode("\n", $scriptMatches[1] ?? []);
    $content = preg_replace('/<script(?![^>]*\bsrc\b)[^>]*>.*?<\/script>/s', '', $content);

    $content = preg_replace('/<\/?(?:html|head|body|!DOCTYPE)[^>]*>/i', '', $content);
    $content = preg_replace('/<meta[^>]*>/i', '', $content);
    $content = preg_replace('/<title[^>]*>.*?<\/title>/si', '', $content);
    $content = preg_replace('/<link[^>]*>/i', '', $content);

    // Inject preloaded data before page scripts
    if ($_spaPreloaded !== null) {
        $preloadJs = 'var _preloaded=' . json_encode($_spaPreloaded, JSON_UNESCAPED_UNICODE) . ';';
        $scripts = $preloadJs . "\n" . $scripts;
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'ok'      => true,
        'styles'  => trim($styles),
        'html'    => trim($content),
        'scripts' => trim($scripts),
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
