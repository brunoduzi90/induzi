<?php
if (!file_exists(__DIR__ . '/config.php')) {
    header('Location: install.php');
    exit;
}
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/version.php';
$token = $_GET['token'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha — Induzi</title>
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
        .back-link { display: block; text-align: center; margin-top: 16px; font-size: 0.85rem; color: var(--color-gray); text-decoration: none; }
        .back-link:hover { color: var(--color-accent); }
        .no-token { text-align: center; padding: 20px 0; color: var(--color-gray); }
        .no-token p { margin-bottom: 16px; }
        @media (max-width: 480px) { .login-card { padding: 24px 18px; } }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <h1>Induzi</h1>
            <span>Redefinir Senha</span>
        </div>
        <div class="login-card">
<?php if (!$token): ?>
            <div class="no-token">
                <p>Link invalido. Solicite um novo link de recuperacao na pagina de login.</p>
                <a href="login.php" class="login-btn" style="display:inline-block; text-decoration:none; text-align:center;">Ir para Login</a>
            </div>
<?php else: ?>
            <h2>Nova Senha</h2>
            <form onsubmit="return doReset(event)">
                <div class="form-group">
                    <label for="novaSenha">Nova Senha</label>
                    <div class="password-wrapper">
                        <input type="password" id="novaSenha" required minlength="8" placeholder="Minimo 8 caracteres">
                        <button type="button" class="toggle-senha" onclick="toggleField('novaSenha')">Ver</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirmaSenha">Confirmar Senha</label>
                    <div class="password-wrapper">
                        <input type="password" id="confirmaSenha" required minlength="8" placeholder="Repita a senha">
                        <button type="button" class="toggle-senha" onclick="toggleField('confirmaSenha')">Ver</button>
                    </div>
                </div>
                <button type="submit" class="login-btn">Redefinir Senha</button>
                <div class="login-msg" id="msgReset"></div>
            </form>
<?php endif; ?>
            <a href="login.php" class="back-link">Voltar ao login</a>
        </div>
    </div>
    <script>
    function toggleField(id) {
        var input = document.getElementById(id);
        var btn = input.parentElement.querySelector('.toggle-senha');
        if (input.type === 'password') { input.type = 'text'; btn.textContent = 'Ocultar'; }
        else { input.type = 'password'; btn.textContent = 'Ver'; }
    }
    async function doReset(e) {
        e.preventDefault();
        var senha = document.getElementById('novaSenha').value;
        var confirma = document.getElementById('confirmaSenha').value;
        var msgEl = document.getElementById('msgReset');
        if (senha !== confirma) { msgEl.className = 'login-msg error'; msgEl.textContent = 'As senhas nao conferem.'; return false; }
        if (senha.length < 8) { msgEl.className = 'login-msg error'; msgEl.textContent = 'Senha deve ter no minimo 8 caracteres.'; return false; }
        try {
            var resp = await fetch('api/auth/reset-password.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ token: <?= json_encode($token) ?>, senha: senha })
            });
            var data = await resp.json();
            if (data.ok) {
                msgEl.className = 'login-msg success';
                msgEl.textContent = data.msg + ' Redirecionando...';
                setTimeout(function() { window.location.href = 'login.php'; }, 2000);
            } else {
                msgEl.className = 'login-msg error';
                msgEl.textContent = data.msg;
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
