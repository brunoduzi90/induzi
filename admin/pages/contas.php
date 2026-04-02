<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/fragment.php';
spaFragmentStart();
$session = requireAdmin();
session_write_close();
$db = getDB();
spaPreload(['ok' => true, 'users' => $db->query('SELECT id, nome, email, role, telefone, created_at, updated_at FROM users ORDER BY created_at DESC')->fetchAll()]);
?>
<div class="main-content">
<div class="container">
    <div class="page-header-compact">
        <h1>Contas</h1>
        <button class="btn btn-primary btn-sm" onclick="userNew()">+ Novo Usuario</button>
    </div>

    <div id="usersList"><p style="color:var(--text-muted)">Carregando...</p></div>
</div>
</div>

<script>
(function(){
    var _d = window._preloaded; window._preloaded = undefined;
    var users = (_d && _d.users) ? _d.users : [];
    var currentUserId = <?= $session['userId'] ?>;

    async function load() {
        var res = await IgrisDB.fetch('api/admin/list-users.php');
        var data = await res.json();
        users = data.ok ? data.users : [];
        render();
    }

    function render() {
        var el = document.getElementById('usersList');
        if (!users.length) {
            el.innerHTML = '<p style="color:var(--text-muted)">Nenhum usuario encontrado.</p>';
            return;
        }
        var html = '<table class="data-table"><thead><tr><th>Nome</th><th>Email</th><th>Role</th><th>Criado em</th><th>Acoes</th></tr></thead><tbody>';
        users.forEach(function(u) {
            var roleBadge = u.role === 'admin' ? '<span class="badge badge-info">Admin</span>' : '<span class="badge badge-success">Editor</span>';
            var actions = '<div class="action-btns"><button class="action-btn" onclick="userEdit(' + u.id + ')">Editar</button>';
            if (u.id != currentUserId) actions += '<button class="action-btn danger" onclick="userDelete(' + u.id + ')">Excluir</button>';
            actions += '</div>';
            html += '<tr><td><strong>' + _esc(u.nome) + '</strong></td><td style="font-size:0.85rem">' + _esc(u.email) + '</td><td>' + roleBadge + '</td><td style="font-size:0.8rem;color:var(--text-muted)">' + new Date(u.created_at).toLocaleDateString('pt-BR') + '</td><td>' + actions + '</td></tr>';
        });
        html += '</tbody></table>';
        el.innerHTML = html;
    }

    window.userNew = async function() {
        var overlay = document.createElement('div');
        overlay.className = 'igris-modal-overlay';
        var box = document.createElement('div');
        box.className = 'igris-modal';
        box.innerHTML = '<div class="igris-modal-title">Novo Usuario</div>' +
            '<div class="form-group"><label>Nome</label><input class="form-input" id="unNome"></div>' +
            '<div class="form-group"><label>Email</label><input class="form-input" type="email" id="unEmail"></div>' +
            '<div class="form-group"><label>Senha (min. 6)</label><input class="form-input" type="password" id="unSenha"></div>' +
            '<div class="form-group"><label>Role</label><select class="form-select" id="unRole"><option value="editor">Editor</option><option value="admin">Admin</option></select></div>' +
            '<div class="form-group"><label>Telefone</label><input class="form-input" id="unTel"></div>' +
            '<div class="igris-modal-actions"><button class="igris-btn igris-btn-secondary" data-action="cancel">Cancelar</button><button class="igris-btn igris-btn-primary" data-action="ok">Criar</button></div>';
        overlay.appendChild(box);
        overlay.addEventListener('click', function(e) { if (e.target === overlay) overlay.remove(); });
        box.querySelector('[data-action="cancel"]').addEventListener('click', function() { overlay.remove(); });
        box.querySelector('[data-action="ok"]').addEventListener('click', async function() {
            var res = await IgrisDB.fetch('api/admin/create-user.php', {
                method: 'POST', headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    nome: document.getElementById('unNome').value,
                    email: document.getElementById('unEmail').value,
                    senha: document.getElementById('unSenha').value,
                    role: document.getElementById('unRole').value,
                    telefone: document.getElementById('unTel').value,
                })
            });
            var data = await res.json();
            overlay.remove();
            if (data.ok) { Igris.toast('Usuario criado!', 'success'); load(); }
            else Igris.toast(data.msg, 'error');
        });
        document.body.appendChild(overlay);
    };

    window.userEdit = async function(id) {
        var user = users.find(function(u) { return u.id == id; });
        if (!user) return;

        var overlay = document.createElement('div');
        overlay.className = 'igris-modal-overlay';
        var box = document.createElement('div');
        box.className = 'igris-modal';
        box.innerHTML = '<div class="igris-modal-title">Editar Usuario</div>' +
            '<div class="form-group"><label>Nome</label><input class="form-input" id="ueNome" value="' + _esc(user.nome) + '"></div>' +
            '<div class="form-group"><label>Email</label><input class="form-input" type="email" id="ueEmail" value="' + _esc(user.email) + '"></div>' +
            '<div class="form-group"><label>Nova Senha (deixe vazio para manter)</label><input class="form-input" type="password" id="ueSenha"></div>' +
            '<div class="form-group"><label>Role</label><select class="form-select" id="ueRole"><option value="editor"' + (user.role !== 'admin' ? ' selected' : '') + '>Editor</option><option value="admin"' + (user.role === 'admin' ? ' selected' : '') + '>Admin</option></select></div>' +
            '<div class="form-group"><label>Telefone</label><input class="form-input" id="ueTel" value="' + _esc(user.telefone || '') + '"></div>' +
            '<div class="igris-modal-actions"><button class="igris-btn igris-btn-secondary" data-action="cancel">Cancelar</button><button class="igris-btn igris-btn-primary" data-action="ok">Salvar</button></div>';
        overlay.appendChild(box);
        overlay.addEventListener('click', function(e) { if (e.target === overlay) overlay.remove(); });
        box.querySelector('[data-action="cancel"]').addEventListener('click', function() { overlay.remove(); });
        box.querySelector('[data-action="ok"]').addEventListener('click', async function() {
            var payload = {
                id: id,
                nome: document.getElementById('ueNome').value,
                email: document.getElementById('ueEmail').value,
                role: document.getElementById('ueRole').value,
                telefone: document.getElementById('ueTel').value,
            };
            var senha = document.getElementById('ueSenha').value;
            if (senha) payload.senha = senha;
            var res = await IgrisDB.fetch('api/admin/update-user.php', {
                method: 'POST', headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(payload)
            });
            var data = await res.json();
            overlay.remove();
            if (data.ok) { Igris.toast('Usuario atualizado!', 'success'); load(); }
            else Igris.toast(data.msg, 'error');
        });
        document.body.appendChild(overlay);
    };

    window.userDelete = async function(id) {
        var ok = await Igris.confirm('Excluir Usuario', 'Tem certeza? Esta acao nao pode ser desfeita.', 'Excluir');
        if (!ok) return;
        var res = await IgrisDB.fetch('api/admin/delete-user.php', {
            method: 'POST', headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: id })
        });
        var data = await res.json();
        if (data.ok) { Igris.toast('Usuario excluido.', 'success'); load(); }
        else Igris.toast(data.msg, 'error');
    };

    if (_d && _d.ok) { render(); } else { load(); }
})();
</script>
<?php spaFragmentEnd(); ?>
