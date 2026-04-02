<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/fragment.php';
spaFragmentStart();
requireAuth();
session_write_close();
$db = getDB();
spaPreload(['ok' => true, 'mensagens' => $db->query('SELECT * FROM mensagens ORDER BY created_at DESC')->fetchAll()]);
?>
<div class="main-content">
<div class="container">
    <div class="page-header-compact">
        <h1>Mensagens</h1>
        <span class="page-header-stats" id="msgStats"></span>
    </div>

    <div id="msgList"><p style="color:var(--text-muted)">Carregando...</p></div>
</div>
</div>

<script>
(function(){
    var _d = window._preloaded; window._preloaded = undefined;
    var mensagens = (_d && _d.mensagens) ? _d.mensagens : [];

    async function load() {
        var res = await IgrisDB.fetch('api/mensagens/list.php');
        var data = await res.json();
        mensagens = data.ok ? data.mensagens : [];
        render();
    }

    function render() {
        var el = document.getElementById('msgList');
        var stats = document.getElementById('msgStats');
        var naoLidas = mensagens.filter(function(m) { return !parseInt(m.lida); }).length;
        stats.textContent = mensagens.length + ' total, ' + naoLidas + ' nao lidas';

        if (!mensagens.length) {
            el.innerHTML = '<div class="empty-state"><h3>Nenhuma mensagem</h3><p>Quando alguem enviar uma mensagem pelo formulario de contato, ela aparecera aqui.</p></div>';
            return;
        }

        var html = '<table class="data-table"><thead><tr><th></th><th>Nome</th><th>Email</th><th>Assunto</th><th>Data</th><th>Acoes</th></tr></thead><tbody>';
        mensagens.forEach(function(m) {
            var dot = !parseInt(m.lida) ? '<span class="unread-dot"></span>' : '';
            var bold = !parseInt(m.lida) ? 'font-weight:600' : '';
            html += '<tr><td>' + dot + '</td><td style="' + bold + '">' + _esc(m.nome) + '</td><td style="font-size:0.8rem">' + _esc(m.email) + '</td><td>' + _esc(m.assunto || '-') + '</td><td style="font-size:0.8rem;color:var(--text-muted)">' + new Date(m.created_at).toLocaleDateString('pt-BR') + '</td><td><div class="action-btns"><button class="action-btn" onclick="msgView(' + m.id + ')">Ver</button><button class="action-btn danger" onclick="msgDelete(' + m.id + ')">Excluir</button></div></td></tr>';
        });
        html += '</tbody></table>';
        el.innerHTML = html;
    }

    window.msgView = async function(id) {
        var res = await IgrisDB.fetch('api/mensagens/read.php', {
            method: 'POST', headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: id })
        });
        var data = await res.json();
        if (!data.ok) return;
        var m = data.mensagem;

        var overlay = document.createElement('div');
        overlay.className = 'igris-modal-overlay';
        var box = document.createElement('div');
        box.className = 'igris-modal';
        box.style.maxWidth = '550px';
        box.innerHTML = '<div class="igris-modal-title">' + _esc(m.assunto || 'Mensagem') + '</div>' +
            '<div style="margin-bottom:16px;font-size:0.85rem">' +
            '<p><strong>De:</strong> ' + _esc(m.nome) + ' &lt;' + _esc(m.email) + '&gt;</p>' +
            (m.telefone ? '<p><strong>Tel:</strong> ' + _esc(m.telefone) + '</p>' : '') +
            '<p style="color:var(--text-muted);font-size:0.8rem">' + new Date(m.created_at).toLocaleString('pt-BR') + '</p>' +
            '</div>' +
            '<div style="background:var(--bg-primary);border:1px solid var(--border);border-radius:var(--radius-md);padding:16px;margin-bottom:20px;font-size:0.9rem;line-height:1.6;white-space:pre-wrap">' + _esc(m.mensagem) + '</div>' +
            '<div class="igris-modal-actions"><button class="igris-btn igris-btn-primary" data-action="ok">Fechar</button></div>';

        overlay.appendChild(box);
        overlay.addEventListener('click', function(e) { if (e.target === overlay) overlay.remove(); });
        box.querySelector('[data-action="ok"]').addEventListener('click', function() { overlay.remove(); });
        document.body.appendChild(overlay);

        // Marca como lida no local
        var local = mensagens.find(function(x) { return x.id == id; });
        if (local) local.lida = 1;
        render();
    };

    window.msgDelete = async function(id) {
        var ok = await Igris.confirm('Excluir Mensagem', 'Tem certeza?', 'Excluir');
        if (!ok) return;
        var res = await IgrisDB.fetch('api/mensagens/delete.php', {
            method: 'POST', headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: id })
        });
        var data = await res.json();
        if (data.ok) { Igris.toast('Mensagem excluida.', 'success'); load(); }
        else Igris.toast(data.msg, 'error');
    };

    if (_d && _d.ok) { render(); } else { load(); }
})();
</script>
<?php spaFragmentEnd(); ?>
