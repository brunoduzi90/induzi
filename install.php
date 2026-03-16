<?php
/**
 * Induzi — Instalador Web
 * Wizard de instalacao em 3 passos: Requisitos -> Banco + Admin -> Concluido.
 */

$configFile = __DIR__ . '/config.php';
if (file_exists($configFile)) {
    require_once $configFile;
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $count = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
        if ($count > 0) {
            header('Location: login.php');
            exit;
        }
    } catch (Exception $e) {}
}

// AJAX: Verificar requisitos
if (isset($_GET['action']) && $_GET['action'] === 'check_requirements') {
    header('Content-Type: application/json; charset=utf-8');
    $checks = [];
    $phpOk = version_compare(PHP_VERSION, '7.4.0', '>=');
    $checks[] = ['label' => 'PHP >= 7.4', 'value' => PHP_VERSION, 'ok' => $phpOk];
    $pdoOk = extension_loaded('pdo_mysql');
    $checks[] = ['label' => 'PDO MySQL', 'value' => $pdoOk ? 'Disponivel' : 'Nao encontrado', 'ok' => $pdoOk];
    $mbOk = extension_loaded('mbstring');
    $checks[] = ['label' => 'mbstring', 'value' => $mbOk ? 'Disponivel' : 'Nao encontrado', 'ok' => $mbOk];
    $jsonOk = extension_loaded('json');
    $checks[] = ['label' => 'JSON', 'value' => $jsonOk ? 'Disponivel' : 'Nao encontrado', 'ok' => $jsonOk];
    $sessDir = session_save_path() ?: sys_get_temp_dir();
    $sessOk = is_writable($sessDir);
    $checks[] = ['label' => 'Sessoes (escrita)', 'value' => $sessOk ? 'OK' : 'Sem permissao', 'ok' => $sessOk];
    $bcryptOk = defined('PASSWORD_BCRYPT');
    $checks[] = ['label' => 'password_hash (bcrypt)', 'value' => $bcryptOk ? 'Disponivel' : 'Nao disponivel', 'ok' => $bcryptOk];
    $dirOk = is_writable(__DIR__);
    $checks[] = ['label' => 'Diretorio gravavel', 'value' => $dirOk ? basename(__DIR__) . '/' : 'Sem permissao', 'ok' => $dirOk];
    $configExists = file_exists($configFile);
    $checks[] = ['label' => 'config.php', 'value' => $configExists ? 'Ja existe (sera mantido)' : 'Sera criado automaticamente', 'ok' => true];
    $allOk = $phpOk && $pdoOk && $mbOk && $jsonOk && $sessOk && $bcryptOk && $dirOk;
    echo json_encode(['ok' => true, 'checks' => $checks, 'allOk' => $allOk]);
    exit;
}

// AJAX: Testar conexao ao banco
if (isset($_GET['action']) && $_GET['action'] === 'test_db') {
    header('Content-Type: application/json; charset=utf-8');
    $input = json_decode(file_get_contents('php://input'), true);
    $host   = trim($input['host'] ?? '');
    $dbname = trim($input['dbname'] ?? '');
    $user   = trim($input['user'] ?? '');
    $pass   = $input['pass'] ?? '';
    if (!$host || !$dbname || !$user) {
        echo json_encode(['ok' => false, 'msg' => 'Preencha todos os campos obrigatorios.']);
        exit;
    }
    try {
        $dsn = "mysql:host=$host;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 5]);
        $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
        $stmt->execute([$dbname]);
        $dbExists = $stmt->fetch() !== false;
        $mysqlVersion = $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
        echo json_encode([
            'ok' => true,
            'msg' => $dbExists
                ? "Conexao OK! Banco \"$dbname\" encontrado. MySQL $mysqlVersion"
                : "Conexao OK! O banco \"$dbname\" sera criado automaticamente. MySQL $mysqlVersion",
            'dbExists' => $dbExists,
        ]);
    } catch (PDOException $e) {
        $msg = 'Erro de conexao.';
        if (strpos($e->getMessage(), 'Access denied') !== false) $msg = 'Acesso negado. Verifique usuario e senha.';
        elseif (strpos($e->getMessage(), 'Connection refused') !== false) $msg = 'Servidor nao encontrado. Verifique o host.';
        echo json_encode(['ok' => false, 'msg' => $msg]);
    }
    exit;
}

