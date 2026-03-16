<?php
/**
 * Induzi — Sidebar + Icon Strip
 */
require_once __DIR__ . '/../version.php';

$_sbInPages = strpos($_SERVER['SCRIPT_NAME'], '/pages/') !== false;
$_sbPrefix  = $_sbInPages ? '' : 'pages/';
$_sbRoot    = $_sbInPages ? '../' : '';
$_sbCurrent = basename($_SERVER['SCRIPT_NAME']);

if (!isset($_sbForSpa)) $_sbForSpa = false;

$_sbHashMap = [
    'projetos.php'      => '#projetos',
    'icones.php'        => '#icones',
    'configuracoes.php' => '#configuracoes',
    'index.php'         => '#painel',
    'copywriter.php'    => '#copywriter',
    'estrutura.php'     => '#estrutura',
    'seguranca.php'     => '#seguranca',
    'seo.php'           => '#seo',
    'shopee.php'        => '#shopee',
    'branding.php'      => '#branding',
    'google-ads.php'    => '#google-ads',
    'atividades.php'    => '#atividades',
    'performance.php'   => '#performance',
    'analytics.php'     => '#analytics',
    'ux-design.php'     => '#ux-design',
    'acessibilidade.php'=> '#acessibilidade',
    'conteudo.php'      => '#conteudo',
    'cro.php'           => '#cro',
    'email-marketing.php'=> '#email-marketing',
    'redes-sociais.php' => '#redes-sociais',
    'meta-ads.php'      => '#meta-ads',
    'infraestrutura.php'=> '#infraestrutura',
    'site-audit.php'    => '#site-audit',
    'mercado-livre.php' => '#mercado-livre',
    'atualizacao.php'   => '#atualizacao',
];

function _sbHref($file, $prefix = '') {
    global $_sbForSpa, $_sbHashMap;
    if ($_sbForSpa && isset($_sbHashMap[$file])) return $_sbHashMap[$file];
    return $prefix . $file;
}

function _sbActive($file) {
    global $_sbCurrent, $_sbForSpa;
    if ($_sbForSpa) return '';
    return $_sbCurrent === $file ? ' class="active"' : '';
}

