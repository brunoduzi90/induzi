<?php
/**
 * INDUZI - Atualizador do Sistema
 *
 * Aplica migracoes de banco de dados e verifica integridade.
 * Acesso restrito a administradores autenticados.
 *
 * Uso: apos fazer upload dos arquivos novos, acesse /update.php
 */

// Carregar config
$configFile = __DIR__ . '/config.php';
if (!file_exists($configFile)) {
    header('Location: install.php');
    exit;
}
require_once $configFile;

// Carregar versao
if (file_exists(__DIR__ . '/version.php')) {
    require_once __DIR__ . '/version.php';
}
$codeVersion = defined('INDUZI_VERSION') ? INDUZI_VERSION : '0.0.0';

// Auth - exigir admin
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/update-helpers.php';

// Constante para migracoes referenciarem o diretorio raiz
if (!defined('INDUZI_ROOT_DIR')) {
    define('INDUZI_ROOT_DIR', __DIR__);
}

$session = getSessionData();
if (!$session || empty($session['userId']) || ($session['role'] ?? '') !== 'admin') {
    http_response_code(403);
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Acesso negado</title></head><body style="background:#0f0f1a;color:#e2e8f0;font-family:sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;">';
    echo '<div style="text-align:center;"><h2>Acesso negado</h2><p>Apenas administradores autenticados podem acessar o atualizador.</p>';
    echo '<p><a href="admin/login.php" style="color:#B8E0C8;">Fazer login</a></p></div></body></html>';
    exit;
}

// Conectar ao banco
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo 'Erro de conexao com o banco: ' . htmlspecialchars($e->getMessage());
    exit;
}

// Carregar migracoes de arquivos
$migrations = loadMigrations();

/**
 * Obter migracoes pendentes
 */
function getPendingMigrations(array $migrations, string $dbVersion): array {
    $pending = [];
    foreach ($migrations as $m) {
        if (version_compare($m['version'], $dbVersion, '>')) {
            $pending[] = $m;
        }
    }
    return $pending;
}

// ============================================================
// AJAX ENDPOINTS
// ============================================================

// --- Status ---
if (isset($_GET['action']) && $_GET['action'] === 'status') {
    header('Content-Type: application/json; charset=utf-8');
    $dbVersion = getDbVersion($pdo);
    $pending = getPendingMigrations($migrations, $dbVersion);

    // Verificacoes rapidas
    $checks = [];

    // PHP
    $checks[] = [
        'label' => 'PHP ' . phpversion(),
        'ok' => version_compare(phpversion(), '7.4', '>='),
    ];

    // Banco
    $checks[] = [
        'label' => 'Conexao MySQL',
        'ok' => true,
    ];

    // Tabelas INDUZI
    $tables = ['users', 'login_attempts', 'password_resets', 'activity_log', 'mensagens', 'configuracoes', 'newsletter', 'leads'];
    $missingTables = [];
    foreach ($tables as $t) {
        try { $pdo->query("SELECT 1 FROM `$t` LIMIT 1"); }
        catch (PDOException $e) { $missingTables[] = $t; }
    }
    $checks[] = [
        'label' => empty($missingTables) ? 'Tabelas OK (' . count($tables) . ')' : 'Tabelas faltando: ' . implode(', ', $missingTables),
        'ok' => empty($missingTables),
    ];

    // Storage dir
    $storageDir = __DIR__ . '/storage';
    $checks[] = [
        'label' => 'Pasta storage/',
        'ok' => is_dir($storageDir) && is_writable($storageDir),
    ];

    // .htaccess
    $checks[] = [
        'label' => '.htaccess',
        'ok' => file_exists(__DIR__ . '/.htaccess'),
    ];

    echo json_encode([
        'ok' => true,
        'codeVersion' => $codeVersion,
        'dbVersion' => $dbVersion,
        'upToDate' => empty($pending),
        'pendingCount' => count($pending),
        'pending' => array_map(function($m) {
            return ['version' => $m['version'], 'desc' => $m['desc']];
        }, $pending),
        'checks' => $checks,
    ]);
    exit;
}

