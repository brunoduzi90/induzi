<?php
/**
 * Induzi - Funcoes auxiliares para atualizacao
 * Compartilhadas entre update.php, aplicar.php e baixar-remoto.php
 */

/**
 * Lista de arquivos/diretorios protegidos (nunca sobrescrever)
 */
function getProtectedItems(): array {
    return [
        'config.php',
        'uploads',
        'install.php',
        '.claude',
        '.git',
        'sys_temp',
    ];
}

/**
 * Copia arquivos recursivamente, respeitando protecoes
 */
function copyUpdateFiles(string $source, string $dest, string $rootDest, array $protected, string $prefix = ''): array {
    $updated = [];
    $items = scandir($source);

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;

        $relativePath = $prefix === '' ? $item : $prefix . '/' . $item;
        $srcPath = $source . DIRECTORY_SEPARATOR . $item;
        $dstPath = $dest . DIRECTORY_SEPARATOR . $item;

        // Verificar protecoes (match por prefixo)
        $skip = false;
        foreach ($protected as $p) {
            if (strpos($relativePath, $p) === 0) {
                $skip = true;
                break;
            }
        }
        if ($skip) continue;

        if (is_dir($srcPath)) {
            if (!is_dir($dstPath)) {
                mkdir($dstPath, 0755, true);
            }
            $subUpdated = copyUpdateFiles($srcPath, $dstPath, $rootDest, $protected, $relativePath);
            $updated = array_merge($updated, $subUpdated);
        } else {
            $existed = file_exists($dstPath);
            if (copy($srcPath, $dstPath)) {
                $updated[] = [
                    'path' => $relativePath,
                    'action' => $existed ? 'atualizado' : 'criado',
                ];
            }
        }
    }

    return $updated;
}

/**
 * Remove diretorio recursivamente
 */
function deleteDirectory(string $dir): void {
    if (!is_dir($dir)) return;

    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;

        $path = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            deleteDirectory($path);
        } else {
            unlink($path);
        }
    }
    rmdir($dir);
}

/**
 * Obter versao do schema armazenada no banco
 */
function getDbVersion(PDO $pdo): string {
    try {
        // Verificar se a tabela global_data existe
        $pdo->query("SELECT 1 FROM global_data LIMIT 1");
    } catch (PDOException $e) {
        // Tabela nao existe, criar
        $pdo->exec("CREATE TABLE IF NOT EXISTS global_data (
            data_key VARCHAR(100) PRIMARY KEY,
            data_value LONGTEXT,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        return '0.0.0';
    }

    try {
        $stmt = $pdo->prepare("SELECT data_value FROM global_data WHERE data_key = 'system_schema_version'");
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            $data = json_decode($row['data_value'], true);
            return $data['version'] ?? '0.0.0';
        }
    } catch (PDOException $e) {
        // Tabela pode nao existir
    }
    return '0.0.0';
}

/**
 * Salvar versao do schema no banco
 */
