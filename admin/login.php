<?php
/**
 * Tela de login — INDUZI Admin
 */
if (!file_exists(__DIR__ . '/../config.php')) { header('Location: ../install.php'); exit; }

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../version.php';
require_once __DIR__ . '/../includes/db.php';

session_start();
if (!empty($_SESSION['induzi_user']['userId'])) {
    header('Location: app.php');
    exit;
}

$error = '';
$installed = isset($_GET['installed']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $lembrar = !empty($_POST['lembrar']);

    if ($email && $senha) {
        $db = getDB();

        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        require_once __DIR__ . '/../includes/helpers.php';

        if (!checkRateLimit($db, $ip, $email)) {
            $error = 'Muitas tentativas. Aguarde 15 minutos.';
        } else {
            $stmt = $db->prepare('SELECT id, nome, email, senha_hash, role, preferencias FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($senha, $user['senha_hash'])) {
                session_regenerate_id(true);

                if ($lembrar) {
                    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
                    setcookie(session_name(), session_id(), [
                        'expires'  => time() + 2592000,
                        'path'     => '/',
                        'httponly'  => true,
                        'samesite' => 'Lax',
                        'secure'   => $isSecure,
                    ]);
                    $_SESSION['remember_me'] = true;
                }

                $_SESSION['induzi_user'] = [
                    'userId'       => (int)$user['id'],
                    'nome'         => $user['nome'],
                    'email'        => $user['email'],
                    'role'         => $user['role'],
                    'preferencias' => json_decode($user['preferencias'] ?? '{}', true) ?: [],
                ];
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                $_SESSION['last_activity'] = time();

                header('Location: app.php');
                exit;
            } else {
                logLoginAttempt($db, $ip, $email);
                $error = 'Email ou senha incorretos.';
            }
        }
    } else {
        $error = 'Preencha todos os campos.';
    }
}

$accentColor = '#B8E0C8';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — INDUZI Admin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Space Grotesk',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;background:#0f0f1a;color:#e2e8f0;display:flex;justify-content:center;align-items:center;min-height:100vh;padding:20px}
.login-card{background:#1a1a2e;border:1px solid #2d2d44;border-radius:16px;padding:48px;max-width:400px;width:100%}
.login-card h1{font-size:1.5rem;margin-bottom:4px;color:#fff}
.login-card .sub{color:#94a3b8;margin-bottom:32px;font-size:0.9rem}
.form-group{margin-bottom:20px}
.form-group label{display:block;font-size:0.8rem;font-weight:600;color:#94a3b8;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px}
.form-group input[type="email"],.form-group input[type="text"]{width:100%;padding:12px 16px;background:#0f0f1a;border:1px solid #2d2d44;border-radius:8px;color:#e2e8f0;font-size:0.95rem;outline:none;transition:border-color .2s}
.form-group input:focus{border-color:<?= $accentColor ?>}
.pwd-wrapper{position:relative}
.pwd-wrapper input{width:100%;padding:12px 48px 12px 16px;background:#0f0f1a;border:1px solid #2d2d44;border-radius:8px;color:#e2e8f0;font-size:0.95rem;outline:none;transition:border-color .2s}
.pwd-wrapper input:focus{border-color:<?= $accentColor ?>}
.pwd-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:#64748b;cursor:pointer;padding:4px;display:flex;align-items:center;justify-content:center;transition:color .15s}
.pwd-toggle:hover{color:#e2e8f0}
.pwd-toggle svg{width:18px;height:18px}
.login-options{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px}
.remember-me{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:0.82rem;color:#94a3b8}
.remember-me input{accent-color:<?= $accentColor ?>;width:15px;height:15px;cursor:pointer}
.btn{width:100%;padding:14px;background:<?= $accentColor ?>;color:#0f0f1a;border:none;border-radius:8px;font-size:1rem;font-weight:600;cursor:pointer;transition:background .2s}
.btn:hover{background:#9fd4b0}
.error{background:#ef444420;color:#f87171;border:1px solid #ef444440;padding:12px;border-radius:8px;margin-bottom:20px;font-size:0.85rem}
.success{background:#22c55e20;color:#4ade80;border:1px solid #22c55e40;padding:12px;border-radius:8px;margin-bottom:20px;font-size:0.85rem}
.back-link{display:block;text-align:center;margin-top:20px;color:#64748b;font-size:0.82rem;text-decoration:none}
.back-link:hover{color:<?= $accentColor ?>}
</style>
</head>
<body>
<div class="login-card">
    <h1>INDUZI</h1>
    <p class="sub">Painel Administrativo</p>

    <?php if ($installed): ?>
    <div class="success">Instalacao concluida! Faca login com a conta admin.</div>
    <?php endif; ?>

    <?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autofocus required>
        </div>
        <div class="form-group">
            <label>Senha</label>
            <div class="pwd-wrapper">
                <input type="password" name="senha" required>
                <button type="button" class="pwd-toggle" onclick="togglePwd(this)" aria-label="Mostrar senha">
                    <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                </button>
            </div>
        </div>
        <div class="login-options">
            <label class="remember-me">
                <input type="checkbox" name="lembrar" value="1">
                Manter conectado
            </label>
        </div>
        <button type="submit" class="btn">Entrar</button>
    </form>
    <a href="../" class="back-link">Voltar ao site</a>
</div>
<script>
function togglePwd(btn) {
    var wrapper = btn.closest('.pwd-wrapper');
    var input = wrapper.querySelector('input');
    var open = btn.querySelector('.eye-open');
    var closed = btn.querySelector('.eye-closed');
    if (input.type === 'password') {
        input.type = 'text';
        open.style.display = 'none';
        closed.style.display = '';
    } else {
        input.type = 'password';
        open.style.display = '';
        closed.style.display = 'none';
    }
}
</script>
</body>
</html>
