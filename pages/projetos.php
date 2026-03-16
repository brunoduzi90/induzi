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
<title>Projetos — Induzi</title>
<link rel="stylesheet" href="../css/style.css?v=<?= INDUZI_VERSION ?>">
<style>
.projects-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
.projects-header h2 { font-size: 1.3rem; font-weight: 700; color: var(--color-black); }
.projects-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
.project-card { background: var(--color-white); border: 1px solid var(--color-border); border-radius: 8px; padding: 24px; cursor: pointer; transition: all 0.2s; position: relative; }
.project-card:hover { border-color: var(--color-accent); box-shadow: 0 4px 12px rgba(124,58,237,0.1); transform: translateY(-2px); }
.project-card h3 { font-size: 1rem; font-weight: 600; color: var(--color-black); margin-bottom: 8px; }
.project-card p { font-size: 0.85rem; color: var(--color-gray); line-height: 1.5; }
.project-card .project-date { font-size: 0.75rem; color: var(--color-gray-light); margin-top: 12px; }
.project-card .project-actions { position: absolute; top: 12px; right: 12px; display: flex; gap: 6px; opacity: 0; transition: opacity 0.2s; }
.project-card:hover .project-actions { opacity: 1; }
.project-actions button { background: none; border: none; cursor: pointer; color: var(--color-gray); padding: 4px; border-radius: 4px; }
.project-actions button:hover { color: var(--color-black); background: var(--color-bg); }
.project-actions button.btn-del:hover { color: var(--color-danger); }
.new-project-card { border: 2px dashed var(--color-border); display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 8px; color: var(--color-gray); min-height: 140px; }
.new-project-card:hover { border-color: var(--color-accent); color: var(--color-accent); }
.new-project-card svg { width: 32px; height: 32px; }
.empty-state { text-align: center; padding: 60px 20px; color: var(--color-gray); }
.empty-state svg { width: 64px; height: 64px; color: var(--color-gray-lighter); margin-bottom: 16px; }
.empty-state p { font-size: 0.95rem; margin-bottom: 20px; }
</style>
</head>
<?php if (!isset($_GET['fragment'])): ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>
<?php endif; ?>
<div class="main-content">
    <div class="container">
        <div class="projects-header">
            <h2>Meus Projetos</h2>
        </div>
        <div class="projects-grid" id="projectsGrid"></div>
    </div>
