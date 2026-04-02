<?php
/**
 * Funcoes helper globais — INDUZI
 * Compatibility layer for existing views.
 * Works with both old MVC and new Igris-style backend.
 */

/**
 * Gera campo hidden com CSRF token.
 */
function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . ($_SESSION['csrf_token'] ?? '') . '">';
}

/**
 * Retorna o CSRF token atual.
 */
function csrf_token(): string
{
    return $_SESSION['csrf_token'] ?? '';
}

/**
 * Escapa string para output HTML seguro.
 * (only define if not already defined by includes/helpers.php)
 */
if (!function_exists('e')) {
    function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Gera URL absoluta.
 */
function url(string $path = ''): string
{
    $base = defined('BASE_URL') ? BASE_URL : '/Site';
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}

/**
 * Gera URL para asset publico.
 */
function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

/**
 * Retorna mensagem flash da sessao.
 */
function flash(string $key): mixed
{
    $flashKey = 'flash_' . $key;
    if (isset($_SESSION[$flashKey])) {
        $value = $_SESSION[$flashKey];
        unset($_SESSION[$flashKey]);
        return $value;
    }
    return null;
}

/**
 * Retorna dados do usuario logado.
 */
function auth(): ?array
{
    return $_SESSION['induzi_user'] ?? null;
}

/**
 * Verifica se usuario esta logado.
 */
function is_logged_in(): bool
{
    return !empty($_SESSION['induzi_user']['userId']);
}

/**
 * Redireciona para URL.
 */
function redirect(string $url, int $status = 302): void
{
    http_response_code($status);
    header("Location: $url");
    exit;
}

/**
 * Retorna metodo HTTP do formulario (suporta _method).
 */
function method_field(string $method): string
{
    return '<input type="hidden" name="_method" value="' . strtoupper($method) . '">';
}

/**
 * Debug dump e die.
 */
function dd(mixed ...$vars): void
{
    $debug = defined('APP_DEBUG') ? APP_DEBUG : false;
    if (!$debug) return;
    echo '<pre style="background:#111;color:#4ade80;padding:20px;margin:10px;border-radius:8px;font-family:monospace;font-size:13px;overflow:auto;">';
    foreach ($vars as $var) {
        var_dump($var);
        echo "\n";
    }
    echo '</pre>';
    exit;
}

/**
 * Formata data para exibicao BR.
 */
function format_date(string $date, string $format = 'd/m/Y H:i'): string
{
    return date($format, strtotime($date));
}
