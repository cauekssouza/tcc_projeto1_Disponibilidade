<?php

// Inicia a sessão para permitir sua invalidação completa.
session_start();

// Impede o armazenamento em cache de conteúdo autenticado.
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Remove todas as variáveis armazenadas na sessão.
session_unset();

// Remove também qualquer referência restante no array de sessão.
$_SESSION = [];

// Remove o cookie de sessão do navegador utilizando os mesmos
// parâmetros com os quais ele foi originalmente configurado.
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),          // Normalmente PHPSESSID
        '',
        time() - 42000,          // Data de expiração no passado
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Invalida a sessão no armazenamento do servidor.
session_destroy();

// Redireciona para a página de login.
header('Location: login.php');
exit();
?>
