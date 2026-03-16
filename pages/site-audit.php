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
<title>Site Audit — Induzi</title>
<link rel="stylesheet" href="../css/style.css?v=<?= INDUZI_VERSION ?>">
<style>
.audit-header { margin-bottom: 24px; }
.audit-header h1 { font-size: 1.3rem; font-weight: 700; color: var(--color-black); display: flex; align-items: center; gap: 10px; }
.audit-header h1 svg { width: 22px; height: 22px; stroke: var(--color-accent); }

/* Input bar */
.audit-input-bar { display: flex; gap: 10px; margin-bottom: 16px; }
.audit-input-bar input {
    flex: 1; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;
    background: var(--color-white); color: var(--color-black); font-size: 0.92rem;
    outline: none; transition: border-color .2s;
}
.audit-input-bar input:focus { border-color: var(--color-accent); }
.audit-input-bar button {
    padding: 10px 20px; border: none; border-radius: 8px; background: var(--color-accent);
    color: #fff; font-weight: 600; font-size: 0.9rem; cursor: pointer; white-space: nowrap;
    display: flex; align-items: center; gap: 6px; transition: opacity .2s;
}
.audit-input-bar button:hover { opacity: .9; }
.audit-input-bar button:disabled { opacity: .5; cursor: not-allowed; }
.audit-input-bar button svg { width: 16px; height: 16px; }

.audit-last-scan { font-size: 0.8rem; color: var(--color-gray-light); margin-bottom: 20px; }
.audit-last-scan a { color: var(--color-accent); cursor: pointer; text-decoration: none; }

/* Score section */
.audit-score-section {
    display: flex; gap: 32px; align-items: center; flex-wrap: wrap;
    padding: 24px; background: var(--color-card-bg); border: 1px solid var(--color-border);
    border-radius: 12px; margin-bottom: 24px;
}
.audit-ring-wrap { position: relative; width: 140px; height: 140px; flex-shrink: 0; }
.audit-ring-wrap svg { width: 100%; height: 100%; transform: rotate(-90deg); }
.audit-ring-bg { fill: none; stroke: var(--color-border); stroke-width: 10; }
.audit-ring-fg { fill: none; stroke-width: 10; stroke-linecap: round; transition: stroke-dashoffset .8s ease, stroke .3s; }
.audit-ring-label {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
    text-align: center; line-height: 1.2;
}
.audit-ring-score { font-size: 2.2rem; font-weight: 800; color: var(--color-black); display: block; }
.audit-ring-of { font-size: 0.75rem; color: var(--color-gray-light); }

