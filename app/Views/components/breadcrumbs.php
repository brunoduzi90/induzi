<?php
$basePath = trim(defined('BASE_URL') ? BASE_URL : '/Site', '/');
$rawPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
// Remove base path prefix (e.g. "Site" when accessed via localhost/Site/)
if ($basePath && str_starts_with($rawPath, $basePath)) {
    $rawPath = trim(substr($rawPath, strlen($basePath)), '/');
}
$segments = $rawPath ? explode('/', $rawPath) : [];
$breadcrumbNames = [
    'atelie' => 'Atelie', 'portfolio' => 'Portfolio', 'contato' => 'Contato',
    'blog' => 'Blog', 'faq' => 'FAQ', 'termos' => 'Termos de Uso',
    'privacidade' => 'Privacidade', 'sobre' => 'Sobre',
];
?>
<?php if (!empty($segments)): ?>
<nav class="ps-breadcrumb" aria-label="Breadcrumb">
    <ol class="ps-breadcrumb__list" itemscope itemtype="https://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="/" itemprop="item"><span itemprop="name">Home</span></a>
            <meta itemprop="position" content="1">
        </li>
        <?php foreach ($segments as $i => $segment): ?>
        <li>
            <?php $url = '/' . implode('/', array_slice($segments, 0, $i + 1)); ?>
            <?php if ($i === count($segments) - 1): ?>
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name"><?= e($breadcrumbNames[$segment] ?? ucfirst($segment)) ?></span>
                    <meta itemprop="position" content="<?= $i + 2 ?>">
                </span>
            <?php else: ?>
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="<?= e($url) ?>" itemprop="item"><span itemprop="name"><?= e($breadcrumbNames[$segment] ?? ucfirst($segment)) ?></span></a>
                    <meta itemprop="position" content="<?= $i + 2 ?>">
                </span>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ol>
</nav>
<?php endif; ?>
