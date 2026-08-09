<?php
// Inicializa/acessa a sessão existente.
session_start();

// Impede armazenamento em cache da resposta de logout.
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Remove todas as variáveis da sessão em memória.
session_unset();
$_SESSION = [];

// Remove o cookie de sessão do navegador utilizando
// os mesmos parâmetros com os quais ele foi configurado.
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(), // Normalmente PHPSESSID
        '',
        [
            'expires'  => time() - 42000,
            'path'     => $params['path'],
            'domain'   => $params['domain'],
            'secure'   => $params['secure'],
            'httponly' => $params['httponly'],
            'samesite' => $params['samesite'] ?? 'Lax',
        ]
    );
}

// Destrói os dados da sessão no servidor.
session_destroy();

// Redireciona para a página de login.
header('Location: login.php');
exit();
?>
