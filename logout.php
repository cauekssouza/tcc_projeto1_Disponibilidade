<?php
// Garante que não haja saída antes dos headers
ob_start();

// Inicia a sessão apenas se ainda não estiver ativa
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Limpa variáveis da sessão
$_SESSION = [];

// Remove o cookie de sessão no navegador
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    // Define o cookie como expirado e com os mesmos parâmetros originais
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destrói a sessão no servidor
session_destroy();

// Garante que o buffer seja limpo e evita travamentos por flush incorreto
ob_end_clean();

// Redireciona para a página de login
header("Location: login.php");
exit;
?>
