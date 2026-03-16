<?php
if (!file_exists(__DIR__ . '/config.php')) {
    header('Location: install.php');
    exit;
}
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/version.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Induzi</title>
    <script>(function(){var t='auto';try{t=localStorage.getItem('induzi_tema')||'auto'}catch(e){}var d=t==='auto'?(window.matchMedia&&window.matchMedia('(prefers-color-scheme:dark)').matches?'escuro':'claro'):t;document.documentElement.setAttribute('data-theme',d)})()</script>
    <link rel="stylesheet" href="css/style.css?v=<?= INDUZI_VERSION ?>">
    <style>
        body { display: flex; align-items: center; justify-content: center; min-height: 100vh; background: var(--color-bg); }
        .login-container { width: 100%; max-width: 420px; padding: 20px; }
        .login-logo { text-align: center; margin-bottom: 32px; }
        .login-logo h1 { font-size: 1.4rem; font-weight: 700; color: var(--color-accent); letter-spacing: -0.3px; }
        .login-logo span { display: block; font-size: 0.7rem; font-weight: 400; color: var(--color-gray-light); text-transform: uppercase; letter-spacing: 1.5px; margin-top: 4px; }
        .login-card { background: var(--color-white); border: 1px solid var(--color-border); border-radius: 8px; padding: 36px 32px; }
        .login-card h2 { font-size: 1.1rem; font-weight: 600; color: var(--color-black); margin: 0 0 24px 0; text-align: center; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--color-gray); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .form-group input { width: 100%; padding: 11px 15px; border: 1px solid var(--color-border); border-radius: 6px; font-size: 0.95rem; font-family: inherit; background: var(--color-white); color: var(--color-black); transition: border-color 0.2s; box-sizing: border-box; }
        .form-group input:focus { outline: none; border-color: var(--color-accent); }
        .login-btn { width: 100%; padding: 13px; background: var(--color-accent); color: #fff; border: 2px solid var(--color-accent); border-radius: 6px; cursor: pointer; font-size: 0.95rem; font-weight: 500; font-family: inherit; transition: all 0.3s; margin-top: 6px; }
        .login-btn:hover { background: transparent; color: var(--color-accent); }
        .login-msg { text-align: center; font-size: 0.85rem; margin-top: 14px; min-height: 22px; }
        .login-msg.error { color: var(--color-danger); }
        .login-msg.success { color: var(--color-success); }
        .password-wrapper { position: relative; }
        .password-wrapper input { padding-right: 48px; }
        .toggle-senha { position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 0.8rem; color: var(--color-gray); padding: 4px 8px; font-family: inherit; }
        .toggle-senha:hover { color: var(--color-black); }
        .login-theme-toggle { position: fixed; bottom: 20px; right: 20px; background: var(--color-white); border: 1px solid var(--color-border); border-radius: 50%; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--color-gray); }
        .login-theme-toggle:hover { color: var(--color-black); border-color: var(--color-accent); }
        .forgot-link { display: block; text-align: right; font-size: 0.82rem; color: var(--color-gray); text-decoration: none; margin-top: -10px; margin-bottom: 12px; }
        .forgot-link:hover { color: var(--color-accent); }
        .forgot-panel { display: none; }
        .forgot-panel.active { display: block; }
        .forgot-back { display: block; text-align: center; font-size: 0.85rem; color: var(--color-gray); text-decoration: none; margin-top: 14px; cursor: pointer; background: none; border: none; font-family: inherit; }
        .forgot-back:hover { color: var(--color-accent); }
        .reset-link-box { background: var(--color-bg); border: 1px solid var(--color-border); border-radius: 6px; padding: 12px; margin-top: 12px; word-break: break-all; font-size: 0.82rem; }
        .reset-link-box a { color: var(--color-accent); }
        @media (max-width: 480px) { .login-card { padding: 24px 18px; } }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <h1>Induzi</h1>
            <span>Planejamento de Sites</span>
        </div>
        <div class="login-card">
            <div id="loginPanel">
                <h2>Entrar</h2>
                <form onsubmit="return doLogin(event)">
                    <div class="form-group">
                        <label for="loginUser">Email</label>
                        <input type="email" id="loginUser" required autocomplete="email" placeholder="seu@email.com">
                    </div>
                    <div class="form-group">
                        <label for="loginSenha">Senha</label>
                        <div class="password-wrapper">
                            <input type="password" id="loginSenha" required autocomplete="current-password" placeholder="Sua senha">
                            <button type="button" class="toggle-senha" onclick="toggleSenha()">Ver</button>
                        </div>
                    </div>
                    <a href="#" class="forgot-link" onclick="showForgot(); return false;">Esqueceu a senha?</a>
                    <button type="submit" class="login-btn">Entrar</button>
                    <div class="login-msg" id="msgLogin"></div>
                </form>
            </div>
            <div id="forgotPanel" class="forgot-panel">
                <h2>Recuperar Senha</h2>
                <form onsubmit="return doForgot(event)">
                    <div class="form-group">
                        <label for="forgotEmail">Email</label>
                        <input type="email" id="forgotEmail" required autocomplete="email" placeholder="seu@email.com">
                    </div>
                    <button type="submit" class="login-btn">Enviar</button>
                    <div class="login-msg" id="msgForgot"></div>
                    <div id="resetLinkBox" class="reset-link-box" style="display:none;"></div>
                </form>
                <button class="forgot-back" onclick="showLogin()">Voltar ao login</button>
            </div>
        </div>
    </div>
    <button class="login-theme-toggle" id="loginThemeToggle" onclick="InduziTheme.cycle()"></button>
    <script src="js/theme.js?v=<?= INDUZI_VERSION ?>"></script>
    <script src="js/db.js?v=<?= INDUZI_VERSION ?>"></script>
    <script src="js/auth.js?v=<?= INDUZI_VERSION ?>"></script>
    <script>
    (async function() {
        await InduziAuth.init();
        await InduziTheme.init();
        InduziTheme.updateToggle();
        if (InduziAuth.isLoggedIn()) { window.location.href = './'; return; }
    })();
    function toggleSenha() {
        var input = document.getElementById('loginSenha');
        var btn = input.parentElement.querySelector('.toggle-senha');
        if (input.type === 'password') { input.type = 'text'; btn.textContent = 'Ocultar'; }
        else { input.type = 'password'; btn.textContent = 'Ver'; }
    }
    async function doLogin(e) {
        e.preventDefault();
        var email = document.getElementById('loginUser').value;
        var senha = document.getElementById('loginSenha').value;
        var result = await InduziAuth.login(email, senha);
        var msgEl = document.getElementById('msgLogin');
        if (result.ok) { msgEl.className = 'login-msg success'; msgEl.textContent = 'Login realizado!'; window.location.href = './'; }
        else { msgEl.className = 'login-msg error'; msgEl.textContent = result.msg; }
        return false;
    }
    function showForgot() {
        document.getElementById('loginPanel').style.display = 'none';
        document.getElementById('forgotPanel').classList.add('active');
        document.getElementById('forgotEmail').focus();
    }
    function showLogin() {
        document.getElementById('forgotPanel').classList.remove('active');
        document.getElementById('loginPanel').style.display = '';
        document.getElementById('resetLinkBox').style.display = 'none';
        document.getElementById('msgForgot').className = 'login-msg';
        document.getElementById('msgForgot').textContent = '';
    }
    async function doForgot(e) {
        e.preventDefault();
        var email = document.getElementById('forgotEmail').value;
        var msgEl = document.getElementById('msgForgot');
        var linkBox = document.getElementById('resetLinkBox');
        try {
            var resp = await fetch('api/auth/forgot-password.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ email: email })
            });
            var data = await resp.json();
            if (data.ok) {
                msgEl.className = 'login-msg success';
                msgEl.textContent = data.msg;
                if (data.resetLink) {
                    linkBox.innerHTML = '<strong>Link de reset:</strong><br><a href="' + data.resetLink + '">' + data.resetLink + '</a>';
                    linkBox.style.display = 'block';
                }
            } else {
                msgEl.className = 'login-msg error';
                msgEl.textContent = data.msg;
                linkBox.style.display = 'none';
            }
        } catch (err) {
            msgEl.className = 'login-msg error';
            msgEl.textContent = 'Erro de conexao.';
        }
        return false;
    }
    </script>
</body>
</html>
