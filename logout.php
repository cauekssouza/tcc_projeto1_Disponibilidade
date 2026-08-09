<?php

// Inicializa/resume a sessão existente
session_start();

// Impede o armazenamento em cache da resposta de logout
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Remove todas as variáveis registradas na sessão
session_unset();
$_SESSION = [];

// Remove explicitamente o cookie de sessão do navegador
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),      // Normalmente PHPSESSID
        '',
        time() - 42000,      // Expiração no passado
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Destrói os dados da sessão mantidos no servidor
session_destroy();

// Redireciona para a página de autenticação
header('Location: login.php');
exit();
