<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/fragment.php';
require_once __DIR__ . '/../../includes/analytics-data.php';
spaFragmentStart();
requireAuth();
session_write_close();
spaPreload(getAnalyticsData(getDB()));
?>
<style>
.chart-title { font-size:0.9rem; font-weight:600; color:var(--text-primary); margin:0; }
.section-title { font-size:0.95rem; margin-bottom:12px; color:var(--text-secondary); }
.chart-badge { font-size:0.72rem; font-weight:600; padding:2px 8px; border-radius:var(--radius-full); }
.chart-badge.up { background:var(--color-success-light); color:var(--color-success); }
.chart-badge.down { background:var(--color-danger-light); color:var(--color-danger); }
.chart-badge.neutral { background:var(--bg-tertiary); color:var(--text-muted); }
.stat-card { text-decoration:none; color:inherit; display:block; }
.stat-card:hover { text-decoration:none; }
.stat-card .card { transition:border-color .2s, transform .1s; }
.stat-card:hover .card { border-color:var(--color-accent); transform:translateY(-1px); }
.stat-icon { width:36px; height:36px; border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; margin-bottom:12px; }
.stat-icon svg { width:18px; height:18px; }
.stat-trend { display:inline-flex; align-items:center; gap:3px; font-size:0.72rem; font-weight:600; margin-left:6px; }
.stat-trend.up { color:var(--color-success); }
.stat-trend.down { color:var(--color-danger); }
.bar-chart { display:flex; align-items:flex-end; gap:8px; height:140px; padding-top:8px; }
.bar-col { flex:1; display:flex; flex-direction:column; align-items:center; gap:4px; height:100%; justify-content:flex-end; }
.bar-value { font-size:0.7rem; color:var(--text-muted); font-weight:600; }
.bar-fill { width:100%; border-radius:4px 4px 0 0; transition:height .6s ease; min-height:2px; }
.bar-fill.accent { background:var(--color-accent); }
.bar-fill.info { background:var(--color-info); }
.bar-label { font-size:0.68rem; color:var(--text-muted); }
.donut-wrap { position:relative; width:120px; height:120px; flex-shrink:0; }
.donut-center { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
.donut-center-value { font-size:1.2rem; font-weight:700; color:var(--text-primary); }
.donut-center-label { font-size:0.65rem; color:var(--text-muted); }
.donut-legend { flex:1; display:flex; flex-direction:column; gap:6px; }
.donut-legend-item { display:flex; align-items:center; gap:8px; font-size:0.8rem; }
.donut-legend-dot { width:10px; height:10px; border-radius:2px; flex-shrink:0; }
.donut-legend-count { margin-left:auto; font-weight:600; color:var(--text-primary); font-size:0.8rem; }
.hbar-row { display:flex; align-items:center; gap:10px; margin-bottom:8px; }
.hbar-label { width:90px; font-size:0.78rem; color:var(--text-secondary); text-align:right; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.hbar-track { flex:1; height:20px; background:var(--bg-tertiary); border-radius:var(--radius-sm); overflow:hidden; }
.hbar-fill { height:100%; border-radius:var(--radius-sm); transition:width .6s ease; background:var(--color-accent); }
.hbar-count { width:30px; font-size:0.75rem; font-weight:600; color:var(--text-primary); }
.activity-item { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid var(--border-light); font-size:0.82rem; }
.activity-item:last-child { border-bottom:none; }
.lead-row { padding:10px 12px; margin-bottom:6px; border-radius:var(--radius-md); background:var(--bg-secondary); border:1px solid var(--border); }
.lead-row-top { display:flex; justify-content:space-between; align-items:center; margin-bottom:4px; }
.lead-row-name { font-weight:600; font-size:0.85rem; }
.lead-row-bottom { display:flex; gap:12px; font-size:0.75rem; color:var(--text-muted); }
</style>
<div class="main-content">
<div class="container">
    <div class="page-header-compact">
        <h1>Painel</h1>
        <span class="page-header-stats" id="painelPeriodo"></span>
    </div>

    <div id="painelLoading"><p style="color:var(--text-muted)">Carregando analytics...</p></div>
    <div id="painelContent" style="display:none">

        <!-- Stats Cards -->
        <div class="grid-4" style="margin-bottom:24px" id="statsCards"></div>

        <!-- Charts Row -->
        <div class="grid-2" style="margin-bottom:24px">
            <div class="card" style="padding:20px">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
                    <h3 class="chart-title">Leads por Mes</h3>
                    <span class="chart-badge" id="leadsTrend"></span>
                </div>
                <div id="chartLeads" class="bar-chart"></div>
            </div>
            <div class="card" style="padding:20px">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
                    <h3 class="chart-title">Status dos Leads</h3>
                    <span style="font-size:0.75rem;color:var(--text-muted)" id="taxaConversao"></span>
                </div>
                <div id="chartStatus" style="display:flex;align-items:center;gap:20px"></div>
            </div>
        </div>

        <div class="grid-2" style="margin-bottom:24px">
            <div class="card" style="padding:20px">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
                    <h3 class="chart-title">Newsletter</h3>
                    <span class="chart-badge" id="nlTrend"></span>
                </div>
                <div id="chartNewsletter" class="bar-chart"></div>
            </div>
            <div class="card" style="padding:20px">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
                    <h3 class="chart-title">Origem dos Leads</h3>
                </div>
                <div id="chartOrigem"></div>
            </div>
        </div>

        <!-- Bottom Row -->
        <div class="grid-2">
            <div>
                <h3 class="section-title">Leads Recentes</h3>
                <div id="leadsRecentes"></div>
            </div>
            <div>
                <h3 class="section-title">Atividade Recente</h3>
                <div id="atividadeRecente"></div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
(function(){
    var _statusColors = {
        'novo': 'var(--color-info)',
        'contatado': 'var(--color-warning)',
        'convertido': 'var(--color-success)',
        'descartado': 'var(--color-danger)'
    };
    var _statusLabels = {
        'novo': 'Novo',
        'contatado': 'Contatado',
        'convertido': 'Convertido',
        'descartado': 'Descartado'
    };

    async function load() {
        try {
            var res = await IgrisDB.fetch('api/painel/analytics.php');
            var d = await res.json();
            if (!d.ok) throw new Error(d.msg || 'Erro ao carregar');
            render(d);
        } catch(e) {
            document.getElementById('painelLoading').innerHTML =
                '<div class="card" style="padding:20px;text-align:center"><p style="color:var(--color-danger)">' + _esc(e.message) + '</p><button class="btn btn-sm btn-secondary" style="margin-top:10px" onclick="SpaRouter.navigateTo(\'painel\')">Tentar novamente</button></div>';
        }
    }

    function render(data) {
        document.getElementById('painelLoading').style.display = 'none';
        document.getElementById('painelContent').style.display = '';
        document.getElementById('painelPeriodo').textContent = 'Ultimos 6 meses';

        renderStats(data.overview, data.growth);
        renderBarChart('chartLeads', data.leads_por_mes, 'accent', 'leadsTrend', data.growth.leads);
        renderBarChart('chartNewsletter', data.newsletter_por_mes, 'info', 'nlTrend', data.growth.newsletter);
        renderDonut(data.leads_por_status, data.overview.leads_total, data.taxa_conversao);
        renderOrigemChart(data.leads_por_origem);
        renderLeadsRecentes(data.leads_recentes);
        renderAtividade(data.atividade_recente);
    }

    function renderStats(ov, growth) {
        var cards = [
            { title:'Contatos', value: ov.mensagens_nao_lidas, sub: ov.mensagens_total + ' total', route:'mensagens', icon: msgIcon(), color:'var(--color-info)', growth: growth.mensagens },
            { title:'Newsletter', value: ov.newsletter_ativos, sub: 'inscritos ativos', route:'newsletter', icon: nlIcon(), color:'var(--color-success)', growth: growth.newsletter },
            { title:'Leads', value: ov.leads_novos, sub: ov.leads_total + ' total', route:'leads', icon: leadIcon(), color:'var(--color-warning)', growth: growth.leads },
            { title:'Conversao', value: (ov.leads_total > 0 ? Math.round((ov.leads_convertidos / ov.leads_total) * 100) : 0) + '%', sub: ov.leads_convertidos + ' convertidos', route: null, icon: convIcon(), color:'var(--color-accent)', growth: null },
        ];

        var html = '';
        cards.forEach(function(c) {
            var trendHtml = '';
            if (c.growth) {
                var p = c.growth.percentual;
                var cls = p > 0 ? 'up' : (p < 0 ? 'down' : '');
                var arrow = p > 0 ? '&#9650;' : (p < 0 ? '&#9660;' : '');
                if (p !== 0) trendHtml = '<span class="stat-trend ' + cls + '">' + arrow + ' ' + Math.abs(p) + '%</span>';
            }
            var tag = c.route ? 'a' : 'div';
            var routeAttrs = c.route ? ' href="' + (window._adminBase || '') + c.route + '" data-route="' + c.route + '"' : '';
            html += '<' + tag + ' class="stat-card"' + routeAttrs + '>' +
                '<div class="card">' +
                    '<div class="stat-icon" style="background:' + c.color + '20;color:' + c.color + '">' + c.icon + '</div>' +
                    '<div class="card-title">' + c.title + '</div>' +
                    '<div class="card-value">' + c.value + trendHtml + '</div>' +
                    '<div class="card-subtitle">' + c.sub + '</div>' +
                '</div>' +
            '</' + tag + '>';
        });
        document.getElementById('statsCards').innerHTML = html;
    }

    function renderBarChart(containerId, data, colorClass, trendId, growth) {
        var container = document.getElementById(containerId);
        var max = 0;
        data.forEach(function(d) { if (d.total > max) max = d.total; });
        if (max === 0) max = 1;

        var html = '';
        data.forEach(function(d) {
            var h = Math.max(2, (d.total / max) * 110);
            html += '<div class="bar-col">' +
                '<span class="bar-value">' + d.total + '</span>' +
                '<div class="bar-fill ' + colorClass + '" style="height:' + h + 'px"></div>' +
                '<span class="bar-label">' + d.label + '</span>' +
            '</div>';
        });
        container.innerHTML = html;

        if (trendId && growth) {
            var el = document.getElementById(trendId);
            var p = growth.percentual;
            if (p > 0) { el.className = 'chart-badge up'; el.innerHTML = '&#9650; ' + p + '% este mes'; }
            else if (p < 0) { el.className = 'chart-badge down'; el.innerHTML = '&#9660; ' + Math.abs(p) + '% este mes'; }
            else { el.className = 'chart-badge neutral'; el.textContent = '= este mes'; }
        }
    }

    function renderDonut(statusData, total, taxa) {
        var container = document.getElementById('chartStatus');
        document.getElementById('taxaConversao').textContent = 'Conversao: ' + taxa + '%';

        if (total === 0) {
            container.innerHTML = '<div style="text-align:center;width:100%;padding:20px;color:var(--text-muted);font-size:0.85rem">Nenhum lead registrado</div>';
            return;
        }

        // SVG donut
        var size = 120, r = 46, cx = 60, cy = 60, circ = 2 * Math.PI * r;
        var svg = '<svg width="' + size + '" height="' + size + '" viewBox="0 0 120 120">';
        svg += '<circle cx="60" cy="60" r="' + r + '" fill="none" stroke="var(--bg-tertiary)" stroke-width="12"/>';

        var offset = 0;
        statusData.forEach(function(s) {
            var pct = s.total / total;
            var dash = pct * circ;
            var gap = circ - dash;
            var color = _statusColors[s.status] || 'var(--text-muted)';
            svg += '<circle cx="60" cy="60" r="' + r + '" fill="none" stroke="' + color + '" stroke-width="12" ' +
                'stroke-dasharray="' + dash + ' ' + gap + '" ' +
                'stroke-dashoffset="' + (-offset) + '" ' +
                'transform="rotate(-90 60 60)" style="transition:stroke-dasharray .6s"/>';
            offset += dash;
        });
        svg += '</svg>';

        var legend = '';
        statusData.forEach(function(s) {
            var color = _statusColors[s.status] || 'var(--text-muted)';
            var label = _statusLabels[s.status] || s.status;
            legend += '<div class="donut-legend-item">' +
                '<span class="donut-legend-dot" style="background:' + color + '"></span>' +
                '<span>' + label + '</span>' +
                '<span class="donut-legend-count">' + s.total + '</span>' +
            '</div>';
        });

        container.innerHTML =
            '<div class="donut-wrap">' + svg +
                '<div class="donut-center"><span class="donut-center-value">' + total + '</span><span class="donut-center-label">total</span></div>' +
            '</div>' +
            '<div class="donut-legend">' + legend + '</div>';
    }

    function renderOrigemChart(data) {
        var container = document.getElementById('chartOrigem');
        if (!data.length) {
            container.innerHTML = '<p style="color:var(--text-muted);font-size:0.85rem;text-align:center;padding:20px">Nenhuma origem registrada</p>';
            return;
        }

        var max = data[0].total;
        var html = '';
        data.forEach(function(d) {
            var pct = max > 0 ? Math.max(3, (d.total / max) * 100) : 3;
            html += '<div class="hbar-row">' +
                '<span class="hbar-label" title="' + _esc(d.origem) + '">' + _esc(d.origem) + '</span>' +
                '<div class="hbar-track"><div class="hbar-fill" style="width:' + pct + '%"></div></div>' +
                '<span class="hbar-count">' + d.total + '</span>' +
            '</div>';
        });
        container.innerHTML = html;
    }

    function renderLeadsRecentes(leads) {
        var el = document.getElementById('leadsRecentes');
        if (!leads.length) {
            el.innerHTML = '<p style="color:var(--text-muted);font-size:0.85rem">Nenhum lead registrado.</p>';
            return;
        }
        var html = '';
        leads.forEach(function(l) {
            var statusColor = _statusColors[l.status] || 'var(--text-muted)';
            var statusLabel = _statusLabels[l.status] || l.status;
            html += '<div class="lead-row">' +
                '<div class="lead-row-top">' +
                    '<span class="lead-row-name">' + _esc(l.nome || l.email) + '</span>' +
                    '<span class="badge" style="background:' + statusColor + '20;color:' + statusColor + '">' + statusLabel + '</span>' +
                '</div>' +
                '<div class="lead-row-bottom">' +
                    '<span>' + _esc(l.email) + '</span>' +
                    (l.origem ? '<span>' + _esc(l.origem) + '</span>' : '') +
                    '<span>' + formatDate(l.created_at) + '</span>' +
                '</div>' +
            '</div>';
        });
        el.innerHTML = html;
    }

    function renderAtividade(atividades) {
        var el = document.getElementById('atividadeRecente');
        if (!atividades.length) {
            el.innerHTML = '<p style="color:var(--text-muted);font-size:0.85rem">Nenhuma atividade registrada.</p>';
            return;
        }
        var html = '';
        atividades.forEach(function(a) {
            html += '<div class="activity-item">' +
                '<span><strong>' + _esc(a.nome || 'Sistema') + '</strong> — ' + _esc(a.action) + '</span>' +
                '<span style="color:var(--text-muted);font-size:0.72rem">' + formatDate(a.created_at) + '</span>' +
            '</div>';
        });
        el.innerHTML = html;
    }

    function formatDate(dt) {
        if (!dt) return '';
        var d = new Date(dt);
        var dd = String(d.getDate()).padStart(2, '0');
        var mm = String(d.getMonth() + 1).padStart(2, '0');
        var hh = String(d.getHours()).padStart(2, '0');
        var mi = String(d.getMinutes()).padStart(2, '0');
        return dd + '/' + mm + ' ' + hh + ':' + mi;
    }

    // Icons
    function msgIcon() { return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>'; }
    function nlIcon() { return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>'; }
    function leadIcon() { return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'; }
    function convIcon() { return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>'; }

    // Pre-loaded data from PHP (single request)
    var _d = window._preloaded; window._preloaded = undefined;
    if (_d && _d.ok) { render(_d); } else { load(); }
})();
</script>
<?php spaFragmentEnd(); ?>