// --- Executar migracoes ---
if (isset($_GET['action']) && $_GET['action'] === 'run') {
    header('Content-Type: application/json; charset=utf-8');

    // Validar CSRF
    $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    $xrw = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    if (!$xrw && (!$token || !hash_equals($_SESSION['csrf_token'] ?? '', $token))) {
        echo json_encode(['ok' => false, 'msg' => 'Token CSRF invalido. Recarregue a pagina.']);
        exit;
    }

    $dbVersion = getDbVersion($pdo);
    $pending = getPendingMigrations($migrations, $dbVersion);

    if (empty($pending)) {
        echo json_encode(['ok' => true, 'msg' => 'Sistema ja esta atualizado.', 'results' => []]);
        exit;
    }

    $results = [];
    $lastVersion = $dbVersion;
    $hasError = false;

    foreach ($pending as $m) {
        $result = [
            'version' => $m['version'],
            'desc' => $m['desc'],
            'ok' => true,
            'msg' => '',
        ];

        try {
            $msg = ($m['run'])($pdo);
            $result['msg'] = $msg;

            if (stripos($msg, 'ERRO:') === 0) {
                $result['ok'] = false;
                $hasError = true;
                $results[] = $result;
                break;
            }

            $lastVersion = $m['version'];
        } catch (PDOException $e) {
            $result['ok'] = false;
            $result['msg'] = 'Erro SQL: ' . $e->getMessage();
            $hasError = true;
            $results[] = $result;
            error_log('Update migration ' . $m['version'] . ' error: ' . $e->getMessage());
            break;
        } catch (Exception $e) {
            $result['ok'] = false;
            $result['msg'] = 'Erro: ' . $e->getMessage();
            $hasError = true;
            $results[] = $result;
            error_log('Update migration ' . $m['version'] . ' error: ' . $e->getMessage());
            break;
        }

        $results[] = $result;
    }

    // Salvar versao alcancada
    if ($lastVersion !== $dbVersion) {
        setDbVersion($pdo, $lastVersion);
    }

    // Registrar no activity log
    try {
        logActivity($pdo, $session['userId'], 'system_update', [
            'from' => $dbVersion,
            'to' => $lastVersion,
            'results' => $results,
        ]);
    } catch (Exception $e) {
        // activity_log pode nao existir
    }

    echo json_encode([
        'ok' => !$hasError,
        'msg' => $hasError
            ? 'Atualizacao parou com erro na versao ' . end($results)['version'] . '.'
            : 'Sistema atualizado para versao ' . $lastVersion . '!',
        'newVersion' => $lastVersion,
        'results' => $results,
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar - INDUZI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0f0f1a;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .update-container {
            width: 100%;
            max-width: 580px;
        }

        .update-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .update-logo h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.3px;
        }

        .update-logo span {
            display: block;
            font-size: 0.7rem;
            font-weight: 400;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 4px;
        }

        .card {
            background: #1a1a2e;
            border: 1px solid #2d2d44;
            border-radius: 12px;
            padding: 32px;
            margin-bottom: 16px;
        }

        .card h2 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            margin: 0 0 6px 0;
        }

        .card .subtitle {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 20px;
        }

        /* Version badges */
        .version-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .version-badge {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            font-family: 'Space Grotesk', monospace;
        }

        .version-badge.current {
            background: #2d2d44;
            color: #94a3b8;
        }

        .version-badge.target {
            background: #B8E0C8;
            color: #0f0f1a;
        }

        .version-badge.uptodate {
            background: rgba(184, 224, 200, 0.15);
            color: #B8E0C8;
        }

        .version-arrow {
            color: #4a4a6a;
            font-size: 1.2rem;
        }

        /* Checks */
        .check-list {
            margin-bottom: 20px;
        }

        .check-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 0;
            font-size: 0.85rem;
            border-bottom: 1px solid #2d2d44;
        }

        .check-item:last-child {
            border-bottom: none;
        }

        .check-icon {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .check-icon.ok { background: rgba(184, 224, 200, 0.2); color: #B8E0C8; }
        .check-icon.err { background: rgba(248, 113, 113, 0.2); color: #f87171; }

        .check-icon svg { width: 12px; height: 12px; }

        /* Migration list */
        .migration-list {
            margin-bottom: 20px;
        }

        .migration-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 12px;
            background: #0f0f1a;
            border: 1px solid #2d2d44;
            border-radius: 8px;
            margin-bottom: 6px;
            font-size: 0.85rem;
        }

        .migration-item .version-tag {
            background: #2d2d44;
            color: #94a3b8;
            padding: 2px 8px;
            border-radius: 4px;
            font-family: 'Space Grotesk', monospace;
            font-size: 0.8rem;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .migration-item.done { background: rgba(184, 224, 200, 0.08); border-color: rgba(184, 224, 200, 0.2); }
        .migration-item.done .version-tag { background: rgba(184, 224, 200, 0.2); color: #B8E0C8; }
        .migration-item.fail { background: rgba(248, 113, 113, 0.08); border-color: rgba(248, 113, 113, 0.2); }
        .migration-item.fail .version-tag { background: rgba(248, 113, 113, 0.2); color: #f87171; }

        .migration-msg {
            font-size: 0.78rem;
            color: #64748b;
            margin-top: 2px;
        }

        /* Buttons */
        .btn-primary {
            width: 100%;
            padding: 13px;
            background: #B8E0C8;
            color: #0f0f1a;
            border: 2px solid #B8E0C8;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Space Grotesk', sans-serif;
            transition: all 0.3s;
        }

        .btn-primary:hover { background: #9fd4b0; border-color: #9fd4b0; }
        .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; }
        .btn-primary:disabled:hover { background: #B8E0C8; border-color: #B8E0C8; }

        .btn-secondary {
            display: inline-block;
            width: 100%;
            padding: 13px;
            background: transparent;
            color: #e2e8f0;
            border: 2px solid #2d2d44;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 500;
            font-family: 'Space Grotesk', sans-serif;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-secondary:hover { border-color: #B8E0C8; color: #B8E0C8; }

        /* Loading */
        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(15,15,26,0.3);
            border-top-color: #0f0f1a;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            vertical-align: middle;
            margin-right: 6px;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* Messages */
        .msg {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-top: 16px;
            display: none;
        }

        .msg.success { display: block; background: rgba(184, 224, 200, 0.1); color: #B8E0C8; border: 1px solid rgba(184, 224, 200, 0.2); }
        .msg.error { display: block; background: rgba(248, 113, 113, 0.1); color: #f87171; border: 1px solid rgba(248, 113, 113, 0.2); }
        .msg.warning { display: block; background: rgba(251, 191, 36, 0.1); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.2); }

        /* States */
        .state { display: none; }
        .state.active { display: block; }

        /* Back link */
        .back-link {
            display: block;
            text-align: center;
            margin-top: 16px;
            font-size: 0.85rem;
            color: #64748b;
            text-decoration: none;
        }

        .back-link:hover { color: #B8E0C8; }

        /* Responsive */
        @media (max-width: 480px) {
            .card { padding: 24px 20px; }
        }
    </style>
</head>
<body>
    <div class="update-container">
        <div class="update-logo">
            <h1>INDUZI</h1>
            <span>Atualizador</span>
        </div>

        <!-- State: Loading -->
        <div class="state active" id="stateLoading">
            <div class="card" style="text-align:center;padding:48px 32px;">
                <div class="spinner" style="width:28px;height:28px;border-width:3px;border-color:rgba(184,224,200,0.2);border-top-color:#B8E0C8;margin:0 auto 16px;"></div>
                <p style="color:#64748b;font-size:0.9rem;">Verificando sistema...</p>
            </div>
        </div>

        <!-- State: Ready to update -->
        <div class="state" id="stateReady">
            <div class="card">
                <h2>Atualizacao Disponivel</h2>
                <p class="subtitle">Revise as alteracoes e clique em atualizar.</p>

                <div class="version-row">
                    <div class="version-badge current" id="versionFrom">v---</div>
                    <span class="version-arrow">&rarr;</span>
                    <div class="version-badge target" id="versionTo">v---</div>
                </div>

                <div class="check-list" id="checkList"></div>

                <h3 style="font-size:0.8rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;">Migracoes pendentes</h3>
                <div class="migration-list" id="migrationList"></div>

                <div class="msg warning" style="display:block;margin-bottom:16px;">
                    <strong>Recomendado:</strong> Faca backup do banco de dados antes de atualizar.
                </div>

                <button class="btn-primary" id="btnUpdate" onclick="runUpdate()">Atualizar Sistema</button>
                <div class="msg" id="msgUpdate"></div>
            </div>
            <a href="admin/" class="back-link">&larr; Voltar ao painel</a>
        </div>

        <!-- State: Up to date -->
        <div class="state" id="stateUpToDate">
            <div class="card" style="text-align:center;">
                <div style="width:56px;height:56px;border-radius:50%;background:rgba(184,224,200,0.15);color:#B8E0C8;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:28px;height:28px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <h2>Sistema Atualizado</h2>
                <p class="subtitle" id="upToDateVersion">Versao ---</p>

                <div class="check-list" id="checkListOk" style="text-align:left;"></div>

                <a href="admin/" class="btn-secondary" style="margin-top:20px;">Voltar ao Painel</a>
            </div>
        </div>

        <!-- State: Done (after running) -->
        <div class="state" id="stateDone">
            <div class="card">
                <div style="text-align:center;margin-bottom:20px;">
                    <div id="doneIcon" style="width:56px;height:56px;border-radius:50%;background:rgba(184,224,200,0.15);color:#B8E0C8;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:28px;height:28px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <h2 id="doneTitle">Atualizacao Concluida!</h2>
                    <p class="subtitle" id="doneSubtitle"></p>
                </div>

                <h3 style="font-size:0.8rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;">Resultado das migracoes</h3>
                <div class="migration-list" id="resultList"></div>

                <a href="admin/" class="btn-primary" style="display:block;text-decoration:none;text-align:center;margin-top:20px;">Ir para o Painel</a>
            </div>
        </div>

        <!-- State: Error -->
        <div class="state" id="stateError">
            <div class="card" style="text-align:center;">
                <div style="width:56px;height:56px;border-radius:50%;background:rgba(248,113,113,0.15);color:#f87171;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:28px;height:28px;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </div>
                <h2>Erro</h2>
                <p class="subtitle" id="errorMsg">Nao foi possivel verificar o sistema.</p>
                <button class="btn-primary" onclick="checkStatus()" style="max-width:200px;margin:16px auto 0;">Tentar novamente</button>
            </div>
            <a href="admin/" class="back-link">&larr; Voltar ao painel</a>
        </div>
    </div>

    <script>
    const CSRF_TOKEN = <?= json_encode($_SESSION['csrf_token'] ?? '') ?>;

    function showState(id) {
        document.querySelectorAll('.state').forEach(s => s.classList.remove('active'));
        document.getElementById(id).classList.add('active');
    }

    function checkIcon(ok) {
        if (ok) {
            return '<div class="check-icon ok"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></div>';
        }
        return '<div class="check-icon err"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></div>';
    }

    function renderChecks(containerId, checks) {
        const el = document.getElementById(containerId);
        el.innerHTML = checks.map(c =>
            '<div class="check-item">' + checkIcon(c.ok) + '<span>' + c.label + '</span></div>'
        ).join('');
    }

    async function checkStatus() {
        showState('stateLoading');
        try {
            const resp = await fetch('update.php?action=status');
            const data = await resp.json();

            if (!data.ok) {
                document.getElementById('errorMsg').textContent = data.msg || 'Erro desconhecido.';
                showState('stateError');
                return;
            }

            if (data.upToDate) {
                document.getElementById('upToDateVersion').textContent = 'Versao ' + data.codeVersion;
                renderChecks('checkListOk', data.checks);
                showState('stateUpToDate');
            } else {
                document.getElementById('versionFrom').textContent = 'v' + data.dbVersion;
                document.getElementById('versionTo').textContent = 'v' + data.codeVersion;

                renderChecks('checkList', data.checks);

                const list = document.getElementById('migrationList');
                list.innerHTML = data.pending.map(m =>
                    '<div class="migration-item">' +
                        '<span class="version-tag">' + m.version + '</span>' +
                        '<span>' + m.desc + '</span>' +
                    '</div>'
                ).join('');

                showState('stateReady');
            }
        } catch (err) {
            document.getElementById('errorMsg').textContent = 'Erro de comunicacao com o servidor: ' + err.message;
            showState('stateError');
        }
    }

    async function runUpdate() {
        const btn = document.getElementById('btnUpdate');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner"></span> Atualizando...';
        document.getElementById('msgUpdate').className = 'msg';

        try {
            const resp = await fetch('update.php?action=run', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });
            const data = await resp.json();

            const list = document.getElementById('resultList');
            list.innerHTML = (data.results || []).map(r =>
                '<div class="migration-item ' + (r.ok ? 'done' : 'fail') + '">' +
                    '<span class="version-tag">' + r.version + '</span>' +
                    '<div><span>' + r.desc + '</span>' +
                    (r.msg ? '<div class="migration-msg">' + r.msg + '</div>' : '') +
                    '</div>' +
                '</div>'
            ).join('');

            const doneIcon = document.getElementById('doneIcon');
            const doneTitle = document.getElementById('doneTitle');
            const doneSub = document.getElementById('doneSubtitle');

            if (data.ok) {
                doneIcon.style.background = 'rgba(184,224,200,0.15)';
                doneIcon.style.color = '#B8E0C8';
                doneTitle.textContent = 'Atualizacao Concluida!';
                doneSub.textContent = 'Sistema atualizado para versao ' + data.newVersion;
            } else {
                doneIcon.style.background = 'rgba(251,191,36,0.15)';
                doneIcon.style.color = '#fbbf24';
                doneIcon.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:28px;height:28px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';
                doneTitle.textContent = 'Atualizacao Parcial';
                doneSub.textContent = data.msg;
            }

            showState('stateDone');

        } catch (err) {
            document.getElementById('msgUpdate').className = 'msg error';
            document.getElementById('msgUpdate').textContent = 'Erro de comunicacao: ' + err.message;
            btn.disabled = false;
            btn.textContent = 'Atualizar Sistema';
        }
    }

    // Iniciar
    checkStatus();
    </script>
</body>
</html>