function setDbVersion(PDO $pdo, string $version): void {
    $data = json_encode(['version' => $version, 'updated_at' => date('Y-m-d H:i:s')]);
    $stmt = $pdo->prepare("INSERT INTO global_data (data_key, data_value) VALUES ('system_schema_version', ?)
        ON DUPLICATE KEY UPDATE data_value = VALUES(data_value)");
    $stmt->execute([$data]);
}

/**
 * Obter/definir configuracao global
 */
function getGlobalConfig(string $key, string $default = ''): string {
    try {
        $pdo = getDB();
        $stmt = $pdo->prepare("SELECT data_value FROM global_data WHERE data_key = ?");
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        return $row ? $row['data_value'] : $default;
    } catch (PDOException $e) {
        return $default;
    }
}

function setGlobalConfig(string $key, string $value): void {
    $pdo = getDB();
    $stmt = $pdo->prepare("INSERT INTO global_data (data_key, data_value) VALUES (?, ?)
        ON DUPLICATE KEY UPDATE data_value = VALUES(data_value)");
    $stmt->execute([$key, $value]);
}

/**
 * Carrega arquivos de migracao do diretorio migrations/
 * Cada arquivo retorna um array com: version, desc, run (callback)
 * Ordena por versao ascendente
 */
function loadMigrations(?string $migrationsDir = null): array {
    if ($migrationsDir === null) {
        $migrationsDir = __DIR__ . '/../migrations';
    }

    $migrations = [];

    if (!is_dir($migrationsDir)) {
        return $migrations;
    }

    $files = glob($migrationsDir . '/*.php');
    if ($files === false) {
        return $migrations;
    }

    foreach ($files as $file) {
        $migration = require $file;
        if (is_array($migration) && isset($migration['version'], $migration['desc'], $migration['run'])) {
            $migrations[] = $migration;
        }
    }

    // Ordenar por versao
    usort($migrations, function($a, $b) {
        return version_compare($a['version'], $b['version']);
    });

    return $migrations;
}

/**
 * Executa migracoes pendentes (versao > dbVersion)
 * Retorna array com resultados de cada migracao
 */
function runPendingMigrations(PDO $pdo, ?string $migrationsDir = null): array {
    $migrations = loadMigrations($migrationsDir);
    $dbVersion = getDbVersion($pdo);

    $pending = [];
    foreach ($migrations as $m) {
        if (version_compare($m['version'], $dbVersion, '>')) {
            $pending[] = $m;
        }
    }

    if (empty($pending)) {
        return ['ok' => true, 'msg' => 'Nenhuma migracao pendente.', 'results' => [], 'newVersion' => $dbVersion];
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
            error_log('Migration ' . $m['version'] . ' error: ' . $e->getMessage());
            break;
        } catch (Exception $e) {
            $result['ok'] = false;
            $result['msg'] = 'Erro: ' . $e->getMessage();
            $hasError = true;
            $results[] = $result;
            error_log('Migration ' . $m['version'] . ' error: ' . $e->getMessage());
            break;
        }

        $results[] = $result;
    }

    // Salvar versao alcancada
    if ($lastVersion !== $dbVersion) {
        setDbVersion($pdo, $lastVersion);
    }

    return [
        'ok' => !$hasError,
        'msg' => $hasError
            ? 'Migracao parou com erro na versao ' . end($results)['version'] . '.'
            : 'Migracoes executadas ate versao ' . $lastVersion . '.',
        'results' => $results,
        'newVersion' => $lastVersion,
        'previousVersion' => $dbVersion,
    ];
}

/**
 * Cria backup ZIP da instalacao atual antes de atualizar
 * Salva em sys_temp/backups/backup-vVERSAO-TIMESTAMP.zip
 * Mantem no maximo 5 backups (deleta os mais antigos)
 */
function createBackupZip(string $rootDir, string $currentVersion): array {
    $backupDir = $rootDir . DIRECTORY_SEPARATOR . 'sys_temp' . DIRECTORY_SEPARATOR . 'backups';

    if (!is_dir($backupDir)) {
        mkdir($backupDir, 0755, true);
    }

    $timestamp = date('Ymd-His');
    $safeVersion = preg_replace('/[^a-zA-Z0-9._-]/', '', $currentVersion);
    $zipName = 'backup-v' . $safeVersion . '-' . $timestamp . '.zip';
    $zipPath = $backupDir . DIRECTORY_SEPARATOR . $zipName;

    $zip = new ZipArchive();
    $result = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    if ($result !== true) {
        return ['ok' => false, 'msg' => 'Erro ao criar arquivo de backup.'];
    }

    $excludeDirPrefixes = [
        'uploads',
        'sys_temp',
        '.claude',
        '.git',
        'node_modules',
    ];

    $excludeFiles = [
        'config.php',
        'install.php',
    ];

    // Adicionar arquivos recursivamente
    $iterator = new RecursiveDirectoryIterator($rootDir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);

    foreach ($files as $file) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootDir) + 1);
        $relativePath = str_replace('\\', '/', $relativePath);

        // Verificar exclusoes de diretorio
        $skip = false;
        foreach ($excludeDirPrefixes as $prefix) {
            if (strpos($relativePath, $prefix) === 0) {
                $skip = true;
                break;
            }
        }
        if ($skip) continue;

        // Verificar arquivo excluido na raiz
        if ($file->isFile()) {
            $basename = basename($relativePath);
            $dirPart = dirname($relativePath);
            if ($dirPart === '.' && in_array($basename, $excludeFiles)) {
                continue;
            }
            $zip->addFile($filePath, $relativePath);
        } elseif ($file->isDir()) {
            $zip->addEmptyDir($relativePath);
        }
    }

    $fileCount = $zip->numFiles;
    $zip->close();

    if (!file_exists($zipPath)) {
        return ['ok' => false, 'msg' => 'Erro ao gerar backup ZIP.'];
    }

    // Limitar a 5 backups (remover mais antigos)
    $existingBackups = glob($backupDir . DIRECTORY_SEPARATOR . 'backup-v*.zip');
    if ($existingBackups !== false && count($existingBackups) > 5) {
        usort($existingBackups, function($a, $b) {
            return filemtime($a) - filemtime($b);
        });
        $toRemove = count($existingBackups) - 5;
        for ($i = 0; $i < $toRemove; $i++) {
            @unlink($existingBackups[$i]);
        }
    }

    return [
        'ok' => true,
        'path' => $zipPath,
        'file' => $zipName,
        'version' => $currentVersion,
        'size' => filesize($zipPath),
        'fileCount' => $fileCount,
    ];
}

