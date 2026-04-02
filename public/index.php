<?php
/**
 * Front Controller — INDUZI Public Site
 * Simplified: uses includes/ instead of MVC.
 */

// Path constants
define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);
define('BASE_URL', '/Site');
define('APP_NAME', 'INDUZI — Design Autoral & Arquitetura de Interiores');
define('APP_DEBUG', false);

// Load Igris-style core
require_once ROOT_PATH . '/config.php';
require_once ROOT_PATH . '/includes/db.php';
require_once ROOT_PATH . '/includes/helpers.php';

// Start session for CSRF/flash messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Load public helpers (compatibility layer for existing views)
require_once ROOT_PATH . '/app/Helpers/functions.php';

// Handle contact form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = str_replace(BASE_URL . '/', '', $uri);
    $path = trim($path, '/');

    if ($path === 'contato' || $path === 'contact') {
        handleContactForm();
    }
}

// Route to public page
require_once ROOT_PATH . '/includes/public-router.php';
publicRoute();

/**
 * Handle contact form submission
 */
function handleContactForm(): void {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $errors = [];
    if (strlen($name) < 2) $errors['name'] = ['Nome deve ter pelo menos 2 caracteres.'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = ['Email invalido.'];
    if (empty($subject)) $errors['subject'] = ['Selecione um tipo de projeto.'];
    if (strlen($message) < 10) $errors['message'] = ['Mensagem deve ter pelo menos 10 caracteres.'];

    if (!empty($errors)) {
        $_SESSION['flash_errors'] = $errors;
        $_SESSION['flash_old'] = $_POST;
        $_SESSION['flash_error'] = 'Por favor, corrija os erros no formulario.';
        header('Location: ' . BASE_URL . '/contato');
        exit;
    }

    try {
        $db = getDB();
        $stmt = $db->prepare('INSERT INTO mensagens (nome, email, telefone, assunto, mensagem) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$name, $email, $_POST['phone'] ?? '', $subject, $message]);
        $_SESSION['flash_success'] = 'Mensagem enviada com sucesso! Entraremos em contato em breve.';
    } catch (Exception $e) {
        $_SESSION['flash_error'] = 'Erro ao enviar mensagem. Tente novamente.';
    }

    header('Location: ' . BASE_URL . '/contato');
    exit;
}