$_sbBodyClass = 'no-transition';
if ($_sbForSpa) $_sbBodyClass .= ' spa-mode no-modules-sidebar';
?>
<body class="<?= $_sbBodyClass ?>"><style>.no-transition,.no-transition *{transition:none!important}</style><script>try{if(sessionStorage.getItem('sidebarCollapsed')==='1')document.body.classList.add('sidebar-collapsed')}catch(e){}try{var _t=localStorage.getItem('induzi_tema')||'auto';var _d=_t==='auto'?(window.matchMedia&&window.matchMedia('(prefers-color-scheme:dark)').matches?'escuro':'claro'):_t;document.documentElement.setAttribute('data-theme',_d)}catch(e){}requestAnimationFrame(function(){requestAnimationFrame(function(){document.body.classList.remove('no-transition')})})</script>
    <button class="sidebar-toggle" onclick="toggleSidebar()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></button>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Icon Strip -->
    <div class="icon-strip" id="iconStrip">
        <div class="icon-strip-nav">
            <a href="<?= _sbHref('projetos.php', $_sbPrefix) ?>" title="Projetos"<?= _sbActive('projetos.php') ?>><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg></a>
            <a href="<?= _sbHref('icones.php', $_sbPrefix) ?>" title="Icones SVG"<?= _sbActive('icones.php') ?>><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg></a>
            <a href="<?= _sbHref('atividades.php', $_sbPrefix) ?>" title="Atividades"<?= _sbActive('atividades.php') ?>><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg></a>
            <a href="<?= _sbHref('site-audit.php', $_sbPrefix) ?>" title="Site Audit"<?= _sbActive('site-audit.php') ?>><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path><rect x="9" y="3" width="6" height="4" rx="1"></rect><path d="M9 14l2 2 4-4"></path></svg></a>
        </div>
        <button class="icon-strip-toggle" title="Recolher menu" onclick="toggleModulosSidebar()" style="display:none"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg></button>
        <div class="icon-strip-gear">
            <div class="gear-menu-wrapper" id="gearMenuWrapper">
                <button class="gear-menu-btn" title="Menu" onclick="toggleGearMenu()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg></button>
                <div class="gear-popup" id="gearPopup">
                    <div class="gear-popup-user" id="gearUserName"></div>
                    <hr>
                    <a href="<?= _sbHref('configuracoes.php', $_sbPrefix) ?>"><span class="gear-popup-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg></span> Configuracoes</a>
                    <a href="<?= _sbHref('atualizacao.php', $_sbPrefix) ?>"><span class="gear-popup-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg></span> Atualizacao</a>
                    <a href="#" onclick="InduziAuth.switchProject(); return false;"><span class="gear-popup-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg></span> Trocar Projeto</a>
                    <hr>
                    <a href="#" onclick="InduziAuth.logout(); return false;"><span class="gear-popup-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg></span> Sair</a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-layout">
        <div class="top-bar">
            <div class="top-bar-menu" id="topBarMenu">
                <div class="top-bar-user" onclick="toggleTopBarMenu()">
                    <div class="top-bar-avatar" id="topBarAvatar"></div>
                    <span class="top-bar-nome" id="topBarNome"></span>
                    <span class="top-bar-chevron"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></span>
                </div>
                <div class="top-bar-dropdown">
                    <a href="#" onclick="InduziAuth.switchProject(); return false;"><span class="dropdown-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg></span> Trocar Projeto</a>
                    <hr>
                    <a href="#" onclick="InduziAuth.logout(); return false;"><span class="dropdown-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg></span> Sair</a>
                </div>
            </div>
        </div>

        <aside class="sidebar" id="sidebar" role="navigation" aria-label="Menu principal">
            <div class="sidebar-logo">
                <h1>Induzi</h1>
                <span>Planejamento de Sites</span>
            </div>
            <div class="sidebar-house" id="sidebarProject"><span id="sidebarProjectName"></span></div>
            <nav class="sidebar-nav" aria-label="Navegacao dos modulos">
                <div id="favoritosSection" style="display:none;">
                    <div class="sidebar-section">Favoritos</div>
                    <ul id="favoritosList"></ul>
                </div>
                <div id="modulosSection">
                <div class="sidebar-section">Modulos</div>
                <ul>
                    <li data-modulo><a href="<?= _sbHref('index.php', $_sbRoot) ?>"<?= _sbActive('index.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect></svg></span> Painel</a></li>
                    <li data-modulo><a href="<?= _sbHref('branding.php', $_sbPrefix) ?>"<?= _sbActive('branding.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span> Branding</a></li>
                    <li data-modulo><a href="<?= _sbHref('copywriter.php', $_sbPrefix) ?>"<?= _sbActive('copywriter.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></span> Copywriter</a></li>
                    <li data-modulo><a href="<?= _sbHref('estrutura.php', $_sbPrefix) ?>"<?= _sbActive('estrutura.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg></span> Estrutura</a></li>
                    <li data-modulo><a href="<?= _sbHref('seguranca.php', $_sbPrefix) ?>"<?= _sbActive('seguranca.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></span> Seguranca</a></li>
                    <li data-modulo><a href="<?= _sbHref('seo.php', $_sbPrefix) ?>"<?= _sbActive('seo.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span> SEO</a></li>
                    <li data-modulo><a href="<?= _sbHref('conteudo.php', $_sbPrefix) ?>"<?= _sbActive('conteudo.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg></span> Conteudo</a></li>
                    <li data-modulo><a href="<?= _sbHref('ux-design.php', $_sbPrefix) ?>"<?= _sbActive('ux-design.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg></span> UX Design</a></li>
                    <li data-modulo><a href="<?= _sbHref('performance.php', $_sbPrefix) ?>"<?= _sbActive('performance.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg></span> Performance</a></li>
                    <li data-modulo><a href="<?= _sbHref('acessibilidade.php', $_sbPrefix) ?>"<?= _sbActive('acessibilidade.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="8" r="1"></circle><path d="M12 12v4"></path><path d="M8 14h8"></path></svg></span> Acessibilidade</a></li>
                    <li data-modulo><a href="<?= _sbHref('infraestrutura.php', $_sbPrefix) ?>"<?= _sbActive('infraestrutura.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg></span> Infraestrutura</a></li>
                    <li data-modulo><a href="<?= _sbHref('analytics.php', $_sbPrefix) ?>"<?= _sbActive('analytics.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg></span> Analytics</a></li>
                    <li data-modulo><a href="<?= _sbHref('cro.php', $_sbPrefix) ?>"<?= _sbActive('cro.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></span> CRO</a></li>
                </ul>
                <div class="sidebar-section">Trafego e Marketing</div>
                <ul>
                    <li data-modulo><a href="<?= _sbHref('google-ads.php', $_sbPrefix) ?>"<?= _sbActive('google-ads.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg></span> Google Ads</a></li>
                    <li data-modulo><a href="<?= _sbHref('meta-ads.php', $_sbPrefix) ?>"<?= _sbActive('meta-ads.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></span> Meta Ads</a></li>
                    <li data-modulo><a href="<?= _sbHref('email-marketing.php', $_sbPrefix) ?>"<?= _sbActive('email-marketing.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></span> Email Marketing</a></li>
                    <li data-modulo><a href="<?= _sbHref('redes-sociais.php', $_sbPrefix) ?>"<?= _sbActive('redes-sociais.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg></span> Redes Sociais</a></li>
                </ul>
                <div class="sidebar-section">Marketplaces</div>
                <ul>
                    <li data-modulo><a href="<?= _sbHref('shopee.php', $_sbPrefix) ?>"<?= _sbActive('shopee.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></span> Shopee</a></li>
                    <li data-modulo><a href="<?= _sbHref('mercado-livre.php', $_sbPrefix) ?>"<?= _sbActive('mercado-livre.php') ?>><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></span> Mercado Livre</a></li>
                </ul>
                </div>
            </nav>
            <div class="sidebar-version"><button class="sidebar-theme-toggle" id="sidebarThemeToggle" onclick="InduziTheme.cycle()" title="Alternar tema"></button>v<?= INDUZI_VERSION ?></div>
        </aside>
<script>
function toggleSidebar(){var s=document.getElementById('sidebar'),o=document.getElementById('sidebarOverlay'),i=document.getElementById('iconStrip');s.classList.toggle('open');o.classList.toggle('active');if(i)i.classList.toggle('open');document.body.classList.toggle('sidebar-open',s.classList.contains('open'))}
function toggleTopBarMenu(){document.getElementById('topBarMenu').classList.toggle('open')}
function toggleGearMenu(){var w=document.getElementById('gearMenuWrapper');if(w)w.classList.toggle('open')}
function toggleModulosSidebar(){document.body.classList.toggle('sidebar-collapsed');var c=document.body.classList.contains('sidebar-collapsed');try{sessionStorage.setItem('sidebarCollapsed',c?'1':'')}catch(e){}}
document.addEventListener('click',function(e){var m=document.getElementById('topBarMenu');if(m&&!m.contains(e.target))m.classList.remove('open');var g=document.getElementById('gearMenuWrapper');if(g&&!g.contains(e.target))g.classList.remove('open')});
</script>
