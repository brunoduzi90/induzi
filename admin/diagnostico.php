<?php
/**
 * Diagnostico SPA — Testa o sistema de fragmentos na Hostinger
 * Acesse: https://induzi.studio/admin/diagnostico.php
 * REMOVA este arquivo apos o diagnostico!
 */
if (!file_exists(__DIR__ . '/../config.php')) { die('config.php nao encontrado'); }

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../version.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

if (empty($_SESSION['induzi_user']['userId'])) { header('Location: login.php'); exit; }

// Test fragment endpoint
$fragmentUrl = dirname($_SERVER['SCRIPT_NAME']) . '/pages/index.php?fragment=1';
$fullUrl = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $fragmentUrl;

// Test internal request
$testResult = 'N/A';
$testBody = '';
$testHeaders = '';
$testError = '';

// Test using file_get_contents with stream context
$ctx = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => "Cookie: " . ($_SERVER['HTTP_COOKIE'] ?? '') . "\r\nX-Requested-With: XMLHttpRequest\r\n",
        'timeout' => 10,
        'ignore_errors' => true,
    ],
    'ssl' => ['verify_peer' => false, 'verify_peer_name' => false],
]);

$testBody = @file_get_contents($fullUrl, false, $ctx);
if ($testBody === false) {
    $testError = 'file_get_contents falhou: ' . error_get_last()['message'] ?? 'erro desconhecido';
    $testResult = 'FALHOU';
} else {
    $testHeaders = implode("\n", $http_response_header ?? []);
    $decoded = json_decode($testBody, true);
    if ($decoded && !empty($decoded['ok'])) {
        $testResult = 'OK';
    } else {
        $testResult = 'RESPOSTA INVALIDA';
    }
}

// Test DB
$dbOk = false;
$dbError = '';
try {
    $db = getDB();
    $db->query('SELECT 1');
    $dbOk = true;
} catch (Exception $e) {
    $dbError = $e->getMessage();
}

