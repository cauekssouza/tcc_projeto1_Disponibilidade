<?php
// Garante que a sessão só é iniciada se ainda não existir
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Limpa variáveis da sessão
$_SESSION = [];

// Remove dados persistidos no servidor (se existirem)
if (ini_get("session.use_strict_mode")) {
    // Em strict mode, o PHP já evita reutilização de IDs, mas ainda assim limpamos
}
session_regenerate_id(true); // Invalida o ID atual e gera um novo

// Remove o cookie da sessão no navegador
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        [
            'expires'  => time() - 42000, // expira imediatamente
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

// Evita qualquer saída antes do redirect
ob_clean();

// Redireciona para a página de login
header("Location: login.php", true, 302);
exit;
?>
