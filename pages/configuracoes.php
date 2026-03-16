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
<title>Configurações — Induzi</title>
<link rel="stylesheet" href="../css/style.css?v=<?= INDUZI_VERSION ?>">
<style>
.cfg-page { max-width: 860px; margin: 0 auto; padding: 20px 20px 40px; }
.cfg-page > h2 { font-size: 1.4rem; font-weight: 700; color: var(--color-gray-dark); margin-bottom: 28px; }
.cfg-layout { display: grid; grid-template-columns: 170px 1fr; gap: 40px; align-items: start; }
.cfg-nav { position: sticky; top: 20px; }
.cfg-nav a { display: block; padding: 9px 14px; border-radius: 6px; font-size: 0.88rem; color: var(--color-gray); text-decoration: none; transition: background 0.1s, color 0.1s; font-weight: 400; }
.cfg-nav a:hover { color: var(--color-gray-dark); background: var(--color-bg); }
.cfg-nav a.active { color: var(--color-gray-dark); background: var(--color-bg); font-weight: 500; }
.cfg-pane { display: none; }
.cfg-pane.active { display: block; }
.cfg-section { margin-bottom: 36px; }
.cfg-section:last-child { margin-bottom: 0; }
.cfg-title { font-size: 1.05rem; font-weight: 600; color: var(--color-gray-dark); margin-bottom: 6px; }
.cfg-subtitle { font-size: 0.78rem; color: var(--color-gray); margin-bottom: 14px; }
.cfg-divider { border: none; border-top: 1px solid var(--color-border); margin: 32px 0; }
.cfg-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
.cfg-form-group { margin-bottom: 16px; }
.cfg-form-group label { display: block; font-size: 0.78rem; font-weight: 500; color: var(--color-gray); margin-bottom: 5px; }
.cfg-input { width: 100%; padding: 9px 12px; border: 1px solid var(--color-border); border-radius: 6px; font-size: 0.9rem; font-family: inherit; background: var(--color-bg-card); color: var(--color-gray-dark); transition: border-color 0.15s; box-sizing: border-box; }
.cfg-input:focus { outline: none; border-color: var(--color-gray-dark); }
.cfg-input:read-only { background: var(--color-bg); color: var(--color-gray); }
.cfg-theme-options { display: flex; gap: 10px; margin-top: 6px; }
.cfg-theme-btn { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 14px 8px; border: 2px solid var(--color-border); border-radius: 10px; background: none; cursor: pointer; transition: border-color 0.15s, background 0.15s; color: var(--color-gray-dark); font-size: 0.8rem; font-weight: 500; font-family: inherit; }
.cfg-theme-btn:hover { background: var(--color-bg); }
.cfg-theme-btn.active { border-color: var(--color-gray-dark); background: var(--color-bg); }
.cfg-theme-btn svg { width: 24px; height: 24px; color: var(--color-gray); }
.cfg-theme-btn.active svg { color: var(--color-gray-dark); }
.cfg-pw-wrap { position: relative; }
.cfg-pw-wrap input { padding-right: 60px; }
.cfg-pw-toggle { position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 0.78rem; color: var(--color-gray); padding: 4px 8px; font-family: inherit; }
.cfg-pw-toggle:hover { color: var(--color-gray-dark); }
.cfg-save-bar { display: flex; align-items: center; gap: 12px; padding-top: 20px; border-top: 1px solid var(--color-border); margin-top: 24px; }
.cfg-save-msg { font-size: 0.82rem; }
.cfg-save-msg.success { color: var(--color-success); }
.cfg-save-msg.error { color: var(--color-danger); }
.cfg-perfil-row { display: flex; align-items: center; gap: 14px; margin-bottom: 18px; }
.cfg-avatar { width: 48px; height: 48px; border-radius: 50%; background: var(--color-gray-lighter); display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: 600; color: var(--color-gray-dark); flex-shrink: 0; }
.cfg-membro { font-size: 0.75rem; color: var(--color-gray-light); margin-top: 8px; }
@media (max-width: 700px) {
    .cfg-layout { grid-template-columns: 1fr; gap: 0; }
    .cfg-nav { position: static; display: flex; gap: 4px; margin-bottom: 24px; overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .cfg-nav a { white-space: nowrap; }
    .cfg-form-row { grid-template-columns: 1fr; }
    .cfg-perfil-row { flex-direction: column; align-items: flex-start; }
}
@media (max-width: 480px) {
    .cfg-page { padding: 16px 12px 32px; }
    .cfg-page > h2 { font-size: 1.2rem; margin-bottom: 20px; }
    .cfg-save-bar { flex-direction: column; align-items: stretch; gap: 8px; }
    .cfg-save-bar .btn { width: 100%; }
    .cfg-theme-options { flex-wrap: wrap; }
    .cfg-theme-btn { min-width: 80px; padding: 10px 6px; font-size: 0.75rem; }
    .cfg-input { font-size: 16px; }
}
</style>
</head>
<body>

<?php if (!isset($_GET['fragment'])): ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>
<?php endif; ?>
<div class="main-content">
    <div class="cfg-page">
        <h2>Configurações</h2>
        <div class="cfg-layout">
            <nav class="cfg-nav" id="cfgNav">
                <a href="#" data-tab="geral" class="active" onclick="cfgTab('geral');return false;">Geral</a>
                <a href="#" data-tab="conta" onclick="cfgTab('conta');return false;">Conta</a>
            </nav>
            <div class="cfg-content">

                <!-- TAB: GERAL -->
                <div class="cfg-pane active" id="paneGeral">
                    <!-- Perfil -->
                    <div class="cfg-section">
                        <div class="cfg-title">Perfil</div>
                        <div class="cfg-subtitle">Informações básicas exibidas no sistema</div>
                        <div class="cfg-perfil-row">
                            <div class="cfg-avatar" id="cfgAvatar"></div>
                            <div style="flex:1;">
                                <label style="font-size:0.78rem;font-weight:500;color:var(--color-gray);margin-bottom:5px;display:block;">Nome</label>
                                <input class="cfg-input" type="text" id="cfgNome" placeholder="Seu nome">
                            </div>
                        </div>
                        <div class="cfg-form-group">
                            <label>Email</label>
                            <input class="cfg-input" type="email" id="cfgEmail" readonly>
                        </div>
                        <div style="margin-top:12px;">
                            <button class="btn" onclick="salvarPerfil()">Salvar perfil</button>
                            <span class="cfg-save-msg" id="perfilMsg"></span>
                        </div>
                    </div>

                    <hr class="cfg-divider">

                    <!-- Aparência -->
                    <div class="cfg-section">
                        <div class="cfg-title">Aparência</div>
                        <div class="cfg-subtitle">Modo de cor</div>
                        <div class="cfg-theme-options" id="themeOptions">
                            <button class="cfg-theme-btn" data-theme="claro" onclick="setTheme('claro')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                                <span>Claro</span>
                            </button>
                            <button class="cfg-theme-btn" data-theme="escuro" onclick="setTheme('escuro')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                                <span>Escuro</span>
                            </button>
                            <button class="cfg-theme-btn" data-theme="auto" onclick="setTheme('auto')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                                <span>Automático</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- TAB: CONTA -->
                <div class="cfg-pane" id="paneConta">
                    <div class="cfg-section">
                        <div class="cfg-title">Alterar senha</div>
                        <div class="cfg-subtitle">Deixe em branco para manter a senha atual</div>
                        <div class="cfg-form-row">
                            <div class="cfg-form-group" style="margin:0;">
                                <label>Senha atual</label>
                                <div class="cfg-pw-wrap">
                                    <input class="cfg-input" type="password" id="cfgSenhaAtual" placeholder="Senha atual">
                                    <button type="button" class="cfg-pw-toggle" onclick="toggleSenha('cfgSenhaAtual',this)">Ver</button>
                                </div>
                            </div>
                            <div style="visibility:hidden;"></div>
                        </div>
                        <div class="cfg-form-row" style="margin-top:12px;">
                            <div class="cfg-form-group" style="margin:0;">
                                <label>Nova senha</label>
                                <div class="cfg-pw-wrap">
                                    <input class="cfg-input" type="password" id="cfgSenha" placeholder="Mínimo 8 caracteres" minlength="8">
                                    <button type="button" class="cfg-pw-toggle" onclick="toggleSenha('cfgSenha',this)">Ver</button>
                                </div>
                            </div>
                            <div class="cfg-form-group" style="margin:0;">
                                <label>Confirmar nova senha</label>
                                <div class="cfg-pw-wrap">
                                    <input class="cfg-input" type="password" id="cfgSenha2" placeholder="Repita a nova senha" minlength="8">
                                    <button type="button" class="cfg-pw-toggle" onclick="toggleSenha('cfgSenha2',this)">Ver</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cfg-save-bar">
                        <button class="btn" onclick="salvarConta()">Salvar alterações</button>
                        <span class="cfg-save-msg" id="contaMsg"></span>
                    </div>
                    <div class="cfg-membro" id="cfgMembro"></div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
(function() {
    // Tab switching
    function cfgTab(name) {
        document.querySelectorAll('.cfg-nav a').forEach(function(a) {
            a.classList.toggle('active', a.getAttribute('data-tab') === name);
        });
        document.querySelectorAll('.cfg-pane').forEach(function(p) { p.classList.remove('active'); });
        var pane = document.getElementById('pane' + name.charAt(0).toUpperCase() + name.slice(1));
        if (pane) pane.classList.add('active');
    }

    // Load user data
    var user = InduziAuth.getCurrentUser();
    if (!user) return;

    function carregarDados() {
        var u = InduziAuth.getCurrentUser();
        if (!u) return;
        document.getElementById('cfgNome').value = u.nome || '';
        document.getElementById('cfgEmail').value = u.email || '';
        // Avatar initials
        var avatar = document.getElementById('cfgAvatar');
        if (avatar) {
            avatar.textContent = u.nome ? u.nome.split(' ').map(function(p){return p[0]}).slice(0,2).join('').toUpperCase() : '?';
        }
        // Member since
        if (u.criadoEm) {
            var d = new Date(u.criadoEm);
            document.getElementById('cfgMembro').textContent = 'Membro desde ' + d.toLocaleDateString('pt-BR', { month: 'long', year: 'numeric' });
        }
        // Clear password fields
        document.getElementById('cfgSenhaAtual').value = '';
        document.getElementById('cfgSenha').value = '';
        document.getElementById('cfgSenha2').value = '';
    }
    carregarDados();

    // Theme
    var currentTheme = InduziAuth.getPreferencia('tema', 'auto');
    function updateThemeUI(tema) {
        document.querySelectorAll('#themeOptions .cfg-theme-btn').forEach(function(b) {
            b.classList.toggle('active', b.getAttribute('data-theme') === tema);
        });
    }
    updateThemeUI(currentTheme);

    function setTheme(tema) {
        InduziTheme.set(tema);
        updateThemeUI(tema);
        Igris.toast('Salvo', 'success', 1500);
    }

    // Save profile
    async function salvarPerfil() {
        var msgEl = document.getElementById('perfilMsg');
        var nome = document.getElementById('cfgNome').value.trim();
        if (!nome) { msgEl.className = 'cfg-save-msg error'; msgEl.textContent = 'Nome é obrigatório.'; return; }

        try {
            var resp = await fetch('api/auth/update-profile.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ nome: nome })
            });
            var data = await resp.json();
            if (data.ok) {
                InduziAuth._initialized = false;
                await InduziAuth.init();
                InduziAuth.populateSidebar();
                carregarDados();
                msgEl.className = 'cfg-save-msg success'; msgEl.textContent = 'Salvo!';
            } else {
                msgEl.className = 'cfg-save-msg error'; msgEl.textContent = data.msg || 'Erro';
            }
        } catch(e) {
            msgEl.className = 'cfg-save-msg error'; msgEl.textContent = 'Erro de conexão.';
        }
        setTimeout(function() { msgEl.textContent = ''; }, 3000);
    }

    // Save account (password)
    async function salvarConta() {
        var msgEl = document.getElementById('contaMsg');
        var senhaAtual = document.getElementById('cfgSenhaAtual').value;
        var senha = document.getElementById('cfgSenha').value;
        var senha2 = document.getElementById('cfgSenha2').value;

        if (!senha) { msgEl.className = 'cfg-save-msg error'; msgEl.textContent = 'Informe a nova senha.'; return; }
        if (!senhaAtual) { msgEl.className = 'cfg-save-msg error'; msgEl.textContent = 'Informe a senha atual.'; return; }
        if (senha.length < 8) { msgEl.className = 'cfg-save-msg error'; msgEl.textContent = 'Mínimo 8 caracteres.'; return; }
        if (senha !== senha2) { msgEl.className = 'cfg-save-msg error'; msgEl.textContent = 'As senhas não coincidem.'; return; }

        try {
            var resp = await fetch('api/auth/change-password.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ senha_atual: senhaAtual, nova_senha: senha })
            });
            var data = await resp.json();
            msgEl.className = 'cfg-save-msg ' + (data.ok ? 'success' : 'error');
            msgEl.textContent = data.ok ? 'Senha alterada!' : (data.msg || 'Erro');
            if (data.ok) carregarDados();
        } catch(e) {
            msgEl.className = 'cfg-save-msg error'; msgEl.textContent = 'Erro de conexão.';
        }
        setTimeout(function() { msgEl.textContent = ''; }, 3000);
    }

    function toggleSenha(id, btn) {
        var el = document.getElementById(id);
        if (el.type === 'password') { el.type = 'text'; btn.textContent = 'Ocultar'; }
        else { el.type = 'password'; btn.textContent = 'Ver'; }
    }

    // Exports
    window.cfgTab = cfgTab;
    window.setTheme = setTheme;
    window.salvarPerfil = salvarPerfil;
    window.salvarConta = salvarConta;
    window.toggleSenha = toggleSenha;

    window._spaCleanup = function() {};
})();
</script>

</body>
</html>
<?php spaFragmentEnd(); ?>
