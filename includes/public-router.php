<?php
/**
 * Router simples para paginas publicas — INDUZI
 * Substitui o MVC Router, mapeando URLs para views existentes.
 */

function publicRoute(): void {
    $uri = $_SERVER['REQUEST_URI'];
    $basePath = defined('BASE_URL') ? BASE_URL : '';

    // Remove base path e query string
    $path = parse_url($uri, PHP_URL_PATH);
    if ($basePath !== '') {
        $path = preg_replace('#^' . preg_quote($basePath, '#') . '#', '', $path);
    }
    $path = trim($path, '/');

    // Mapa de rotas -> views
    $routes = [
        ''            => 'pages/home',
        'home'        => 'pages/home',
        'studio'      => 'pages/studio',
        'atelie'      => 'pages/atelie',
        'portfolio'   => 'pages/portfolio',
        'blog'        => 'pages/blog',
        'contato'     => 'pages/contact',
        'contact'     => 'pages/contact',
        'about'       => 'pages/about',
        'faq'         => 'pages/faq',
        'termos'      => 'pages/terms',
        'terms'       => 'pages/terms',
        'privacidade' => 'pages/privacy',
        'privacy'     => 'pages/privacy',
    ];

    // Blog post individual: /blog/{slug}
    if (preg_match('#^blog/([a-z0-9\-]+)$#', $path, $matches)) {
        $slug = $matches[1];
        renderPublicPage('pages/blog-post', ['slug' => $slug]);
        return;
    }

    // Portfolio item individual: /portfolio/{slug}
    if (preg_match('#^portfolio/([a-z0-9\-]+)$#', $path, $matches)) {
        $slug = $matches[1];
        renderPublicPage('pages/portfolio-item', ['slug' => $slug]);
        return;
    }

    if (isset($routes[$path])) {
        renderPublicPage($routes[$path]);
        return;
    }

    // Sitemap
    if ($path === 'sitemap.xml') {
        renderSitemap();
        return;
    }

    // 404
    http_response_code(404);
    renderPublicPage('errors/404');
}

/**
 * Renderiza uma view publica com layout
 */
function renderPublicPage(string $view, array $data = []): void {
    $viewPath = dirname(__DIR__) . '/app/Views/' . $view . '.php';
    $layoutPath = dirname(__DIR__) . '/app/Views/layouts/app.php';

    if (!file_exists($viewPath)) {
        http_response_code(404);
        $viewPath = dirname(__DIR__) . '/app/Views/errors/404.php';
    }

    // Dados disponíveis nas views
    extract($data);

    // Carregar configuracoes do site do banco
    try {
        $db = getDB();
        $stmt = $db->query("SELECT chave, valor FROM configuracoes");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['chave']] = $row['valor'];
        }
    } catch (Exception $e) {
        $settings = [];
    }

    $siteTitle = $settings['site_titulo'] ?? 'INDUZI — Design Autoral & Arquitetura de Interiores';
    $siteDescription = $settings['site_descricao'] ?? 'Onde a materia bruta encontra a intencao criativa';

    // Captura o conteudo da view
    ob_start();
    include $viewPath;
    $content = ob_get_clean();

    // Renderiza dentro do layout se existir
    if (file_exists($layoutPath)) {
        include $layoutPath;
    } else {
        echo $content;
    }
}

/**
 * Gera sitemap.xml dinamico
 */
function renderSitemap(): void {
    header('Content-Type: application/xml; charset=utf-8');
    $base = 'http' . (!empty($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . (defined('BASE_URL') ? BASE_URL : '');

    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    $pages = ['', '/studio', '/atelie', '/portfolio', '/blog', '/contato', '/about', '/faq'];
    foreach ($pages as $page) {
        echo '<url><loc>' . htmlspecialchars($base . $page) . '</loc><changefreq>weekly</changefreq></url>' . "\n";
    }

    echo '</urlset>';
    exit;
}
