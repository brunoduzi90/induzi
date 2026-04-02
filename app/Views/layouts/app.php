<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($_title ?? APP_NAME) ?></title>
    <meta name="csrf-token" content="<?= csrf_token() ?>">

    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= e($siteDescription ?? 'INDUZI — Onde a materia bruta encontra a intencao criativa') ?>">
    <meta name="keywords" content="<?= e($settings['seo_keywords'] ?? 'design autoral, arquitetura de interiores, mobiliario') ?>">
    <meta property="og:title" content="<?= e($_title ?? APP_NAME) ?>">
    <meta property="og:description" content="<?= e($siteDescription ?? '') ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">

    <!-- DNS Prefetch + Preconnect (font origins) -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Preload Critical Fonts (subset: latin only) -->
    <link rel="preload" href="https://fonts.gstatic.com/s/spacegrotesk/v16/V8mDoQDjQSkFtoMM3T6r8E7mPbF4Cw.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="https://fonts.gstatic.com/s/inter/v18/UcCO3FwrK3iLTeHuS_nVMrMxCp50SjIw2boKoduKmMEVuLyfAZ9hjQ.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Google Fonts — Optimized: fewer weights, display=swap already included -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;500;700&family=Inter:wght@300;400;600&family=JetBrains+Mono:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,200,0,0" rel="stylesheet">

    <!-- Critical CSS — Inline above-the-fold styles -->
    <style>
    /* tokens (critical subset) */
    :root{--ps-accent:#B8E0C8;--ps-accent-hover:#D0F0DC;--ps-accent-muted:#8CB89C;--ps-black:#000;--ps-bg-primary:#0D0D0D;--ps-bg-elevated:#141414;--ps-bg-surface:#1A1A1A;--ps-bg-subtle:#222;--ps-bg-hover:#2A2A2A;--ps-text-primary:#FFF;--ps-text-secondary:#A0A0A0;--ps-text-muted:#666;--ps-border:#2A2A2A;--ps-border-light:#333;--ps-overlay:rgba(0,0,0,.7);--ps-glow-accent:rgba(184,224,200,.15);--ps-font-heading:'Space Grotesk','Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;--ps-font-body:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;--ps-font-mono:'JetBrains Mono',Consolas,monospace;--ps-font-xs:.75rem;--ps-font-sm:.875rem;--ps-font-base:1rem;--ps-font-md:1.125rem;--ps-font-lg:1.5rem;--ps-font-xl:2rem;--ps-font-2xl:2.5rem;--ps-font-3xl:3.5rem;--ps-font-4xl:5rem;--ps-font-display:7rem;--ps-weight-light:300;--ps-weight-regular:400;--ps-weight-medium:500;--ps-weight-semibold:600;--ps-weight-bold:700;--ps-leading-tight:1.1;--ps-leading-normal:1.5;--ps-leading-relaxed:1.7;--ps-tracking-tight:-.02em;--ps-tracking-wider:.1em;--ps-tracking-wide:.05em;--ps-space-2:.5rem;--ps-space-3:.75rem;--ps-space-4:1rem;--ps-space-5:1.25rem;--ps-space-6:1.5rem;--ps-space-8:2rem;--ps-space-10:2.5rem;--ps-duration-fast:200ms;--ps-duration-base:350ms;--ps-duration-reveal:800ms;--ps-ease-out:cubic-bezier(.22,1,.36,1);--ps-z-base:1;--ps-z-sticky:200;--ps-z-overlay:300;--ps-container-max:1400px;--ps-container-padding:var(--ps-space-6);--ps-radius-full:9999px;--ps-radius-md:8px;--ps-shadow-glow:0 0 20px var(--ps-glow-accent)}
    /* reset (critical) */
    *,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
    html{font-size:100%;-webkit-text-size-adjust:100%;-webkit-font-smoothing:antialiased;text-rendering:optimizeLegibility;scroll-behavior:smooth;overflow-x:hidden}
    body{font-family:var(--ps-font-body);font-size:var(--ps-font-base);font-weight:var(--ps-weight-regular);line-height:var(--ps-leading-normal);color:var(--ps-text-primary);background-color:var(--ps-bg-primary);overflow-x:hidden}
    img,picture,video,svg{display:block;max-width:100%}img{height:auto}
    a{color:inherit;text-decoration:none}button{cursor:pointer}
    h1,h2,h3,h4,h5,h6{font-family:var(--ps-font-heading);font-weight:var(--ps-weight-bold);line-height:var(--ps-leading-tight);color:var(--ps-text-primary);letter-spacing:var(--ps-tracking-tight)}
    h1{font-size:var(--ps-font-4xl)}p{margin-bottom:var(--ps-space-4);line-height:var(--ps-leading-relaxed);color:var(--ps-text-secondary)}
    button,input,select,textarea{font:inherit;color:inherit;border:none;background:none;outline:none}ul,ol{list-style:none}
    /* navbar (critical - fixed, always visible) */
    .ps-navbar{position:fixed;top:0;left:0;right:0;z-index:var(--ps-z-sticky);padding:var(--ps-space-5) var(--ps-space-6);transition:background-color var(--ps-duration-base) var(--ps-ease-out)}
    .ps-navbar.is-scrolled{background-color:rgba(13,13,13,.9);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px)}
    .ps-navbar__inner{display:flex;align-items:center;justify-content:space-between;max-width:100%;margin-inline:auto}
    .ps-navbar__logo{display:flex;align-items:center;gap:var(--ps-space-3);font-family:var(--ps-font-heading);font-size:var(--ps-font-lg);font-weight:var(--ps-weight-bold);color:var(--ps-text-primary);letter-spacing:var(--ps-tracking-tight)}
    .ps-navbar__nav{display:flex;align-items:center;gap:var(--ps-space-6);flex-wrap:wrap}
    .ps-navbar__link{font-family:var(--ps-font-heading);font-size:var(--ps-font-sm);font-weight:var(--ps-weight-medium);text-transform:uppercase;letter-spacing:var(--ps-tracking-wider);color:var(--ps-text-secondary);position:relative;padding:var(--ps-space-2) 0}
    .ps-navbar__link.is-active{color:var(--ps-accent)}
    /* hero (critical - first viewport) */
    .ps-hero{position:relative;min-height:100vh;display:flex;align-items:center;justify-content:flex-start;overflow:hidden;background-color:var(--ps-bg-primary)}
    .ps-hero__bg{position:absolute;inset:0;z-index:0;background-size:cover;background-position:center;background-repeat:no-repeat;opacity:.3}
    .ps-hero__content{position:relative;z-index:var(--ps-z-base);text-align:left;padding:var(--ps-space-8) clamp(2rem,5vw,5rem);padding-left:clamp(6rem,15vw,16rem);margin-top:-8vh;max-width:var(--ps-container-max);width:100%}
    .ps-hero__title{font-size:var(--ps-font-display);font-weight:var(--ps-weight-bold);letter-spacing:var(--ps-tracking-tight);line-height:.9;margin-bottom:var(--ps-space-6)}
    .ps-hero__subtitle{font-size:var(--ps-font-lg);font-weight:var(--ps-weight-light);color:var(--ps-text-secondary);max-width:600px;margin-bottom:var(--ps-space-10)}
    /* buttons (critical - hero CTA) */
    .ps-btn{display:inline-flex;align-items:center;justify-content:center;gap:var(--ps-space-2);font-family:var(--ps-font-heading);font-weight:var(--ps-weight-medium);font-size:var(--ps-font-sm);line-height:1;text-decoration:none;text-transform:uppercase;letter-spacing:var(--ps-tracking-wider);border-radius:var(--ps-radius-full);cursor:pointer;transition:all var(--ps-duration-base) var(--ps-ease-out);white-space:nowrap;position:relative;overflow:hidden}
    .ps-btn--md{padding:var(--ps-space-3) var(--ps-space-8);font-size:var(--ps-font-sm)}
    .ps-btn--primary{background-color:var(--ps-accent);color:var(--ps-black);border:2px solid var(--ps-accent)}
    .ps-btn--secondary{background-color:transparent;color:var(--ps-text-primary);border:1px solid var(--ps-border-light)}
    /* scroll progress */
    .ps-scroll-progress{position:fixed;top:0;left:0;height:2px;background:var(--ps-accent);z-index:9999;width:0;transition:none}
    /* noise overlay */
    .ps-noise{position:fixed;inset:0;z-index:9998;pointer-events:none;opacity:.03}
    /* skip nav */
    .ps-skip-nav{position:absolute;top:-60px;left:0;background:var(--ps-accent);color:var(--ps-black);padding:var(--ps-space-2) var(--ps-space-4);z-index:10000;font-weight:var(--ps-weight-semibold);text-decoration:none;transition:top var(--ps-duration-fast) var(--ps-ease-out)}
    .ps-skip-nav:focus{top:0}
    /* hamburger */
    .ps-hamburger{display:none;flex-direction:column;gap:5px;background:none;border:none;cursor:pointer;padding:var(--ps-space-2)}
    .ps-hamburger__line{width:24px;height:2px;background:var(--ps-text-primary);transition:all var(--ps-duration-fast) var(--ps-ease-out)}
    @media(max-width:768px){.ps-hamburger{display:flex}.ps-navbar__nav{display:none}h1{font-size:var(--ps-font-3xl)}.ps-hero__title{font-size:var(--ps-font-4xl)}.ps-hero__content{padding-left:var(--ps-space-6);margin-top:-4vh}}
    /* SPA progress */
    #spa-progress{position:fixed;top:0;left:0;right:0;height:3px;z-index:9999;opacity:0;transition:opacity .2s}
    #spa-progress.active{opacity:1}
    .spa-progress-bar{height:100%;background:var(--ps-accent);width:0;transition:width .3s}
    /* back to top - hidden by default */
    .ps-back-to-top{position:fixed;bottom:2rem;left:50%;transform:translateX(-50%) translateY(20px);width:40px;height:56px;background:none;border:1px solid var(--ps-text-muted);border-radius:20px;color:var(--ps-text-muted);cursor:pointer;z-index:99;opacity:0;pointer-events:none;transition:opacity .35s,transform .35s}
    .ps-back-to-top.is-visible{opacity:1;pointer-events:auto;transform:translateX(-50%) translateY(0)}
    </style>

    <!-- CSS — Full stylesheets (critical CSS inline above handles first paint) -->
    <?php $cssV = '?v=' . filemtime(ROOT_PATH . '/public/assets/css/pages.css'); ?>
    <link rel="stylesheet" href="<?= asset('css/tokens.css') . $cssV ?>">
    <link rel="stylesheet" href="<?= asset('css/base.css') . $cssV ?>">
    <link rel="stylesheet" href="<?= asset('css/components.css') . $cssV ?>">
    <link rel="stylesheet" href="<?= asset('css/pages.css') . $cssV ?>">
    <link rel="stylesheet" href="<?= asset('css/site.css') . $cssV ?>">
    <link rel="stylesheet" href="<?= asset('css/spa.css') . $cssV ?>">

    <!-- Noscript fallback -->
    <noscript>
        <style>#spa-progress{display:none;}.spa-skeleton{display:none;}.ps-scroll-progress{display:none;}</style>
    </noscript>

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#B8E0C8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- Prefetch likely next pages -->
    <link rel="prefetch" href="<?= url('portfolio') ?>">
    <link rel="prefetch" href="<?= url('contato') ?>">
