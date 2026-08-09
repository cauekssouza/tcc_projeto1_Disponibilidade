<?php
// Garante que a sessão só será iniciada se ainda não estiver ativa
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Limpa todos os dados da sessão em memória
$_SESSION = [];

// Força a gravação de dados pendentes e evita corrupção
session_write_close();

// Remove o cookie de sessão no navegador, garantindo que não possa ser reutilizado
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    // Define o cookie como expirado
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

// Reinicia a sessão apenas para destruir corretamente no servidor
session_start();

// Regenera o ID para evitar reutilização ou fixação de sessão
session_regenerate_id(true);

// Destrói a sessão no servidor
session_destroy();

// Redireciona para a página de login
header("Location: login.php");
exit;
?>
