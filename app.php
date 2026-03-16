<?php
if (!file_exists(__DIR__ . '/config.php')) {
    header('Location: install.php');
    exit;
}
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/version.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';

if (empty($_SESSION['induzi_user']['userId'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Induzi</title>
    <script>(function(){var t='auto';try{t=localStorage.getItem('induzi_tema')||'auto'}catch(e){}var d=t==='auto'?(window.matchMedia&&window.matchMedia('(prefers-color-scheme:dark)').matches?'escuro':'claro'):t;document.documentElement.setAttribute('data-theme',d)})()</script>
    <link rel="stylesheet" href="css/style.css?v=<?= INDUZI_VERSION ?>">
    <link rel="stylesheet" href="css/components.css?v=<?= INDUZI_VERSION ?>">
    <style>
        #spaContent { opacity: 1; transition: opacity 0.15s ease; overflow-wrap: break-word; word-break: break-word; min-width: 0; }
        #spaContent.spa-fade-out { opacity: 0; }
        #spaContent.spa-fade-in { opacity: 1; }
        #spaLoading { display: none; position: fixed; top: 0; left: 0; right: 0; height: 3px; z-index: 9999; background: transparent; }
        #spaLoading.active { display: block; }
        #spaLoading::after { content: ''; display: block; height: 100%; width: 30%; background: var(--color-accent, #7c3aed); animation: spaLoadBar 0.8s ease-in-out infinite; }
        @keyframes spaLoadBar { 0% { margin-left: -30%; } 100% { margin-left: 100%; } }
    </style>
</head>
<?php $_sbForSpa = true; include 'includes/sidebar.php'; ?>
    <div class="main-content" role="main">
        <div id="spaContent"></div>
    </div>
</div>
<div id="spaLoading"></div>
<script src="js/theme.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/db.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/auth.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/modal-system.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/components.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/guide-presets.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/search.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/shortcuts.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/notifications.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/onboarding.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/export-doc.js?v=<?= INDUZI_VERSION ?>"></script>
<script src="js/spa.js?v=<?= INDUZI_VERSION ?>"></script>
<script>
(async function() {
    await InduziAuth.init();
    await InduziTheme.init();
    if (!InduziAuth.isLoggedIn()) { window.location.href = 'login.php'; return; }
    InduziAuth.populateSidebar();
    InduziTheme.updateToggle();
    if (window.InduziNotifications) InduziNotifications.init();
    if (window.InduziOnboarding) InduziOnboarding.autoTrigger();
    SpaRouter.init();
    if (window.InduziExportDoc) InduziExportDoc.init();
})();
</script>
</body>
</html>
