<?php require_once __DIR__ . '/../includes/fragment.php'; spaFragmentStart(); ?>
<?php require_once __DIR__ . '/../includes/db.php'; ?>
<?php require_once __DIR__ . '/../includes/helpers.php'; ?>
<?php require_once __DIR__ . '/../includes/auth.php'; ?>
<?php require_once __DIR__ . '/../version.php'; ?>
<?php $sbInPages = true; $sbPrefix = ''; $sbRoot = '../'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Atividades — Induzi</title>
<link rel="stylesheet" href="../css/style.css?v=<?= INDUZI_VERSION ?>">
<style>
.activity-header { margin-bottom: 24px; }
.activity-header h1 { font-size: 1.3rem; font-weight: 700; color: var(--color-black); }
.timeline { position: relative; padding-left: 24px; }
.timeline::before { content: ''; position: absolute; left: 8px; top: 0; bottom: 0; width: 2px; background: var(--color-border); }
.timeline-item { position: relative; padding: 12px 0 12px 16px; }
.timeline-item::before { content: ''; position: absolute; left: -20px; top: 18px; width: 10px; height: 10px; border-radius: 50%; background: var(--color-gray-lighter); border: 2px solid var(--color-white); }
.timeline-item.action-save::before { background: var(--color-accent); }
.timeline-item.action-create::before { background: var(--color-success); }
.timeline-item.action-delete::before { background: var(--color-danger); }
.timeline-item.action-update::before { background: var(--color-warning); }
.timeline-action { font-size: 0.88rem; color: var(--color-black); font-weight: 500; }
.timeline-detail { font-size: 0.82rem; color: var(--color-gray); margin-top: 2px; }
.timeline-meta { font-size: 0.75rem; color: var(--color-gray-light); margin-top: 4px; display: flex; gap: 12px; }
.load-more { display: block; margin: 20px auto; }
.activity-empty { text-align: center; padding: 60px 20px; color: var(--color-gray-light); }
</style>
</head>
<?php if (!isset($_GET['fragment'])): ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>
<?php endif; ?>
<div class="main-content">
    <div class="container">
        <div class="activity-header">
            <h1>Atividades</h1>
        </div>
        <div id="activityTimeline"></div>
        <button class="btn-action load-more" id="loadMoreBtn" style="display:none;" onclick="loadMoreActivities()">Carregar mais</button>
    </div>
</div>
<script>
(function() {
    var currentPage = 0;
    var totalItems = 0;
    var perPage = 30;
    var container = document.getElementById('activityTimeline');

    var actionLabels = {
        'data.save': 'Dados salvos',
        'project.create': 'Projeto criado',
        'project.update': 'Projeto atualizado',
        'project.delete': 'Projeto excluido'
    };

    var actionClass = {
        'data.save': 'action-save',
        'project.create': 'action-create',
        'project.update': 'action-update',
        'project.delete': 'action-delete'
    };

    function formatDate(dateStr) {
        if (!dateStr) return '';
        var d = new Date(dateStr);
        return d.toLocaleDateString('pt-BR') + ' ' + d.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
    }

    function renderActivities(activities, append) {
        if (!append) container.innerHTML = '';
        if (!activities.length && !append) {
            container.innerHTML = '<div class="activity-empty"><p>Nenhuma atividade registrada.</p></div>';
            return;
        }
        var html = append ? '' : '<div class="timeline">';
        for (var i = 0; i < activities.length; i++) {
            var a = activities[i];
            var cls = actionClass[a.action] || '';
            var label = actionLabels[a.action] || a.action;
            var detail = '';
            if (a.details) {
                if (a.details.key) detail = 'Modulo: ' + a.details.key.replace('induzi', '');
                if (a.details.nome) detail = a.details.nome;
            }
            html += '<div class="timeline-item ' + cls + '">';
            html += '<div class="timeline-action">' + label + '</div>';
            if (detail) html += '<div class="timeline-detail">' + detail + '</div>';
            html += '<div class="timeline-meta"><span>' + (a.user_nome || 'Sistema') + '</span><span>' + formatDate(a.created_at) + '</span></div>';
            html += '</div>';
        }
        if (!append) html += '</div>';

        if (append) {
            var timeline = container.querySelector('.timeline');
            if (timeline) timeline.insertAdjacentHTML('beforeend', html);
        } else {
            container.innerHTML = html;
        }
    }

    async function loadActivities(page) {
        var base = InduziDB._getApiBase();
        var resp = await fetch(base + 'data/activity.php?page=' + page + '&_t=' + Date.now(), { cache: 'no-store', credentials: 'same-origin' });
        var data = await resp.json();
        if (data.ok) {
            totalItems = data.total;
            perPage = data.perPage;
            currentPage = data.page;
            renderActivities(data.activities, page > 1);
            var btn = document.getElementById('loadMoreBtn');
            btn.style.display = (currentPage * perPage < totalItems) ? '' : 'none';
        }
    }

    window.loadMoreActivities = function() {
        loadActivities(currentPage + 1);
    };

    loadActivities(1);

    window._spaCleanup = function() {};
})();
</script>
<?php if (!isset($_GET['fragment'])): ?>
</div></body></html>
<?php endif; ?>
<?php spaFragmentEnd(); ?>
