<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/fragment.php';
spaFragmentStart();
requireAuth();
session_write_close();
$db = getDB();
spaPreload(['ok' => true, 'items' => $db->query('SELECT * FROM newsletter ORDER BY created_at DESC')->fetchAll()]);
?>
<div class="main-content">
<div class="container">
    <div class="page-header-compact">
        <h1>Newsletter</h1>
        <span class="page-header-stats" id="nlStats"></span>
    </div>

    <div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;align-items:center">
        <select id="nlFilterStatus" class="form-select" style="min-width:140px">
            <option value="">Todos os status</option>
            <option value="ativo">Ativo</option>
            <option value="inativo">Inativo</option>
        </select>
        <div style="margin-left:auto">
            <a href="api/newsletter/export.php" class="igris-btn igris-btn-secondary" target="_blank">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Exportar CSV
            </a>
        </div>
    </div>

    <div id="nlList"><p style="color:var(--text-muted)">Carregando...</p></div>
</div>
</div>

<script>
(function(){
    var _d = window._preloaded; window._preloaded = undefined;
    var items = (_d && _d.items) ? _d.items : [];

    async function load() {
        var status = document.getElementById('nlFilterStatus').value;
        var url = 'api/newsletter/list.php';
        if (status) url += '?status=' + status;
        var res = await IgrisDB.fetch(url);
        var data = await res.json();
        items = data.ok ? data.items : [];
        render();
    }

    function render() {
        var el = document.getElementById('nlList');
        var stats = document.getElementById('nlStats');
        var ativos = items.filter(function(i) { return i.status === 'ativo'; }).length;
        stats.textContent = items.length + ' inscritos, ' + ativos + ' ativos';

        if (!items.length) {
            el.innerHTML = '<div class="empty-state"><h3>Nenhum inscrito</h3><p>Quando alguem se inscrever na newsletter, aparecera aqui.</p></div>';
            return;
        }

        var html = '<table class="data-table"><thead><tr><th>Nome</th><th>Email</th><th>Origem</th><th>Status</th><th>Data</th><th>Acoes</th></tr></thead><tbody>';
        items.forEach(function(i) {
            var badge = i.status === 'ativo'
                ? '<span class="badge badge-success">Ativo</span>'
                : '<span class="badge badge-danger">Inativo</span>';
            html += '<tr>'
                + '<td>' + _esc(i.nome || '-') + '</td>'
                + '<td style="font-size:0.8rem">' + _esc(i.email) + '</td>'
                + '<td style="font-size:0.8rem;color:var(--text-muted)">' + _esc(i.origem || '-') + '</td>'
                + '<td>' + badge + '</td>'
                + '<td style="font-size:0.8rem;color:var(--text-muted)">' + new Date(i.created_at).toLocaleDateString('pt-BR') + '</td>'
                + '<td><div class="action-btns"><button class="action-btn danger" onclick="nlDelete(' + i.id + ')">Excluir</button></div></td>'
                + '</tr>';
        });
        html += '</tbody></table>';
        el.innerHTML = html;
    }

    document.getElementById('nlFilterStatus').addEventListener('change', load);

    window.nlDelete = async function(id) {
        var ok = await Igris.confirm('Remover Inscrito', 'Tem certeza que deseja remover este inscrito?', 'Remover');
        if (!ok) return;
        var res = await IgrisDB.fetch('api/newsletter/delete.php', {
            method: 'POST', headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: id })
        });
        var data = await res.json();
        if (data.ok) { Igris.toast('Inscrito removido.', 'success'); load(); }
        else Igris.toast(data.msg, 'error');
    };

    if (_d && _d.ok) { render(); } else { load(); }
</script>
<?php spaFragmentEnd(); ?>