.audit-cat-bars { flex: 1; min-width: 220px; display: flex; flex-direction: column; gap: 10px; }
.audit-cat-row { display: flex; align-items: center; gap: 10px; }
.audit-cat-name { width: 120px; font-size: 0.85rem; font-weight: 500; color: var(--color-black); text-align: right; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.audit-cat-track { flex: 1; height: 8px; background: var(--color-border); border-radius: 4px; overflow: hidden; }
.audit-cat-fill { height: 100%; border-radius: 4px; transition: width .6s ease; }
.audit-cat-val { width: 30px; font-size: 0.82rem; font-weight: 600; color: var(--color-gray); text-align: right; }

/* Meta bar */
.audit-meta {
    display: flex; gap: 16px; flex-wrap: wrap; padding: 12px 16px;
    background: var(--color-card-bg); border: 1px solid var(--color-border);
    border-radius: 8px; margin-bottom: 24px; font-size: 0.82rem; color: var(--color-gray);
}
.audit-meta span { white-space: nowrap; }

/* Category accordions */
.audit-category { margin-bottom: 16px; border: 1px solid var(--color-border); border-radius: 10px; overflow: hidden; background: var(--color-card-bg); }
.audit-cat-header {
    display: flex; align-items: center; gap: 10px; padding: 14px 16px;
    cursor: pointer; user-select: none; transition: background .15s;
}
.audit-cat-header:hover { background: var(--color-hover); }
.audit-cat-chevron { width: 18px; height: 18px; stroke: var(--color-gray); transition: transform .2s; flex-shrink: 0; }
.audit-category.open .audit-cat-chevron { transform: rotate(90deg); }
.audit-cat-header-title { font-weight: 600; font-size: 0.92rem; color: var(--color-black); }
.audit-cat-header-score { font-weight: 700; font-size: 0.88rem; margin-left: 4px; }
.audit-cat-header-summary { margin-left: auto; font-size: 0.78rem; color: var(--color-gray-light); white-space: nowrap; }
.audit-cat-body { display: none; padding: 0 16px 14px; }
.audit-category.open .audit-cat-body { display: block; }

/* Check items */
.audit-check { display: flex; gap: 10px; padding: 10px 0; border-bottom: 1px solid var(--color-border); align-items: flex-start; }
.audit-check:last-child { border-bottom: none; }
.audit-check-icon { width: 20px; height: 20px; flex-shrink: 0; margin-top: 1px; }
.audit-check-icon.pass { color: var(--color-success, #22c55e); }
.audit-check-icon.fail { color: var(--color-danger, #ef4444); }
.audit-check-icon.parcial { color: var(--color-warning, #f59e0b); }
.audit-check-body { flex: 1; min-width: 0; }
.audit-check-name { font-weight: 600; font-size: 0.88rem; color: var(--color-black); }
.audit-check-detail { font-size: 0.82rem; color: var(--color-gray); margin-top: 2px; word-break: break-word; }
.audit-check-tip { font-size: 0.8rem; color: var(--color-accent); margin-top: 4px; padding: 6px 10px; background: var(--color-accent-bg, rgba(139,92,246,.08)); border-radius: 6px; }

/* States */
.audit-empty { text-align: center; padding: 60px 20px; color: var(--color-gray-light); }
.audit-empty svg { width: 48px; height: 48px; stroke: var(--color-gray-lighter); margin-bottom: 12px; }
.audit-empty p { font-size: 0.95rem; }

.audit-loading { text-align: center; padding: 60px 20px; }
.audit-loading .spinner { width: 40px; height: 40px; border: 3px solid var(--color-border); border-top-color: var(--color-accent); border-radius: 50%; animation: auditSpin 0.7s linear infinite; margin: 0 auto 16px; }
@keyframes auditSpin { to { transform: rotate(360deg); } }
.audit-loading p { color: var(--color-gray); font-size: 0.92rem; }

.audit-error { text-align: center; padding: 40px 20px; color: var(--color-danger, #ef4444); }
.audit-error svg { width: 40px; height: 40px; margin-bottom: 10px; }
.audit-error p { margin-bottom: 14px; font-size: 0.92rem; }
.audit-error button { padding: 8px 18px; border: 1px solid var(--color-border); border-radius: 8px; background: var(--color-white); color: var(--color-black); cursor: pointer; font-size: 0.88rem; }

/* Colors */
.score-red { color: var(--color-danger, #ef4444); }
.score-yellow { color: var(--color-warning, #f59e0b); }
.score-green { color: var(--color-success, #22c55e); }
.fill-red { background: var(--color-danger, #ef4444); }
.fill-yellow { background: var(--color-warning, #f59e0b); }
.fill-green { background: var(--color-success, #22c55e); }
.stroke-red { stroke: var(--color-danger, #ef4444); }
.stroke-yellow { stroke: var(--color-warning, #f59e0b); }
.stroke-green { stroke: var(--color-success, #22c55e); }

/* Export button */
.audit-actions { display: flex; gap: 10px; margin-bottom: 24px; }
.audit-export-btn {
    display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px;
    border: 1px solid var(--color-border); border-radius: 8px; background: var(--color-card-bg);
    color: var(--color-black); font-size: 0.85rem; font-weight: 500; cursor: pointer; transition: background .15s, border-color .15s;
}
.audit-export-btn:hover { border-color: var(--color-accent); background: var(--color-hover); }
.audit-export-btn svg { width: 16px; height: 16px; stroke: var(--color-accent); }

/* Responsive */
@media (max-width: 600px) {
    .audit-score-section { flex-direction: column; align-items: center; gap: 20px; }
    .audit-cat-name { width: 90px; font-size: 0.8rem; }
    .audit-input-bar { flex-direction: column; }
    .audit-input-bar button { width: 100%; justify-content: center; }
}
</style>
</head>
<?php if (!isset($_GET['fragment'])): ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>
<?php endif; ?>
<div class="main-content">
    <div class="container">
        <div class="audit-header">
            <h1>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path><rect x="9" y="3" width="6" height="4" rx="1"></rect><path d="M9 14l2 2 4-4"></path></svg>
                Site Audit
            </h1>
        </div>

        <div class="audit-input-bar">
            <input type="url" id="auditUrl" placeholder="https://exemplo.com.br" autocomplete="url" spellcheck="false">
            <button id="auditBtn" onclick="runAudit()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                Analisar
            </button>
        </div>
        <div id="auditLastScan" class="audit-last-scan" style="display:none;"></div>

        <div id="auditContent">
            <div class="audit-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"></path><rect x="9" y="3" width="6" height="4" rx="1"></rect><path d="M9 14l2 2 4-4"></path></svg>
                <p>Insira a URL de um site para analisar.</p>
            </div>
        </div>
    </div>
</div>
<script>
(function() {
    var DATA_KEY = 'induziSiteAudit';
    var urlInput = document.getElementById('auditUrl');
    var btn = document.getElementById('auditBtn');
    var content = document.getElementById('auditContent');
    var lastScanEl = document.getElementById('auditLastScan');
    var currentData = null;

    // ─── Score colors ────────────────────────────────────────
    function scoreColor(s) { return s >= 80 ? 'green' : s >= 50 ? 'yellow' : 'red'; }
    function scoreColorClass(s) { return 'score-' + scoreColor(s); }
    function fillClass(s) { return 'fill-' + scoreColor(s); }
    function strokeClass(s) { return 'stroke-' + scoreColor(s); }

    // ─── Format helpers ──────────────────────────────────────
    function formatDate(iso) {
        if (!iso) return '';
        var d = new Date(iso);
        return d.toLocaleDateString('pt-BR') + ' ' + d.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
    }
    function formatSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return Math.round(bytes / 1024) + ' KB';
        return (bytes / 1048576).toFixed(2) + ' MB';
    }
    function escHtml(s) {
        var d = document.createElement('div'); d.textContent = s; return d.innerHTML;
    }

    // ─── SVG Ring ────────────────────────────────────────────
    function renderRing(score) {
        var r = 58, c = 2 * Math.PI * r;
        var offset = c - (score / 100) * c;
        var cls = strokeClass(score);
        return '<div class="audit-ring-wrap">' +
            '<svg viewBox="0 0 140 140">' +
            '<circle class="audit-ring-bg" cx="70" cy="70" r="' + r + '"></circle>' +
            '<circle class="audit-ring-fg ' + cls + '" cx="70" cy="70" r="' + r + '" ' +
            'stroke-dasharray="' + c.toFixed(2) + '" stroke-dashoffset="' + offset.toFixed(2) + '"></circle>' +
            '</svg>' +
            '<div class="audit-ring-label">' +
            '<span class="audit-ring-score ' + scoreColorClass(score) + '">' + score + '</span>' +
            '<span class="audit-ring-of">/100</span>' +
            '</div></div>';
    }

    // ─── Category bars ───────────────────────────────────────
    function renderCatBars(categories) {
        var html = '<div class="audit-cat-bars">';
        var order = ['seo', 'marketing', 'seguranca', 'performance', 'acessibilidade', 'estrutura'];
        for (var i = 0; i < order.length; i++) {
            var k = order[i];
            var cat = categories[k];
            if (!cat) continue;
            var cls = fillClass(cat.score);
            html += '<div class="audit-cat-row">' +
                '<span class="audit-cat-name">' + escHtml(cat.label) + '</span>' +
                '<div class="audit-cat-track"><div class="audit-cat-fill ' + cls + '" style="width:' + cat.score + '%"></div></div>' +
                '<span class="audit-cat-val ' + scoreColorClass(cat.score) + '">' + cat.score + '</span>' +
                '</div>';
        }
        html += '</div>';
        return html;
    }

    // ─── Check icons ─────────────────────────────────────────
    function checkIcon(status) {
        if (status === 'pass') return '<svg class="audit-check-icon pass" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';
        if (status === 'fail') return '<svg class="audit-check-icon fail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
        return '<svg class="audit-check-icon parcial" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>';
    }

    // ─── Render checks list ──────────────────────────────────
    function renderChecks(checks) {
        // Sort: fail first, then parcial, then pass
        var sorted = checks.slice().sort(function(a, b) {
            var order = { fail: 0, parcial: 1, pass: 2 };
            return (order[a.status] || 2) - (order[b.status] || 2);
        });
        var html = '';
        for (var i = 0; i < sorted.length; i++) {
            var ch = sorted[i];
            html += '<div class="audit-check">' +
                checkIcon(ch.status) +
                '<div class="audit-check-body">' +
                '<div class="audit-check-name">' + escHtml(ch.name) + '</div>' +
                '<div class="audit-check-detail">' + escHtml(ch.detail) + '</div>';
            if (ch.tip && ch.status !== 'pass') {
                html += '<div class="audit-check-tip">' + escHtml(ch.tip) + '</div>';
            }
            html += '</div></div>';
        }
        return html;
    }

    // ─── Category summary ────────────────────────────────────
    function catSummary(checks) {
        var ok = 0, parcial = 0, fail = 0;
        for (var i = 0; i < checks.length; i++) {
            if (checks[i].status === 'pass') ok++;
            else if (checks[i].status === 'parcial') parcial++;
            else fail++;
        }
        var parts = [];
        if (ok) parts.push(ok + ' ok');
        if (parcial) parts.push(parcial + ' parcial');
        if (fail) parts.push(fail + ' falha');
        return parts.join(', ');
    }

    // ─── Render full results ─────────────────────────────────
    function renderResults(data) {
        var html = '';

        // Score section
        html += '<div class="audit-score-section">' +
            renderRing(data.score) +
            renderCatBars(data.categories) +
            '</div>';

        // Meta bar
        var domain = data.finalUrl || data.url;
        try { domain = new URL(domain).hostname; } catch (e) {}
        html += '<div class="audit-meta">' +
            '<span>URL: ' + escHtml(domain) + '</span>' +
            '<span>Tempo: ' + data.responseTime + 's</span>' +
            '<span>' + formatSize(data.pageSize) + '</span>' +
            '<span>HTTP ' + data.httpCode + '</span>' +
            '</div>';

        // Actions bar
        var hasIssues = false;
        var catKeys = ['seo', 'marketing', 'seguranca', 'performance', 'acessibilidade', 'estrutura'];;
        for (var ci = 0; ci < catKeys.length; ci++) {
            var cc = data.categories[catKeys[ci]];
            if (cc) for (var cj = 0; cj < cc.checks.length; cj++) {
                if (cc.checks[cj].status !== 'pass') { hasIssues = true; break; }
            }
            if (hasIssues) break;
        }
        if (hasIssues) {
            html += '<div class="audit-actions">' +
                '<button class="audit-export-btn" onclick="exportAuditFixes()">' +
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>' +
                'Exportar Correcoes' +
                '</button></div>';
        }

        // Category accordions
        var order = ['seo', 'marketing', 'seguranca', 'performance', 'acessibilidade', 'estrutura'];
        for (var i = 0; i < order.length; i++) {
            var k = order[i];
            var cat = data.categories[k];
            if (!cat) continue;
            html += '<div class="audit-category">' +
                '<div class="audit-cat-header" onclick="this.parentElement.classList.toggle(\'open\')">' +
                '<svg class="audit-cat-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>' +
                '<span class="audit-cat-header-title">' + escHtml(cat.label) + '</span>' +
                '<span class="audit-cat-header-score ' + scoreColorClass(cat.score) + '">(' + cat.score + ')</span>' +
                '<span class="audit-cat-header-summary">' + catSummary(cat.checks) + '</span>' +
                '</div>' +
                '<div class="audit-cat-body">' + renderChecks(cat.checks) + '</div>' +
                '</div>';
        }

        content.innerHTML = html;
    }

    // ─── Show last scan info ─────────────────────────────────
    function showLastScan(data) {
        if (!data || !data.scannedAt) { lastScanEl.style.display = 'none'; return; }
        lastScanEl.innerHTML = 'Ultimo scan: ' + formatDate(data.scannedAt) +
            ' &nbsp;|&nbsp; <a onclick="runAudit(); return false;" href="#">Atualizar</a>';
        lastScanEl.style.display = '';
    }

    // ─── Load saved data ─────────────────────────────────────
    function loadSaved() {
        if (typeof InduziDB === 'undefined') return;
        InduziDB.load(DATA_KEY, function(data) {
            if (data && data.score !== undefined) {
                currentData = data;
                if (data.url) urlInput.value = data.url;
                renderResults(data);
                showLastScan(data);
            }
        });
    }

    // ─── Save data ───────────────────────────────────────────
    function saveData(data) {
        if (typeof InduziDB === 'undefined') return;
        InduziDB.save(DATA_KEY, data);
    }

    // ─── Run audit ───────────────────────────────────────────
    window.runAudit = function() {
        var url = urlInput.value.trim();
        if (!url) {
            if (typeof Igris !== 'undefined') Igris.toast('Insira uma URL para analisar.', 'error');
            urlInput.focus();
            return;
        }

        btn.disabled = true;
        content.innerHTML = '<div class="audit-loading"><div class="spinner"></div><p>Analisando o site...</p></div>';
        lastScanEl.style.display = 'none';

        var base = (typeof InduziDB !== 'undefined' && InduziDB._getApiBase) ? InduziDB._getApiBase() : '../api/';
        fetch(base + 'audit/run.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ url: url })
        })
        .then(function(resp) { return resp.json(); })
        .then(function(data) {
            btn.disabled = false;
            if (!data.ok) {
                content.innerHTML = '<div class="audit-error">' +
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>' +
                    '<p>' + escHtml(data.msg || 'Erro ao analisar o site.') + '</p>' +
                    '<button onclick="runAudit()">Tentar novamente</button>' +
                    '</div>';
                return;
            }
            currentData = data;
            renderResults(data);
            showLastScan(data);
            saveData(data);
            if (typeof Igris !== 'undefined') Igris.toast('Analise concluida! Score: ' + data.score + '/100', 'success');
        })
        .catch(function(err) {
            btn.disabled = false;
            content.innerHTML = '<div class="audit-error">' +
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>' +
                '<p>Erro de conexao. Verifique sua rede e tente novamente.</p>' +
                '<button onclick="runAudit()">Tentar novamente</button>' +
                '</div>';
        });
    };

    // ─── Export fixes as Markdown ──────────────────────────
    window.exportAuditFixes = function() {
        if (!currentData || !currentData.categories) return;

        var statusLabel = { fail: 'Falha', parcial: 'Parcial' };
        var statusIcon = { fail: '❌', parcial: '⚠️' };
        var order = ['seo', 'marketing', 'seguranca', 'performance', 'acessibilidade', 'estrutura'];
        var domain = currentData.finalUrl || currentData.url;
        try { domain = new URL(domain).hostname; } catch (e) {}

        var lines = [];
        lines.push('# Site Audit — Correcoes Necessarias');
        lines.push('');
        lines.push('- **URL:** ' + (currentData.finalUrl || currentData.url));
        lines.push('- **Score:** ' + currentData.score + '/100');
        lines.push('- **Data:** ' + formatDate(currentData.scannedAt));
        lines.push('');
        lines.push('---');

        var totalFixes = 0;

        for (var i = 0; i < order.length; i++) {
            var k = order[i];
            var cat = currentData.categories[k];
            if (!cat) continue;

            var issues = [];
            for (var j = 0; j < cat.checks.length; j++) {
                var ch = cat.checks[j];
                if (ch.status === 'fail' || ch.status === 'parcial') {
                    issues.push(ch);
                }
            }
            if (!issues.length) continue;

            totalFixes += issues.length;
            lines.push('');
            lines.push('## ' + cat.label + ' (Score: ' + cat.score + '/100)');
            lines.push('');

            // Failures first, then parcial
            issues.sort(function(a, b) {
                var ord = { fail: 0, parcial: 1 };
                return (ord[a.status] || 1) - (ord[b.status] || 1);
            });

            for (var n = 0; n < issues.length; n++) {
                var item = issues[n];
                lines.push('### ' + statusIcon[item.status] + ' ' + item.name + ' (' + statusLabel[item.status] + ')');
                lines.push('');
                lines.push('- **Diagnostico:** ' + item.detail);
                if (item.tip) {
                    lines.push('- **Correcao:** ' + item.tip);
                }
                lines.push('');
            }
        }

        // Summary at end
        lines.push('---');
        lines.push('');
        lines.push('**Total de correcoes:** ' + totalFixes + ' item(s)');
        lines.push('');
        lines.push('*Relatorio gerado pelo Induzi Site Audit*');

        var text = lines.join('\n');
        var blob = new Blob([text], { type: 'text/markdown;charset=utf-8' });
        var a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = 'audit-correcoes-' + domain.replace(/[^a-z0-9.-]/gi, '_') + '.md';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(a.href);

        if (typeof Igris !== 'undefined') Igris.toast('Correcoes exportadas!', 'success');
    };

    // Enter key on input
    urlInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); runAudit(); }
    });

    // Load saved on init
    loadSaved();

    window._spaCleanup = function() {};
})();
</script>
<?php if (!isset($_GET['fragment'])): ?>
</div></body></html>
<?php endif; ?>
<?php spaFragmentEnd(); ?>