// Check ob levels
$obLevel = ob_get_level();
$obStatus = [];
for ($i = 0; $i < $obLevel; $i++) {
    $obStatus[] = ob_get_status(true)[$i] ?? [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Diagnostico INDUZI</title>
<style>
body { font-family: monospace; background: #1a1a1a; color: #e0e0e0; padding: 20px; max-width: 900px; margin: 0 auto; }
h1 { color: #B8E0C8; }
.ok { color: #4caf50; font-weight: bold; }
.fail { color: #f44336; font-weight: bold; }
.warn { color: #ff9800; }
table { width: 100%; border-collapse: collapse; margin: 16px 0; }
td, th { border: 1px solid #333; padding: 8px; text-align: left; }
th { background: #252525; }
pre { background: #252525; padding: 12px; border-radius: 4px; overflow-x: auto; max-height: 300px; white-space: pre-wrap; word-break: break-all; }
.section { margin: 24px 0; padding: 16px; border: 1px solid #333; border-radius: 8px; }
button { background: #B8E0C8; color: #000; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-family: monospace; font-weight: bold; }
#jsResult { margin-top: 16px; }
</style>
</head>
<body>
<h1>Diagnostico INDUZI v<?= INDUZI_VERSION ?></h1>

<div class="section">
<h2>1. Ambiente PHP</h2>
<table>
<tr><th>Item</th><th>Valor</th></tr>
<tr><td>PHP Version</td><td><?= PHP_VERSION ?></td></tr>
<tr><td>Server Software</td><td><?= $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' ?></td></tr>
<tr><td>Document Root</td><td><?= $_SERVER['DOCUMENT_ROOT'] ?></td></tr>
<tr><td>Script Filename</td><td><?= $_SERVER['SCRIPT_FILENAME'] ?></td></tr>
<tr><td>output_buffering</td><td><?= ini_get('output_buffering') ?: 'Off' ?></td></tr>
<tr><td>zlib.output_compression</td><td><?= ini_get('zlib.output_compression') ?: 'Off' ?></td></tr>
<tr><td>OB Level atual</td><td><?= $obLevel ?></td></tr>
<tr><td>session.save_handler</td><td><?= ini_get('session.save_handler') ?></td></tr>
<tr><td>max_execution_time</td><td><?= ini_get('max_execution_time') ?>s</td></tr>
<tr><td>display_errors</td><td><?= ini_get('display_errors') ?></td></tr>
</table>
</div>

<div class="section">
<h2>2. Banco de Dados</h2>
<p>Status: <?= $dbOk ? '<span class="ok">CONECTADO</span>' : '<span class="fail">FALHA: ' . htmlspecialchars($dbError) . '</span>' ?></p>
</div>

<div class="section">
<h2>3. Sessao</h2>
<table>
<tr><th>Item</th><th>Valor</th></tr>
<tr><td>Session ID</td><td><?= session_id() ?></td></tr>
<tr><td>User ID</td><td><?= $_SESSION['induzi_user']['userId'] ?? 'N/A' ?></td></tr>
<tr><td>CSRF Token</td><td><?= substr($_SESSION['csrf_token'] ?? '', 0, 16) ?>...</td></tr>
<tr><td>Last Activity</td><td><?= isset($_SESSION['last_activity']) ? date('Y-m-d H:i:s', $_SESSION['last_activity']) : 'N/A' ?></td></tr>
</table>
</div>

<div class="section">
<h2>4. Teste Fragment (server-side)</h2>
<p>URL testada: <code><?= htmlspecialchars($fullUrl) ?></code></p>
<p>Resultado: <?= $testResult === 'OK' ? '<span class="ok">OK — Fragment retorna JSON valido</span>' : '<span class="fail">' . htmlspecialchars($testResult) . '</span>' ?></p>
<?php if ($testError): ?>
<p class="fail">Erro: <?= htmlspecialchars($testError) ?></p>
<?php endif; ?>
<?php if ($testHeaders): ?>
<h3>Response Headers:</h3>
<pre><?= htmlspecialchars($testHeaders) ?></pre>
<?php endif; ?>
<?php if ($testBody !== false): ?>
<h3>Response Body (primeiros 2000 chars):</h3>
<pre><?= htmlspecialchars(substr($testBody, 0, 2000)) ?></pre>
<?php endif; ?>
</div>

<div class="section">
<h2>5. Teste Fragment (JavaScript — igual ao SPA)</h2>
<p>Este teste simula exatamente o que o SPA faz ao carregar uma pagina.</p>
<button onclick="testFragment()">Executar Teste JS</button>
<div id="jsResult"></div>
</div>

<div class="section">
<h2>6. Arquivos Criticos</h2>
<table>
<tr><th>Arquivo</th><th>Existe?</th><th>Tamanho</th></tr>
<?php
$criticalFiles = [
    'pages/index.php',
    'pages/mensagens.php',
    'pages/leads.php',
    'pages/newsletter.php',
    'pages/configuracoes.php',
    'pages/contas.php',
    'pages/atualizacao.php',
    'js/spa.js',
    'js/db.js',
    'js/auth.js',
    'js/components.js',
    'js/modal-system.js',
    'js/theme.js',
    'css/style.css',
    '../includes/fragment.php',
    '../includes/auth.php',
    '../includes/db.php',
    '../includes/helpers.php',
    '../includes/analytics-data.php',
    '../config.php',
    '../version.php',
];
foreach ($criticalFiles as $f):
    $path = __DIR__ . '/' . $f;
    $exists = file_exists($path);
    $size = $exists ? filesize($path) : 0;
?>
<tr>
    <td><?= htmlspecialchars($f) ?></td>
    <td><?= $exists ? '<span class="ok">SIM</span>' : '<span class="fail">NAO</span>' ?></td>
    <td><?= $exists ? number_format($size) . ' bytes' : '-' ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>

<script>
async function testFragment() {
    var el = document.getElementById('jsResult');
    el.innerHTML = '<p class="warn">Testando...</p>';

    var csrfToken = '<?= $_SESSION['csrf_token'] ?>';
    var url = 'pages/index.php?fragment=1&_t=' + Date.now();
    var startTime = Date.now();

    try {
        var controller = new AbortController();
        var timeoutId = setTimeout(function() { controller.abort(); }, 15000);

        var res = await fetch(url, {
            headers: {
                'X-CSRF-Token': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            signal: controller.signal
        });

        clearTimeout(timeoutId);
        var elapsed = Date.now() - startTime;

        var contentType = res.headers.get('content-type') || 'N/A';
        var statusCode = res.status;
        var text = await res.text();

        var html = '<table>';
        html += '<tr><td>Status HTTP</td><td>' + statusCode + '</td></tr>';
        html += '<tr><td>Content-Type</td><td>' + contentType + '</td></tr>';
        html += '<tr><td>Tempo</td><td>' + elapsed + 'ms</td></tr>';
        html += '<tr><td>Tamanho</td><td>' + text.length + ' chars</td></tr>';
        html += '</table>';

        // Try to parse as JSON
        try {
            var json = JSON.parse(text);
            if (json.ok) {
                html += '<p class="ok">SUCESSO — Fragment retornou JSON valido com ok=true</p>';
                html += '<p>HTML length: ' + (json.html || '').length + ' chars</p>';
                html += '<p>Scripts length: ' + (json.scripts || '').length + ' chars</p>';
                html += '<p>Styles length: ' + (json.styles || '').length + ' chars</p>';
            } else {
                html += '<p class="fail">Fragment retornou ok=false: ' + (json.msg || 'sem mensagem') + '</p>';
            }
        } catch (parseErr) {
            html += '<p class="fail">FALHA — Resposta nao e JSON valido!</p>';
            html += '<p>Erro de parse: ' + parseErr.message + '</p>';
            html += '<h3>Primeiros 1000 chars da resposta:</h3>';
            html += '<pre>' + text.substring(0, 1000).replace(/</g, '&lt;') + '</pre>';
        }

        el.innerHTML = html;

    } catch (e) {
        var elapsed = Date.now() - startTime;
        if (e.name === 'AbortError') {
            el.innerHTML = '<p class="fail">TIMEOUT — Requisicao levou mais de 15 segundos sem resposta (' + elapsed + 'ms)</p>' +
                '<p>Isso indica que o servidor esta travando ao processar o fragment. Possiveis causas:</p>' +
                '<ul><li>Session lock (outra requisicao segurando a sessao)</li>' +
                '<li>Query SQL lenta</li>' +
                '<li>PHP execution timeout</li></ul>';
        } else {
            el.innerHTML = '<p class="fail">ERRO: ' + e.message + ' (' + elapsed + 'ms)</p>';
        }
    }
}
</script>

<div class="section">
<h2>7. .htaccess</h2>
<h3>Root .htaccess:</h3>
<pre><?= htmlspecialchars(file_get_contents(__DIR__ . '/../.htaccess') ?: 'NAO ENCONTRADO') ?></pre>
<h3>Admin .htaccess:</h3>
<pre><?= htmlspecialchars(file_get_contents(__DIR__ . '/.htaccess') ?: 'NAO ENCONTRADO') ?></pre>
</div>

</body>
</html>
