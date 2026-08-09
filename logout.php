<?php

// Initialize/resume the current session.
session_start();

// Prevent caching of authenticated/protected content.
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Remove all session variables from memory.
session_unset();
$_SESSION = [];

// Remove the session cookie from the browser using the
// same parameters with which it was originally created.
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(), // PHPSESSID by default
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

// Destroy the server-side session.
session_destroy();

// Redirect to the login page and terminate execution.
header('Location: login.php', true, 302);
exit();