/**
 * Busca dados de uma URL remota
 * Tenta cURL primeiro, fallback para file_get_contents
 */
function fetchRemoteData(string $url, int $timeout = 15, string $authToken = ''): array {
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return ['ok' => false, 'error' => 'URL invalida.'];
    }

    $scheme = parse_url($url, PHP_URL_SCHEME);
    if (!in_array($scheme, ['http', 'https'], true)) {
        return ['ok' => false, 'error' => 'Apenas URLs HTTP/HTTPS sao permitidas.'];
    }

    $userAgent = 'Induzi-Updater/' . (defined('INDUZI_VERSION') ? INDUZI_VERSION : '0.0.0');
    $headers = [];
    if ($authToken) {
        $headers[] = 'Authorization: Bearer ' . $authToken;
    }

    // Tentar cURL
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT => $userAgent,
        ]);
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $body = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($body === false) {
            return ['ok' => false, 'error' => 'Erro cURL: ' . $error];
        }

        if ($httpCode !== 200) {
            return ['ok' => false, 'error' => 'Servidor retornou HTTP ' . $httpCode];
        }

        return ['ok' => true, 'body' => $body];
    }

    // Fallback: file_get_contents
    if (ini_get('allow_url_fopen')) {
        $httpHeaders = "User-Agent: $userAgent\r\n";
        if ($authToken) {
            $httpHeaders .= "Authorization: Bearer $authToken\r\n";
        }

        $ctx = stream_context_create([
            'http' => [
                'timeout' => $timeout,
                'header' => $httpHeaders,
            ],
            'ssl' => [
                'verify_peer' => true,
            ],
        ]);

        $body = @file_get_contents($url, false, $ctx);

        if ($body === false) {
            return ['ok' => false, 'error' => 'Nao foi possivel acessar o servidor de atualizacoes.'];
        }

        return ['ok' => true, 'body' => $body];
    }

    return ['ok' => false, 'error' => 'Nenhum metodo HTTP disponivel (cURL ou allow_url_fopen).'];
}

/**
 * Baixa arquivo de URL remota para caminho local
 */
function downloadRemoteFile(string $url, string $destPath, int $timeout = 300, string $authToken = ''): array {
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return ['ok' => false, 'error' => 'URL de download invalida.'];
    }

    $scheme = parse_url($url, PHP_URL_SCHEME);
    if (!in_array($scheme, ['http', 'https'], true)) {
        return ['ok' => false, 'error' => 'Apenas URLs HTTP/HTTPS sao permitidas.'];
    }

    $dir = dirname($destPath);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $userAgent = 'Induzi-Updater/' . (defined('INDUZI_VERSION') ? INDUZI_VERSION : '0.0.0');
    $headers = [];
    if ($authToken) {
        $headers[] = 'Authorization: Bearer ' . $authToken;
        $headers[] = 'Accept: application/octet-stream';
    }

    // Tentar cURL
    if (function_exists('curl_init')) {
        $fp = fopen($destPath, 'wb');
        if (!$fp) {
            return ['ok' => false, 'error' => 'Nao foi possivel criar arquivo temporario.'];
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_FILE => $fp,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT => $userAgent,
        ]);
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $success = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        fclose($fp);

        if (!$success) {
            @unlink($destPath);
            return ['ok' => false, 'error' => 'Erro ao baixar: ' . $error];
        }

        if ($httpCode !== 200) {
            @unlink($destPath);
            return ['ok' => false, 'error' => 'Servidor retornou HTTP ' . $httpCode];
        }

        return ['ok' => true];
    }

    // Fallback: file_get_contents
    if (ini_get('allow_url_fopen')) {
        $httpHeaders = "User-Agent: $userAgent\r\n";
        if ($authToken) {
            $httpHeaders .= "Authorization: Bearer $authToken\r\n";
            $httpHeaders .= "Accept: application/octet-stream\r\n";
        }

        $ctx = stream_context_create([
            'http' => [
                'timeout' => $timeout,
                'header' => $httpHeaders,
            ],
            'ssl' => [
                'verify_peer' => true,
            ],
        ]);

        $data = @file_get_contents($url, false, $ctx);
        if ($data === false) {
            return ['ok' => false, 'error' => 'Nao foi possivel baixar o arquivo.'];
        }

        if (file_put_contents($destPath, $data) === false) {
            return ['ok' => false, 'error' => 'Nao foi possivel salvar o arquivo.'];
        }

        return ['ok' => true];
    }

    return ['ok' => false, 'error' => 'Nenhum metodo HTTP disponivel (cURL ou allow_url_fopen).'];
}
