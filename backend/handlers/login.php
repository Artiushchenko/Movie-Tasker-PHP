<?php
session_start();

require_once '../dto/user.php';
require_once './connection.php';

function setRememberMeCookies($token, $email, $expiration) {
    setcookie('remember_me', $token, $expiration, '/login');
    setcookie('remember_email', $email, $expiration, '/login');
}

function clearRememberMeCookies() {
    setcookie('remember_me', '', time() - 3600, '/login');
    setcookie('remember_email', '', time() - 3600, '/login');
}

function handleRememberMe($rememberMe, $email, $connection) {
    if ($rememberMe) {
        $token = bin2hex(random_bytes(32));
        $expiration = time() + (86400 * 30);

        $stmt = $connection->prepare("UPDATE users SET remember_token = ?, token_expires = ? WHERE email = ?");
        $stmt->bind_param("sis", $token, $expiration, $email);
        $stmt->execute();

        setRememberMeCookies($token, $email, $expiration);
    } else {
        clearRememberMeCookies();
    }
}

if (!isset($_SESSION['user']) && isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];
    $currentTime = time();

    $stmt = $connection->prepare("SELECT email FROM users WHERE remember_token = ? AND token_expires > ?");
    $stmt->bind_param("si", $token, $currentTime);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user['email'];
        header('Location: /');
        exit();
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $password = $_POST["password"];
    $rememberMe = isset($_POST["remember"]);

    $userDTO = loginUser($email, $password, $connection);

    if($userDTO) {
        $_SESSION['user'] = $userDTO->email;
        handleRememberMe($rememberMe, $email, $connection);
        header('Location: /');
        exit();
    } else {
        header('Location: /404');
        exit();
    }
}

function loginUser($email, $password, $connection) {
    $loginQuery = "SELECT * FROM users WHERE email = ?";

    $stmt = $connection->prepare($loginQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])) {
            return new UserDTO($user['email'], $user['password']);
        }
    }

    clearRememberMeCookies();
    return false;
}