</div>
<script>
(function() {
    async function loadProjects() {
        var projects = await InduziAuth.getProjects();
        var grid = document.getElementById('projectsGrid');
        var html = '';

        // New project card
        html += '<div class="project-card new-project-card" onclick="createProject()">';
        html += '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>';
        html += '<span>Novo Projeto</span>';
        html += '</div>';

        for (var i = 0; i < projects.length; i++) {
            var p = projects[i];
            var date = p.criado_em ? new Date(p.criado_em).toLocaleDateString('pt-BR') : '';
            var isOwner = p.permissao === 'dono';
            html += '<div class="project-card" onclick="selectProject(' + p.id + ')" data-id="' + p.id + '">';
            html += '<div class="project-actions">';
            if (isOwner) {
                html += '<button onclick="event.stopPropagation();shareProjectModal(' + p.id + ',\'' + escapeAttr(p.nome) + '\')" title="Compartilhar"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg></button>';
                html += '<button onclick="event.stopPropagation();duplicateProject(' + p.id + ')" title="Duplicar"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>';
                html += '<button onclick="event.stopPropagation();editProject(' + p.id + ',\'' + escapeAttr(p.nome) + '\',\'' + escapeAttr(p.descricao || '') + '\')" title="Editar"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></button>';
                html += '<button class="btn-del" onclick="event.stopPropagation();deleteProject(' + p.id + ',\'' + escapeAttr(p.nome) + '\')" title="Excluir"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>';
            }
            html += '</div>';
            html += '<h3>' + escapeHtml(p.nome) + '</h3>';
            if (p.descricao) html += '<p>' + escapeHtml(p.descricao) + '</p>';
            html += '<div class="project-date">';
            if (!isOwner) {
                var badgeLabel = p.permissao === 'editar' ? 'Editar' : 'Visualizar';
                html += '<span class="badge badge-info" style="margin-right:8px;">' + badgeLabel + '</span>';
                if (p.owner_name) html += '<span>Dono: ' + escapeHtml(p.owner_name) + '</span> · ';
            }
            html += 'Criado em ' + date + '</div>';
            html += '</div>';
        }

        grid.innerHTML = html;
    }

    function escapeHtml(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }
    function escapeAttr(s) { return (s||'').replace(/'/g, "\\'").replace(/"/g, '&quot;'); }

    window.createProject = async function() {
        var nome = await Igris.prompt('Nome do projeto:');
        if (!nome) return;
        var project = await InduziAuth.createProject(nome);
        if (project) {
            Igris.toast('Projeto criado!', 'success');
            await selectProject(project.id);
        }
    };

    window.selectProject = async function(id) {
        var result = await InduziAuth.selectProject(id);
        if (result.ok) {
            if (window.SpaRouter) SpaRouter.go('painel');
            else window.location.href = 'index.php';
        }
    };

    window.editProject = async function(id, nome, desc) {
        var novoNome = await Igris.prompt('Nome do projeto:', nome);
        if (!novoNome) return;
        var result = await InduziAuth.updateProject(id, novoNome, desc);
        if (result.ok) { Igris.toast('Projeto atualizado!', 'success'); loadProjects(); }
        else Igris.toast(result.msg || 'Erro', 'error');
    };

    window.deleteProject = async function(id, nome) {
        if (!await Igris.confirm('Excluir o projeto "' + nome + '"? Todos os dados serao perdidos.')) return;
        var result = await InduziAuth.deleteProject(id);
        if (result.ok) { Igris.toast('Projeto excluido!', 'success'); loadProjects(); }
        else Igris.toast(result.msg || 'Erro', 'error');
    };

    window.duplicateProject = async function(id) {
        var result = await InduziAuth.duplicateProject(id);
        if (result.ok) { Igris.toast(result.msg || 'Projeto duplicado!', 'success'); loadProjects(); }
        else Igris.toast(result.msg || 'Erro ao duplicar', 'error');
    };

    window.shareProjectModal = async function(projectId, nome) {
        var body = '<div class="igris-modal-header"><h3>Compartilhar "' + escapeHtml(nome) + '"</h3></div>';
        body += '<div class="form-group"><label>Email do usuario</label><input type="email" id="shareEmail" placeholder="email@exemplo.com"></div>';
        body += '<div class="form-group"><label>Permissao</label><select id="sharePermissao"><option value="editar">Editar</option><option value="visualizar">Visualizar</option></select></div>';
        body += '<div id="shareMsg" class="login-msg" style="min-height:0;"></div>';
        body += '<div id="sharedList" style="margin-top:16px;"></div>';
        var footer = '<button class="btn btn-secondary igris-modal-btn" id="shareCancel">Fechar</button><button class="btn btn-primary igris-modal-btn" id="shareOk">Compartilhar</button>';

        var overlay = document.getElementById('igrisModalOverlay');
        if (!overlay) { Igris.alert('Erro interno'); return; }
        document.getElementById('igrisModalBody').innerHTML = body;
        document.getElementById('igrisModalFooter').innerHTML = footer;
        overlay.classList.add('active');

        loadSharedUsers(projectId);

        document.getElementById('shareCancel').onclick = function() { overlay.classList.remove('active'); };
        document.getElementById('shareOk').onclick = async function() {
            var email = document.getElementById('shareEmail').value.trim();
            var perm = document.getElementById('sharePermissao').value;
            if (!email) return;
            var r = await InduziAuth.shareProject(projectId, email, perm);
            var msgEl = document.getElementById('shareMsg');
            if (r.ok) { msgEl.className = 'login-msg success'; msgEl.textContent = r.msg; document.getElementById('shareEmail').value = ''; loadSharedUsers(projectId); }
            else { msgEl.className = 'login-msg error'; msgEl.textContent = r.msg; }
        };
        document.getElementById('shareEmail').focus();
    };

    async function loadSharedUsers(projectId) {
        var result = await InduziAuth.getSharedUsers(projectId);
        var el = document.getElementById('sharedList');
        if (!el) return;
        if (!result.ok || !result.users.length) { el.innerHTML = '<p style="font-size:0.82rem;color:var(--color-gray);">Nenhum compartilhamento.</p>'; return; }
        var html = '<div style="font-size:0.82rem;font-weight:600;color:var(--color-gray);margin-bottom:8px;">Compartilhado com:</div>';
        for (var i = 0; i < result.users.length; i++) {
            var u = result.users[i];
            html += '<div style="display:flex;align-items:center;gap:8px;padding:6px 0;border-bottom:1px solid var(--color-border);font-size:0.85rem;">';
            html += '<span style="flex:1;">' + escapeHtml(u.nome) + ' <span style="color:var(--color-gray-light);">' + escapeHtml(u.email) + '</span></span>';
            html += '<span class="badge badge-info">' + u.permissao + '</span>';
            if (result.isOwner) {
                html += '<button class="btn-remove" title="Remover" data-email="' + escapeAttr(u.email) + '" onclick="removeShare(' + projectId + ', this.dataset.email)">x</button>';
            }
            html += '</div>';
        }
        el.innerHTML = html;
    }

    window.removeShare = async function(projectId, email) {
        var r = await InduziAuth.removeSharedUser(projectId, email);
        if (r.ok) { Igris.toast('Removido!', 'success'); loadSharedUsers(projectId); }
        else Igris.toast(r.msg || 'Erro', 'error');
    };

    loadProjects();
})();
</script>
<?php if (!isset($_GET['fragment'])): ?>
</div></body></html>
<?php endif; ?>
<?php spaFragmentEnd(); ?>
