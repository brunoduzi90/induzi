<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = defined('BASE_URL') ? BASE_URL : '';
?>
<header class="ps-navbar" id="site-header">
    <div class="ps-navbar__inner">
        <a href="<?= url('/') ?>" class="ps-navbar__logo"><?= e(APP_NAME) ?></a>

        <nav class="ps-navbar__nav" aria-label="Navegacao principal">
            <a href="<?= url('/') ?>" class="ps-navbar__link <?= ($currentPath === $base . '/' || $currentPath === $base) ? 'is-active' : '' ?>">Home</a>
            <a href="<?= url('atelie') ?>" class="ps-navbar__link <?= str_contains($currentPath, '/atelie') ? 'is-active' : '' ?>">Ateli&ecirc;</a>
            <a href="<?= url('portfolio') ?>" class="ps-navbar__link <?= str_contains($currentPath, '/portfolio') ? 'is-active' : '' ?>">Portf&oacute;lio</a>
            <a href="<?= url('contato') ?>" class="ps-navbar__link <?= str_contains($currentPath, '/contato') ? 'is-active' : '' ?>">Contato</a>
        </nav>

        <button class="ps-hamburger" data-menu-toggle aria-label="Abrir menu">
            <span class="ps-hamburger__line"></span>
            <span class="ps-hamburger__line"></span>
            <span class="ps-hamburger__line"></span>
        </button>
    </div>
</header>
