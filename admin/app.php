<?php
/**
 * SPA Shell — Painel Admin INDUZI
 */
if (!file_exists(__DIR__ . '/../config.php')) { header('Location: ../install.php'); exit; }

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../version.php';
if (file_exists(__DIR__ . '/../framework.php')) require_once __DIR__ . '/../framework.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/auth.php';

if (empty($_SESSION['induzi_user']['userId'])) { header('Location: login.php'); exit; }

// Release session file lock immediately — prevents blocking fragment AJAX requests
// $_SESSION remains readable in memory, only the file lock is released
session_write_close();

// Prevent browser/CDN caching of SPA shell (ensures fresh JS versions after deploy)
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Compute admin base path and initial route from clean URL
$_adminBase = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/') . '/';
$_requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$_initialRoute = trim(substr($_requestPath, strlen($_adminBase)), '/');
if (!$_initialRoute || $_initialRoute === 'app.php') $_initialRoute = 'painel';

$_appName = defined('APP_NAME') ? APP_NAME : 'INDUZI';
$_accentColor = defined('APP_ACCENT_COLOR') ? APP_ACCENT_COLOR : '#B8E0C8';
$_userPrefs = $_SESSION['induzi_user']['preferencias'] ?? [];

// ── SSR: Pre-render initial fragment (eliminates first AJAX request) ──
$_ssrRouteFiles = [
    'painel' => 'index.php', 'mensagens' => 'mensagens.php', 'newsletter' => 'newsletter.php',
    'leads' => 'leads.php', 'configuracoes' => 'configuracoes.php', 'contas' => 'contas.php',
    'atualizacao' => 'atualizacao.php',
];
$_ssrData = null;
$_ssrFile = $_ssrRouteFiles[$_initialRoute] ?? null;
if ($_ssrFile && file_exists(__DIR__ . '/pages/' . $_ssrFile)) {
    global $_spaEmbedMode;
    $_spaEmbedMode = true;
    $_GET['fragment'] = '1';
    try {
        include __DIR__ . '/pages/' . $_ssrFile;
        if (is_array($_spaEmbedMode)) {
            $_ssrData = $_spaEmbedMode;
        }
    } catch (Throwable $e) {
        // SSR failed silently — SPA will fetch via AJAX as fallback
    }
    $_spaEmbedMode = null;
    unset($_GET['fragment']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="escuro">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($_appName) ?> — Admin</title>
<script>
(function(){var t=localStorage.getItem('igris_tema');if(t==='claro'||t==='escuro')document.documentElement.setAttribute('data-theme',t);})();
</script>
<link rel="stylesheet" href="css/style.css?v=<?= INDUZI_VERSION ?>">
<style>:root[data-theme="claro"],:root[data-theme="escuro"]{--color-accent:<?= $_accentColor ?>;--color-accent-hover:<?= $_accentColor ?>dd;--color-accent-light:<?= $_accentColor ?>20;}</style>
<?php
$_customCss = '';
if (!empty($_userPrefs['primaryColor'])) {
    $p = htmlspecialchars($_userPrefs['primaryColor'], ENT_QUOTES);
    $_customCss .= "--icon-strip-bg:{$p};--sidebar-bg:{$p}18;--sidebar-border:{$p}40;--sidebar-hover:{$p}30;";
}
if (!empty($_userPrefs['accentColor'])) {
    $c = htmlspecialchars($_userPrefs['accentColor'], ENT_QUOTES);
    $_customCss .= "--color-accent:{$c};--color-accent-hover:{$c}dd;--color-accent-light:{$c}20;";
}
if ($_customCss): ?>
<style>:root[data-theme="claro"],:root[data-theme="escuro"]{<?= $_customCss ?>}</style>
<?php endif; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap"></noscript>
</head>
<?php $_sbForSpa = true; $_sbBase = $_adminBase; include __DIR__ . '/../includes/sidebar.php'; ?>
    <!-- Main Content -->
    <div class="main-content" role="main">
        <div id="spaContent"><?php if ($_ssrData): ?><?= $_ssrData['html'] ?><?php endif; ?></div>
    </div>
</div><!-- /app-layout -->

<div id="spaLoading" class="spa-loading"></div>

<!-- JS Modules (ordem importa) -->
<script src="js/theme.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/db.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/auth.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/modal-system.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/components.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/spa.js?v=<?= INDUZI_VERSION ?>"></script>

<!-- Init -->
<script>
(async function() {
    window._igrisSession = <?= json_encode([
        'userId'    => $_SESSION['induzi_user']['userId'],
        'nome'      => $_SESSION['induzi_user']['nome'],
        'email'     => $_SESSION['induzi_user']['email'],
        'role'      => $_SESSION['induzi_user']['role'],
        'csrfToken' => $_SESSION['csrf_token'],
    ]) ?>;

    window.INDUZI_VERSION = '<?= INDUZI_VERSION ?>';
    window._adminBase = <?= json_encode($_adminBase) ?>;
    window._initialRoute = <?= json_encode($_initialRoute) ?>;
<?php if ($_ssrData): ?>
    window._ssrData = <?= json_encode($_ssrData, JSON_UNESCAPED_UNICODE) ?>;
<?php endif; ?>

    IgrisDB.init(window._igrisSession.csrfToken);
    await IgrisAuth.init();
    IgrisTheme.init();
    <?php if (!empty($_userPrefs)): ?>
    IgrisTheme.applyCustom(<?= json_encode($_userPrefs, JSON_UNESCAPED_UNICODE) ?>);
    <?php endif; ?>
    SpaRouter.init();
})();
</script>
</body>
</html>
