<?php
// Garante que não haja saída antes dos headers
ob_start();

// Inicia a sessão somente se ainda não estiver ativa
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Limpa todos os dados da sessão
$_SESSION = [];

// Força a gravação e liberação do armazenamento da sessão
session_write_close();

// Remove o cookie de sessão no navegador, se existir
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        [
            'expires'  => time() - 42000,
            'path'     => $params['path'],
            'domain'   => $params['domain'],
            'secure'   => $params['secure'],
            'httponly' => $params['httponly'],
            'samesite' => $params['samesite'] ?? 'Lax'
        ]
    );
}

// Destrói a sessão no servidor
session_destroy();

// Garante que um novo ID seja gerado na próxima sessão
session_regenerate_id(true);

// Redireciona para a página de login
header("Location: login.php");
exit;
?>
