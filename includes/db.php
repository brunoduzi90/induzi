<?php
/**
 * Induzi — Conexao PDO MySQL
 */
$configPath = dirname(__DIR__) . '/config.php';
if (!file_exists($configPath)) {
    if (strpos($_SERVER['REQUEST_URI'] ?? '', '/api/') !== false) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(503);
        echo json_encode(['ok' => false, 'msg' => 'Sistema nao configurado. Execute o instalador.']);
        exit;
    }
    header('Location: install.php');
    exit;
}
require_once $configPath;

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $charset = defined('DB_CHARSET') ? DB_CHARSET : 'utf8mb4';
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=$charset";
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }
    return $pdo;
}
