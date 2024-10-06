<?php
session_start();

require_once './connection.php';

session_destroy();

if (isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];

    if($connection) {
        $stmt = $connection->prepare("UPDATE users SET remember_token = NULL, token_expires = NULL WHERE remember_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
    }

    setcookie('remember_me', '', time() - 3600, '/login');
}

header('Location: /login');
exit();