</head>
<body>

    <!-- Skip Navigation -->
    <a href="#spa-content" class="ps-skip-nav">Pular para o conteudo</a>

    <!-- Scroll Progress Bar -->
    <div class="ps-scroll-progress"></div>

    <!-- SPA Progress Bar -->
    <div id="spa-progress"><div class="spa-progress-bar"></div></div>

    <!-- Noise Overlay -->
    <div class="ps-noise"></div>

    <!-- Grid Dots Overlay (global + magnifier on hover) -->
    <div class="ps-grid-dots" aria-hidden="true"></div>


    <!-- Custom Cursor (desktop only) -->
    <div class="ps-cursor__dot"></div>
    <div class="ps-cursor__ring"></div>

    <!-- Snap Wipe Transition -->
    <div class="ps-snap-wipe" id="snap-wipe"></div>

    <!-- Lightbox -->
    <div class="ps-lightbox" id="ps-lightbox">
        <button class="ps-lightbox__close" aria-label="Fechar">&times;</button>
        <button class="ps-lightbox__nav ps-lightbox__nav--prev" aria-label="Anterior">&#8249;</button>
        <img class="ps-lightbox__img" src="" alt="" loading="lazy">
        <button class="ps-lightbox__nav ps-lightbox__nav--next" aria-label="Pr&oacute;ximo">&#8250;</button>
    </div>

    <!-- Header -->
    <?php require ROOT_PATH . '/app/Views/components/header.php'; ?>

    <!-- Mobile Menu -->
    <nav class="ps-mobile-menu" aria-label="Menu mobile">
        <a href="<?= url('/') ?>" class="ps-mobile-menu__link">Home</a>
        <a href="<?= url('atelie') ?>" class="ps-mobile-menu__link">Ateli&ecirc;</a>
        <a href="<?= url('portfolio') ?>" class="ps-mobile-menu__link">Portf&oacute;lio</a>
        <a href="<?= url('contato') ?>" class="ps-mobile-menu__link">Contato</a>
    </nav>

    <!-- Side Navigation -->
    <?php require ROOT_PATH . '/app/Views/components/side-nav.php'; ?>

    <!-- Breadcrumbs -->
    <?php require ROOT_PATH . '/app/Views/components/breadcrumbs.php'; ?>

    <!-- Main Content (SPA target) -->
    <main id="spa-content">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer + Back to Top -->
    <?php require ROOT_PATH . '/app/Views/components/footer.php'; ?>

    <!-- Cookie Banner LGPD -->
    <?php require ROOT_PATH . '/app/Views/components/cookie-banner.php'; ?>

    <!-- Back to Top — fixed, centered bottom -->
    <button class="ps-back-to-top" id="back-to-top" aria-label="Voltar ao topo">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <rect x="6" y="3" width="12" height="18" rx="6" ry="6"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
        </svg>
    </button>

    <!-- JavaScript — defer to not block rendering -->
    <script src="<?= asset('js/main.js') ?>" defer></script>
    <script src="<?= asset('js/spa.js') ?>" defer></script>

    <!-- Service Worker Registration -->
    <script>
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', function () {
        navigator.serviceWorker.register('/sw.js', { scope: '/' }).catch(function () {});
      });
    }
    </script>
</body>
</html>
