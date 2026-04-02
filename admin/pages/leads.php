<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/fragment.php';
spaFragmentStart();
requireAuth();
session_write_close();
$db = getDB();
$_items = $db->query('SELECT * FROM leads ORDER BY created_at DESC')->fetchAll();
$_origens = $db->query("SELECT DISTINCT origem FROM leads WHERE origem IS NOT NULL ORDER BY origem")->fetchAll(PDO::FETCH_COLUMN);
spaPreload(['ok' => true, 'items' => $_items, 'origens' => $_origens]);
?>
<style>
.badge-novo { background:#3b82f620; color:#60a5fa; border:1px solid #3b82f640; }
.badge-contatado { background:#f59e0b20; color:#fbbf24; border:1px solid #f59e0b40; }
.badge-convertido { background:#22c55e20; color:#4ade80; border:1px solid #22c55e40; }
.badge-descartado { background:#64748b20; color:#94a3b8; border:1px solid #64748b40; }
.status-select { background:var(--bg-primary); border:1px solid var(--border); border-radius:6px; color:var(--text-primary); padding:4px 8px; font-size:0.8rem; cursor:pointer; }
</style>
<div class="main-content">
<div class="container">
    <div class="page-header-compact">
        <h1>Leads</h1>
        <span class="page-header-stats" id="leadsStats"></span>
    </div>

    <div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;align-items:center">
        <select id="leadsFilterStatus" class="form-select" style="min-width:150px">
            <option value="">Todos os status</option>
            <option value="novo">Novo</option>
            <option value="contatado">Contatado</option>
            <option value="convertido">Convertido</option>
            <option value="descartado">Descartado</option>
        </select>
        <select id="leadsFilterOrigem" class="form-select" style="min-width:150px">
            <option value="">Todas as origens</option>
        </select>
        <div style="margin-left:auto">
            <a href="api/leads/export.php" class="igris-btn igris-btn-secondary" target="_blank">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Exportar CSV
            </a>
        </div>
    </div>

    <div id="leadsList"><p style="color:var(--text-muted)">Carregando...</p></div>
</div>
</div>

<script>
(function(){
    var _d = window._preloaded; window._preloaded = undefined;
    var items = (_d && _d.items) ? _d.items : [];
    var origens = (_d && _d.origens) ? _d.origens : [];

    async function load() {
        var status = document.getElementById('leadsFilterStatus').value;
        var origem = document.getElementById('leadsFilterOrigem').value;
        var url = 'api/leads/list.php?';
        if (status) url += 'status=' + encodeURIComponent(status) + '&';
        if (origem) url += 'origem=' + encodeURIComponent(origem);
        var res = await IgrisDB.fetch(url);
        var data = await res.json();
        items = data.ok ? data.items : [];
        if (data.origens) {
            origens = data.origens;
            updateOrigensFilter();
        }
        render();
    }

    function updateOrigensFilter() {
        var sel = document.getElementById('leadsFilterOrigem');
        var current = sel.value;
        sel.innerHTML = '<option value="">Todas as origens</option>';
        origens.forEach(function(o) {
            if (!o) return;
            var opt = document.createElement('option');
            opt.value = o; opt.textContent = o;
            if (o === current) opt.selected = true;
            sel.appendChild(opt);
        });
    }

    function render() {
        var el = document.getElementById('leadsList');
        var stats = document.getElementById('leadsStats');
        var novos = items.filter(function(i) { return i.status === 'novo'; }).length;
        stats.textContent = items.length + ' leads, ' + novos + ' novos';

        if (!items.length) {
            el.innerHTML = '<div class="empty-state"><h3>Nenhum lead</h3><p>Leads capturados de landing pages apareceraro aqui.</p></div>';
            return;
        }

        var html = '<table class="data-table"><thead><tr><th>Nome</th><th>Email</th><th>Telefone</th><th>Origem</th><th>Status</th><th>Data</th><th>Acoes</th></tr></thead><tbody>';
        items.forEach(function(i) {
            var badgeClass = 'badge-' + i.status;
            var statusLabel = i.status.charAt(0).toUpperCase() + i.status.slice(1);
            html += '<tr>'
                + '<td>' + _esc(i.nome || '-') + '</td>'
                + '<td style="font-size:0.8rem">' + _esc(i.email) + '</td>'
                + '<td style="font-size:0.8rem">' + _esc(i.telefone || '-') + '</td>'
                + '<td style="font-size:0.8rem;color:var(--text-muted)">' + _esc(i.origem || '-') + '</td>'
                + '<td><select class="status-select" onchange="leadStatus(' + i.id + ', this.value)">'
                + '<option value="novo"' + (i.status==='novo'?' selected':'') + '>Novo</option>'
                + '<option value="contatado"' + (i.status==='contatado'?' selected':'') + '>Contatado</option>'
                + '<option value="convertido"' + (i.status==='convertido'?' selected':'') + '>Convertido</option>'
                + '<option value="descartado"' + (i.status==='descartado'?' selected':'') + '>Descartado</option>'
                + '</select></td>'
                + '<td style="font-size:0.8rem;color:var(--text-muted)">' + new Date(i.created_at).toLocaleDateString('pt-BR') + '</td>'
                + '<td><div class="action-btns"><button class="action-btn danger" onclick="leadDelete(' + i.id + ')">Excluir</button></div></td>'
                + '</tr>';
        });
        html += '</tbody></table>';
        el.innerHTML = html;
    }

    // Initial render from preloaded or fetch
    if (_d && _d.ok) { updateOrigensFilter(); render(); } else { load(); }

    document.getElementById('leadsFilterStatus').addEventListener('change', load);
    document.getElementById('leadsFilterOrigem').addEventListener('change', load);

    window.leadStatus = async function(id, status) {
        var res = await IgrisDB.fetch('api/leads/update.php', {
            method: 'POST', headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: id, status: status })
        });
        var data = await res.json();
        if (data.ok) {
            Igris.toast('Status atualizado.', 'success');
            var item = items.find(function(i) { return i.id == id; });
            if (item) item.status = status;
            var stats = document.getElementById('leadsStats');
            var novos = items.filter(function(i) { return i.status === 'novo'; }).length;
            stats.textContent = items.length + ' leads, ' + novos + ' novos';
        } else {
            Igris.toast(data.msg, 'error');
        }
    };

    window.leadDelete = async function(id) {
        var ok = await Igris.confirm('Remover Lead', 'Tem certeza que deseja remover este lead?', 'Remover');
        if (!ok) return;
        var res = await IgrisDB.fetch('api/leads/delete.php', {
            method: 'POST', headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: id })
        });
        var data = await res.json();
        if (data.ok) { Igris.toast('Lead removido.', 'success'); load(); }
        else Igris.toast(data.msg, 'error');
    };

})();
</script>
<?php spaFragmentEnd(); ?>
