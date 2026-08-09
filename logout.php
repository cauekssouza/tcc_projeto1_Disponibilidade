<?php
// Garante que não haja saída antes dos headers
ob_start();

// Força uso de cookies para evitar sessões híbridas (cookie + URL)
ini_set('session.use_only_cookies', 1);

// Recupera parâmetros do cookie da sessão
$cookieParams = session_get_cookie_params();

// Inicia a sessão apenas se ainda não estiver ativa
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Limpa dados da sessão no servidor
$_SESSION = [];

// Regenera ID para evitar reutilização de sessão destruída
session_regenerate_id(true);

// Remove o cookie da sessão no navegador
setcookie(
    session_name(),
    '',
    [
        'expires'  => time() - 42000,
        'path'     => $cookieParams['path'],
        'domain'   => $cookieParams['domain'],
        'secure'   => $cookieParams['secure'],
        'httponly' => $cookieParams['httponly'],
        'samesite' => $cookieParams['samesite'] ?? 'Lax'
    ]
);

// Destrói a sessão no servidor
session_destroy();

// Finaliza buffer e envia headers
ob_end_flush();

// Redireciona para login
header("Location: login.php");
exit;
?>
