<?php
/**
 * Wizard de instalacao — INDUZI
 * 1. Conexao com banco
 * 2. Criacao das tabelas
 * 3. Conta administrador
 */
if (file_exists(__DIR__ . '/config.php')) {
    // Se ja tem config, verifica se tabelas existem
    require_once __DIR__ . '/config.php';
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $pdo->query('SELECT 1 FROM users LIMIT 1');
        // Tabelas existem, redireciona
        header('Location: admin/');
        exit;
    } catch (PDOException $e) {
        // Tabelas nao existem, continua install
    }
}

$step = isset($_POST['step']) ? (int)$_POST['step'] : 1;
$error = '';
$success = '';

// ── Passo 2: Testar conexao e criar tabelas ──
if ($step === 2) {
    $host    = trim($_POST['db_host'] ?? 'localhost');
    $name    = trim($_POST['db_name'] ?? '');
    $user    = trim($_POST['db_user'] ?? 'root');
    $pass    = $_POST['db_pass'] ?? '';
    $charset = 'utf8mb4';

    if (!$name) {
        $error = 'Nome do banco e obrigatorio.';
        $step = 1;
    } else {
        try {
            $dsn = "mysql:host=$host;charset=$charset";
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `$name`");

            // Dropar TODAS as tabelas existentes (limpar MVC antigo)
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
            $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
            foreach ($tables as $t) {
                $pdo->exec("DROP TABLE IF EXISTS `$t`");
            }
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

            // Tabelas core Igris
            $pdo->exec("CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(100) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                senha_hash VARCHAR(255) NOT NULL,
                role ENUM('admin','editor') NOT NULL DEFAULT 'editor',
                telefone VARCHAR(20) DEFAULT NULL,
                foto_perfil LONGTEXT DEFAULT NULL,
                preferencias JSON DEFAULT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

            $pdo->exec("CREATE TABLE login_attempts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                ip_address VARCHAR(45) NOT NULL,
                email VARCHAR(255) DEFAULT NULL,
                attempted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_ip (ip_address),
                INDEX idx_email (email)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

            $pdo->exec("CREATE TABLE password_resets (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                token VARCHAR(64) NOT NULL,
                expiry DATETIME NOT NULL,
                usado TINYINT(1) DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

            $pdo->exec("CREATE TABLE activity_log (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT DEFAULT NULL,
                action VARCHAR(100) NOT NULL,
                details JSON DEFAULT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_user (user_id),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

            // Tabelas INDUZI
            $pdo->exec("CREATE TABLE mensagens (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(150) NOT NULL,
                email VARCHAR(255) NOT NULL,
                telefone VARCHAR(30) DEFAULT NULL,
                assunto VARCHAR(300) DEFAULT NULL,
                mensagem TEXT NOT NULL,
                lida TINYINT(1) DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_lida (lida)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

            $pdo->exec("CREATE TABLE configuracoes (
                chave VARCHAR(100) PRIMARY KEY,
                valor LONGTEXT DEFAULT NULL,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

            $pdo->exec("CREATE TABLE newsletter (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(150) DEFAULT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                origem VARCHAR(100) DEFAULT 'site',
                status ENUM('ativo','inativo') DEFAULT 'ativo',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

            $pdo->exec("CREATE TABLE leads (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(150) DEFAULT NULL,
                email VARCHAR(255) NOT NULL,
                telefone VARCHAR(30) DEFAULT NULL,
                origem VARCHAR(200) DEFAULT NULL,
                dados JSON DEFAULT NULL,
                status ENUM('novo','contatado','convertido','descartado') DEFAULT 'novo',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_status (status),
                INDEX idx_origem (origem)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

            // Configuracoes padrão INDUZI
            $defaults = [
                ['site_titulo', 'INDUZI — Design Autoral & Arquitetura de Interiores'],
                ['site_descricao', 'Onde a materia bruta encontra a intencao criativa'],
                ['site_email', 'contato@induzi.com.br'],
                ['site_telefone', ''],
                ['site_instagram', ''],
                ['site_whatsapp', ''],
                ['seo_keywords', 'design autoral, arquitetura de interiores, mobiliario, estruturas metalicas, impressao 3d, concreto'],
                ['system_schema_version', '2.0.0'],
            ];
            $stmtConf = $pdo->prepare('INSERT IGNORE INTO configuracoes (chave, valor) VALUES (?, ?)');
            foreach ($defaults as $d) {
                $stmtConf->execute($d);
            }

            session_start();
            $_SESSION['install'] = [
                'host' => $host, 'name' => $name,
                'user' => $user, 'pass' => $pass,
            ];
            $success = 'Banco de dados configurado com sucesso!';

        } catch (PDOException $e) {
            $error = 'Erro de conexao: ' . $e->getMessage();
            $step = 1;
        }
    }
}

// ── Passo 3: Criar admin e config.php ──
if ($step === 3) {
    session_start();
    $install = $_SESSION['install'] ?? null;
    if (!$install) { $step = 1; $error = 'Sessao expirada. Recomece.'; }
    else {
        $adminNome  = trim($_POST['admin_nome'] ?? '');
        $adminEmail = trim($_POST['admin_email'] ?? '');
        $adminSenha = $_POST['admin_senha'] ?? '';

        if (!$adminNome || !$adminEmail || strlen($adminSenha) < 6) {
            $error = 'Preencha todos os campos. Senha minimo 6 caracteres.';
            $step = 2;
        } else {
            try {
                $dsn = "mysql:host={$install['host']};dbname={$install['name']};charset=utf8mb4";
                $pdo = new PDO($dsn, $install['user'], $install['pass'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]);

                $hash = password_hash($adminSenha, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare('INSERT INTO users (nome, email, senha_hash, role) VALUES (?, ?, ?, ?)');
                $stmt->execute([$adminNome, $adminEmail, $hash, 'admin']);

                // Gera config.php
                $configContent = "<?php\n";
                $configContent .= "define('DB_HOST', " . var_export($install['host'], true) . ");\n";
                $configContent .= "define('DB_NAME', " . var_export($install['name'], true) . ");\n";
                $configContent .= "define('DB_USER', " . var_export($install['user'], true) . ");\n";
                $configContent .= "define('DB_PASS', " . var_export($install['pass'], true) . ");\n";
                $configContent .= "define('DB_CHARSET', 'utf8mb4');\n";

                file_put_contents(__DIR__ . '/config.php', $configContent);

                unset($_SESSION['install']);
                header('Location: admin/login.php?installed=1');
                exit;

            } catch (PDOException $e) {
                $error = 'Erro: ' . $e->getMessage();
                $step = 2;
            }
        }
    }
}

$accentColor = '#B8E0C8';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Instalacao — INDUZI</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Space Grotesk',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;background:#0f0f1a;color:#e2e8f0;display:flex;justify-content:center;align-items:center;min-height:100vh;padding:20px}
.install-card{background:#1a1a2e;border:1px solid #2d2d44;border-radius:16px;padding:48px;max-width:480px;width:100%}
.install-card h1{font-size:1.5rem;margin-bottom:4px;color:#fff}
.install-card .sub{color:#94a3b8;margin-bottom:32px;font-size:0.9rem}
.steps{display:flex;gap:8px;margin-bottom:32px}
.steps .step{flex:1;height:4px;border-radius:2px;background:#2d2d44}
.steps .step.active{background:<?= $accentColor ?>}
.steps .step.done{background:#22c55e}
.form-group{margin-bottom:20px}
.form-group label{display:block;font-size:0.8rem;font-weight:600;color:#94a3b8;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px}
.form-group input[type="text"],.form-group input[type="email"]{width:100%;padding:12px 16px;background:#0f0f1a;border:1px solid #2d2d44;border-radius:8px;color:#e2e8f0;font-size:0.95rem;outline:none;transition:border-color .2s}
.form-group input:focus{border-color:<?= $accentColor ?>}
.pwd-wrapper{position:relative}
.pwd-wrapper input{width:100%;padding:12px 48px 12px 16px;background:#0f0f1a;border:1px solid #2d2d44;border-radius:8px;color:#e2e8f0;font-size:0.95rem;outline:none;transition:border-color .2s}
.pwd-wrapper input:focus{border-color:<?= $accentColor ?>}
.pwd-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:#64748b;cursor:pointer;padding:4px;display:flex;align-items:center;justify-content:center;transition:color .15s}
.pwd-toggle:hover{color:#e2e8f0}
.pwd-toggle svg{width:18px;height:18px}
.btn{width:100%;padding:14px;background:<?= $accentColor ?>;color:#0f0f1a;border:none;border-radius:8px;font-size:1rem;font-weight:600;cursor:pointer;transition:background .2s}
.btn:hover{background:#9fd4b0}
.error{background:#ef444420;color:#f87171;border:1px solid #ef444440;padding:12px;border-radius:8px;margin-bottom:20px;font-size:0.85rem}
.success{background:#22c55e20;color:#4ade80;border:1px solid #22c55e40;padding:12px;border-radius:8px;margin-bottom:20px;font-size:0.85rem}
</style>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="install-card">
    <h1>INDUZI</h1>
    <p class="sub">Instalacao do sistema</p>

    <div class="steps">
        <div class="step <?= $step >= 2 ? 'done' : ($step === 1 ? 'active' : '') ?>"></div>
        <div class="step <?= $step >= 3 ? 'done' : ($step === 2 ? 'active' : '') ?>"></div>
        <div class="step <?= $step === 3 ? 'active' : '' ?>"></div>
    </div>

    <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

    <?php if ($step === 1): ?>
    <form method="post">
        <input type="hidden" name="step" value="2">
        <div class="form-group">
            <label>Host</label>
            <input type="text" name="db_host" value="localhost" required>
        </div>
        <div class="form-group">
            <label>Nome do Banco</label>
            <input type="text" name="db_name" value="site_db" required>
        </div>
        <div class="form-group">
            <label>Usuario</label>
            <input type="text" name="db_user" value="root">
        </div>
        <div class="form-group">
            <label>Senha</label>
            <div class="pwd-wrapper">
                <input type="password" name="db_pass" placeholder="Deixe vazio se nao tiver">
                <button type="button" class="pwd-toggle" onclick="togglePwd(this)" aria-label="Mostrar senha">
                    <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                </button>
            </div>
        </div>
        <button type="submit" class="btn">Conectar e Criar Tabelas</button>
    </form>

    <?php elseif ($step === 2): ?>
    <form method="post">
        <input type="hidden" name="step" value="3">
        <div class="form-group">
            <label>Nome do Administrador</label>
            <input type="text" name="admin_nome" placeholder="Seu nome" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="admin_email" placeholder="admin@induzi.com.br" required>
        </div>
        <div class="form-group">
            <label>Senha (min. 6 caracteres)</label>
            <div class="pwd-wrapper">
                <input type="password" name="admin_senha" minlength="6" required>
                <button type="button" class="pwd-toggle" onclick="togglePwd(this)" aria-label="Mostrar senha">
                    <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                </button>
            </div>
        </div>
        <button type="submit" class="btn">Criar Admin e Finalizar</button>
    </form>
    <?php endif; ?>
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
