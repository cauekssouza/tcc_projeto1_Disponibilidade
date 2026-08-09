<?php
declare(strict_types=1);

// Garante que nada foi enviado antes dos headers
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Remove todos os dados da sessão
$_SESSION = [];

// Remove o cookie da sessão (boa prática de segurança)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Destrói a sessão
session_destroy();

// Redireciona de forma segura
header("Location: login.php", true, 302);
exit;