// AJAX: Instalar
if (isset($_GET['action']) && $_GET['action'] === 'install') {
    header('Content-Type: application/json; charset=utf-8');
    $input = json_decode(file_get_contents('php://input'), true);
    $host   = trim($input['db_host'] ?? '');
    $dbname = trim($input['db_name'] ?? '');
    $dbuser = trim($input['db_user'] ?? '');
    $dbpass = $input['db_pass'] ?? '';
    $nome   = trim($input['admin_nome'] ?? '');
    $email  = trim(strtolower($input['admin_email'] ?? ''));
    $senha  = $input['admin_senha'] ?? '';

    if (!$host || !$dbname || !$dbuser) {
        echo json_encode(['ok' => false, 'msg' => 'Dados do banco incompletos.']);
        exit;
    }
    if (!$nome || !$email || !$senha) {
        echo json_encode(['ok' => false, 'msg' => 'Preencha nome, email e senha do administrador.']);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['ok' => false, 'msg' => 'Email invalido.']);
        exit;
    }
    if (strlen($senha) < 8) {
        echo json_encode(['ok' => false, 'msg' => 'Senha deve ter no minimo 8 caracteres.']);
        exit;
    }

    try {
        $dsn = "mysql:host=$host;charset=utf8mb4";
        $pdo = new PDO($dsn, $dbuser, $dbpass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $dbEscaped = str_replace('`', '``', $dbname);
        $dbConnected = false;
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $dbConnected = true;
        } catch (PDOException $e) {}

        if (!$dbConnected) {
            try {
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbEscaped` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                $pdo->exec("USE `$dbEscaped`");
            } catch (PDOException $e) {
                echo json_encode(['ok' => false, 'msg' => 'Nao foi possivel criar o banco "' . $dbname . '". Crie manualmente e tente novamente.']);
                exit;
            }
        }

        // Limpar tabelas antigas (ordem respeitando foreign keys)
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $pdo->exec("DROP TABLE IF EXISTS activity_log");
        $pdo->exec("DROP TABLE IF EXISTS notifications");
        $pdo->exec("DROP TABLE IF EXISTS project_data");
        $pdo->exec("DROP TABLE IF EXISTS project_users");
        $pdo->exec("DROP TABLE IF EXISTS projects");
        $pdo->exec("DROP TABLE IF EXISTS login_attempts");
        $pdo->exec("DROP TABLE IF EXISTS password_resets");
        $pdo->exec("DROP TABLE IF EXISTS users");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

        // Tabelas Induzi
        $pdo->exec("CREATE TABLE users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            senha_hash VARCHAR(255) NOT NULL,
            role ENUM('admin','cliente') DEFAULT 'cliente',
            preferencias JSON,
            criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        $pdo->exec("CREATE TABLE projects (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            descricao TEXT,
            user_id INT UNSIGNED NOT NULL,
            criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        $pdo->exec("CREATE TABLE project_users (
            project_id INT UNSIGNED,
            user_id INT UNSIGNED,
            permissao ENUM('editar','visualizar') DEFAULT 'editar',
            PRIMARY KEY (project_id, user_id),
            FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        $pdo->exec("CREATE TABLE project_data (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            project_id INT UNSIGNED NOT NULL,
            data_key VARCHAR(100) NOT NULL,
            data_value LONGTEXT,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            updated_by INT UNSIGNED,
            UNIQUE KEY uk_project_key (project_id, data_key),
            FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        $pdo->exec("CREATE TABLE login_attempts (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            ip_address VARCHAR(45) NOT NULL,
            email VARCHAR(255),
            attempted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_la_ip (ip_address),
            INDEX idx_la_email (email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        $pdo->exec("CREATE TABLE password_resets (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255),
            token_hash VARCHAR(255),
            expires_at DATETIME,
            usado TINYINT(1) DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        $pdo->exec("CREATE TABLE activity_log (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            project_id INT UNSIGNED,
            user_id INT UNSIGNED,
            action VARCHAR(100) NOT NULL,
            details JSON,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_al_project (project_id, created_at),
            FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        $pdo->exec("CREATE TABLE notifications (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            tipo VARCHAR(50) NOT NULL,
            titulo VARCHAR(200) NOT NULL,
            mensagem TEXT,
            link VARCHAR(255),
            lida TINYINT(1) DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_notif_user (user_id, lida, created_at),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // Verificar se admin ja existe
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            echo json_encode(['ok' => false, 'msg' => 'Este email ja esta cadastrado.']);
            exit;
        }

        // Criar admin
        $stmt = $pdo->prepare('INSERT INTO users (nome, email, senha_hash, role) VALUES (?, ?, ?, ?)');
        $stmt->execute([$nome, $email, password_hash($senha, PASSWORD_BCRYPT), 'admin']);

        // Gerar config.php
        $configContent  = "<?php\n";
        $configContent .= "/**\n";
        $configContent .= " * Induzi — Configuracao do Banco de Dados\n";
        $configContent .= " * Gerado pelo instalador em " . date('Y-m-d H:i:s') . "\n";
        $configContent .= " */\n\n";
        $configContent .= "define('DB_HOST', " . var_export($host, true) . ");\n";
        $configContent .= "define('DB_NAME', " . var_export($dbname, true) . ");\n";
        $configContent .= "define('DB_USER', " . var_export($dbuser, true) . ");\n";
        $configContent .= "define('DB_PASS', " . var_export($dbpass, true) . ");\n";
        $configContent .= "define('DB_CHARSET', 'utf8mb4');\n";

        if (file_put_contents($configFile, $configContent) === false) {
            echo json_encode(['ok' => false, 'msg' => 'Banco criado, mas nao foi possivel gravar config.php.']);
            exit;
        }

        echo json_encode(['ok' => true, 'msg' => 'Instalacao concluida com sucesso!']);
    } catch (PDOException $e) {
        error_log('Install error: ' . $e->getMessage());
        echo json_encode(['ok' => false, 'msg' => 'Erro durante a instalacao: ' . $e->getMessage()]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalacao — Induzi</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg: #f5f5f5; --card: #fff; --border: #e5e5e5;
            --black: #1a1a1a; --white: #fff; --gray: #888; --gray-light: #aaa;
            --purple: #7c3aed; --purple-light: #ede9fe; --purple-border: #c4b5fd;
            --green: #2e7d32; --green-bg: #e8f5e9; --green-border: #c8e6c9;
            --red: #c62828; --red-bg: #ffebee; --red-border: #ffcdd2;
            --orange: #e65100; --orange-bg: #fff3e0; --orange-border: #ffe0b2;
        }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: var(--bg); color: var(--black); display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        .container { width: 100%; max-width: 540px; }
        .logo { text-align: center; margin-bottom: 32px; }
        .logo h1 { font-size: 1.5rem; font-weight: 700; letter-spacing: -0.3px; color: var(--purple); }
        .logo span { display: block; font-size: 0.7rem; font-weight: 400; color: var(--gray); text-transform: uppercase; letter-spacing: 1.5px; margin-top: 4px; }
        .steps { display: flex; justify-content: center; align-items: flex-start; gap: 0; margin-bottom: 28px; }
        .step-item { text-align: center; }
        .step-num { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.85rem; background: var(--border); color: var(--gray); transition: all 0.3s; margin: 0 auto; }
        .step-num.active { background: var(--purple); color: var(--white); }
        .step-num.done { background: var(--green); color: var(--white); }
        .step-line { width: 48px; height: 2px; background: var(--border); margin-top: 15px; transition: background 0.3s; }
        .step-line.done { background: var(--green); }
        .step-label { display: block; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray); margin-top: 6px; }
        .step-label.active, .step-label.done { color: var(--black); }
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 8px; padding: 36px 32px; }
        .card h2 { font-size: 1.1rem; font-weight: 600; margin: 0 0 6px 0; }
        .card .subtitle { font-size: 0.85rem; color: var(--gray); margin-bottom: 24px; }
        .req-list { list-style: none; margin-bottom: 20px; }
        .req-item { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f0f0f0; font-size: 0.9rem; }
        .req-item:last-child { border-bottom: none; }
        .req-icon { width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .req-icon.ok { background: var(--green-bg); color: var(--green); }
        .req-icon.fail { background: var(--red-bg); color: var(--red); }
        .req-label { flex: 1; }
        .req-value { font-size: 0.8rem; color: var(--gray); }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: #666; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .form-group input { width: 100%; padding: 11px 15px; border: 1px solid var(--border); border-radius: 6px; font-size: 0.95rem; font-family: inherit; background: var(--white); color: var(--black); transition: border-color 0.2s; }
        .form-group input:focus { outline: none; border-color: var(--purple); }
        .form-group .hint { font-size: 0.75rem; color: var(--gray-light); margin-top: 4px; }
        .form-separator { border: none; border-top: 1px solid var(--border); margin: 24px 0; }
        .btn { width: 100%; padding: 13px; border-radius: 6px; cursor: pointer; font-size: 0.95rem; font-weight: 500; font-family: inherit; transition: all 0.3s; border: 2px solid var(--purple); }
        .btn:disabled { opacity: 0.5; cursor: not-allowed; }
        .btn-primary { background: var(--purple); color: var(--white); margin-top: 6px; }
        .btn-primary:hover:not(:disabled) { background: var(--white); color: var(--purple); }
        .btn-secondary { background: var(--white); color: var(--black); border-color: var(--border); margin-top: 10px; }
        .btn-secondary:hover:not(:disabled) { border-color: var(--purple); }
        .msg { padding: 12px 16px; border-radius: 6px; font-size: 0.85rem; margin-top: 16px; display: none; }
        .msg.success { display: block; background: var(--green-bg); color: var(--green); border: 1px solid var(--green-border); }
        .msg.error { display: block; background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border); }
        .panel { display: none; }
        .panel.active { display: block; }
        .done-view { text-align: center; padding: 20px 0; }
        .done-icon { width: 64px; height: 64px; border-radius: 50%; background: var(--green); color: var(--white); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
        .done-icon svg { width: 32px; height: 32px; }
        .done-view p { font-size: 0.9rem; color: #666; margin-bottom: 8px; line-height: 1.5; }
        .done-warning { background: var(--orange-bg); color: var(--orange); border: 1px solid var(--orange-border); padding: 12px 16px; border-radius: 6px; font-size: 0.85rem; margin: 20px 0; text-align: left; }
        .done-view .btn-primary { max-width: 280px; margin: 0 auto; display: block; text-decoration: none; text-align: center; line-height: 1; }
        .spinner { display: inline-block; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.6s linear infinite; vertical-align: middle; margin-right: 6px; }
        @keyframes spin { to { transform: rotate(360deg); } }
        @media (max-width: 480px) { .card { padding: 28px 20px; } .step-line { width: 32px; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>Induzi</h1>
            <span>Instalacao</span>
        </div>
        <div class="steps">
            <div class="step-item"><div class="step-num active" id="sn1">1</div><span class="step-label active" id="sl1">Requisitos</span></div>
            <div class="step-item"><div class="step-line" id="line1"></div></div>
            <div class="step-item"><div class="step-num" id="sn2">2</div><span class="step-label" id="sl2">Configurar</span></div>
            <div class="step-item"><div class="step-line" id="line2"></div></div>
            <div class="step-item"><div class="step-num" id="sn3">3</div><span class="step-label" id="sl3">Pronto</span></div>
        </div>
        <div class="card">
            <div class="panel active" id="p1">
                <h2>Verificacao de Requisitos</h2>
                <p class="subtitle">Verificando se o servidor atende aos requisitos do sistema.</p>
                <ul class="req-list" id="reqList"><li class="req-item"><span style="color:var(--gray)">Verificando...</span></li></ul>
                <button class="btn btn-primary" id="btnReq" onclick="goToStep(2)" disabled>Proximo</button>
                <div class="msg" id="msgReq"></div>
            </div>
            <div class="panel" id="p2">
                <h2>Banco de Dados</h2>
                <p class="subtitle">Informe os dados de acesso ao MySQL.</p>
                <div class="form-group"><label for="dbHost">Host MySQL</label><input type="text" id="dbHost" value="localhost"></div>
                <div class="form-group"><label for="dbName">Nome do Banco</label><input type="text" id="dbName" value="induzi"><div class="hint">Sera criado automaticamente se nao existir</div></div>
                <div class="form-group"><label for="dbUser">Usuario MySQL</label><input type="text" id="dbUser" value="root"></div>
                <div class="form-group"><label for="dbPass">Senha MySQL</label><input type="password" id="dbPass" value=""></div>
                <button class="btn btn-secondary" id="btnTest" onclick="testDb()">Testar Conexao</button>
                <div class="msg" id="msgDb"></div>
                <hr class="form-separator" id="adminSep" style="display:none">
                <div id="adminSection" style="display:none">
                    <h2>Administrador</h2>
                    <p class="subtitle">Crie a conta do primeiro administrador.</p>
                    <div class="form-group"><label for="admNome">Nome *</label><input type="text" id="admNome" placeholder="Seu nome completo"></div>
                    <div class="form-group"><label for="admEmail">Email *</label><input type="email" id="admEmail" placeholder="seu@email.com"></div>
                    <div class="form-group"><label for="admSenha">Senha *</label><input type="password" id="admSenha" placeholder="Minimo 8 caracteres"></div>
                    <div class="form-group"><label for="admSenha2">Confirmar Senha *</label><input type="password" id="admSenha2" placeholder="Repita a senha"></div>
                    <button class="btn btn-primary" id="btnInstall" onclick="doInstall()">Instalar</button>
                    <div class="msg" id="msgInstall"></div>
                </div>
                <button class="btn btn-secondary" onclick="goToStep(1)" style="margin-top:12px">Voltar</button>
            </div>
            <div class="panel" id="p3">
                <div class="done-view">
                    <div class="done-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                    <h2>Instalacao Concluida!</h2>
                    <p>O sistema foi configurado com sucesso. Voce ja pode fazer login.</p>
                    <div class="done-warning"><strong>Importante:</strong> Por seguranca, delete o arquivo <code>install.php</code> do servidor apos a instalacao.</div>
                    <a href="login.php" class="btn btn-primary" style="margin-top:16px;">Ir para o Login</a>
                </div>
            </div>
        </div>
    </div>
    <script>
    var dbTested = false;
    function $(id) { return document.getElementById(id); }
    function showMsg(id, type, text) { var el = $(id); el.className = 'msg ' + type; el.textContent = text; }
    function hideMsg(id) { var el = $(id); el.className = 'msg'; el.style.display = ''; }
    function setLoading(btnId, loading, text) { var btn = $(btnId); if (loading) { btn.disabled = true; btn.innerHTML = '<span class="spinner"></span> ' + (text || 'Aguarde...'); } else { btn.disabled = false; btn.textContent = text || btn.textContent; } }
    function goToStep(step) {
        document.querySelectorAll('.panel').forEach(function(p) { p.classList.remove('active'); });
        $('p' + step).classList.add('active');
        for (var i = 1; i <= 3; i++) {
            var n = $('sn' + i), l = $('sl' + i);
            n.className = 'step-num'; l.className = 'step-label';
            if (i < step) { n.classList.add('done'); n.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><polyline points="20 6 9 17 4 12"></polyline></svg>'; l.classList.add('done'); }
            else if (i === step) { n.classList.add('active'); n.textContent = i; l.classList.add('active'); }
            else { n.textContent = i; }
        }
        for (var j = 1; j <= 2; j++) { var ln = $('line' + j); if (j < step) ln.classList.add('done'); else ln.classList.remove('done'); }
    }
    async function checkRequirements() {
        try {
            var resp = await fetch('install.php?action=check_requirements');
            var data = await resp.json();
            if (!data.ok) { showMsg('msgReq', 'error', 'Erro ao verificar requisitos.'); return; }
            var list = $('reqList'); list.innerHTML = '';
            data.checks.forEach(function(c) {
                var li = document.createElement('li'); li.className = 'req-item';
                li.innerHTML = '<span class="req-icon ' + (c.ok ? 'ok' : 'fail') + '">' + (c.ok ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;"><polyline points="20 6 9 17 4 12"></polyline></svg>' : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>') + '</span><span class="req-label">' + c.label + '</span><span class="req-value">' + c.value + '</span>';
                list.appendChild(li);
            });
            if (data.allOk) { $('btnReq').disabled = false; } else { showMsg('msgReq', 'error', 'Corrija os requisitos acima.'); }
        } catch (err) { showMsg('msgReq', 'error', 'Erro de comunicacao.'); }
    }
    async function testDb() {
        var host = $('dbHost').value.trim(), dbname = $('dbName').value.trim(), user = $('dbUser').value.trim(), pass = $('dbPass').value;
        if (!host || !dbname || !user) { showMsg('msgDb', 'error', 'Preencha host, nome do banco e usuario.'); return; }
        hideMsg('msgDb'); setLoading('btnTest', true, 'Testando...');
        try {
            var resp = await fetch('install.php?action=test_db', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ host: host, dbname: dbname, user: user, pass: pass }) });
            var data = await resp.json();
            if (data.ok) { showMsg('msgDb', 'success', data.msg); dbTested = true; $('adminSep').style.display = ''; $('adminSection').style.display = ''; }
            else { showMsg('msgDb', 'error', data.msg); dbTested = false; $('adminSep').style.display = 'none'; $('adminSection').style.display = 'none'; }
            setLoading('btnTest', false, 'Testar Conexao');
        } catch (err) { showMsg('msgDb', 'error', 'Erro de comunicacao.'); setLoading('btnTest', false, 'Testar Conexao'); }
    }
    async function doInstall() {
        var nome = $('admNome').value.trim(), email = $('admEmail').value.trim(), senha = $('admSenha').value, senha2 = $('admSenha2').value;
        if (!nome || !email || !senha) { showMsg('msgInstall', 'error', 'Preencha nome, email e senha.'); return; }
        if (senha.length < 8) { showMsg('msgInstall', 'error', 'Senha deve ter no minimo 8 caracteres.'); return; }
        if (senha !== senha2) { showMsg('msgInstall', 'error', 'As senhas nao conferem.'); return; }
        hideMsg('msgInstall'); setLoading('btnInstall', true, 'Instalando...');
        try {
            var resp = await fetch('install.php?action=install', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ db_host: $('dbHost').value.trim(), db_name: $('dbName').value.trim(), db_user: $('dbUser').value.trim(), db_pass: $('dbPass').value, admin_nome: nome, admin_email: email, admin_senha: senha }) });
            var data = await resp.json();
            if (data.ok) { goToStep(3); } else { showMsg('msgInstall', 'error', data.msg); setLoading('btnInstall', false, 'Instalar'); }
        } catch (err) { showMsg('msgInstall', 'error', 'Erro de comunicacao.'); setLoading('btnInstall', false, 'Instalar'); }
    }
    document.querySelectorAll('#dbHost, #dbName, #dbUser, #dbPass').forEach(function(el) {
        el.addEventListener('input', function() { if (dbTested) { dbTested = false; $('adminSep').style.display = 'none'; $('adminSection').style.display = 'none'; hideMsg('msgDb'); } });
    });
    checkRequirements();
    </script>
</body>
</html>
