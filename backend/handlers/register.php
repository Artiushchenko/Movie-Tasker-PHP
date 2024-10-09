<?php
session_start();

require_once '../dto/user.php';
require_once './connection.php';
require_once '../validation/validation.php';

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION['errors'] = [];

    if(!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']){
        $_SESSION['errors']['general'] = 'Invalid CSRF token';
        header('Location: /register');
        exit();
    }

    unset($_SESSION['csrf_token']);

    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    $emailValidator = new Validator('email');
    if(!$emailValidator->validate($email)){
        $_SESSION['errors']['email'] = "Incorrect e-mail format";
        header('Location: /register');
        exit();
    }

    $emailValidatorInstance = new EmailValidator();
    if(!$emailValidatorInstance->isUnique($email, $connection)){
        $_SESSION['errors']['email'] = "Current e-mail is already in use.";
        header('Location: /register');
        exit();
    }

    $passwordValidator = new Validator('password');
    if(!$passwordValidator->validate($password)){
        $_SESSION['errors']['password'] = "Password must be at least 6 characters";
        header('Location: /register');
        exit();
    }

    $passwordValidatorInstance = new PasswordValidator();
    if(!$passwordValidatorInstance->confirm($password, $confirm_password)){
        $_SESSION['errors']['confirm_password'] = "Password does not match";
        header('Location: /register');
        exit();
    }

    $userDTO = new UserDTO($email, password_hash($password, PASSWORD_DEFAULT));

    if(registerUser($userDTO, $connection)) {
        $_SESSION['user'] = $userDTO->email;
        header('Location: /');
        exit();
    } else {
        header('Location: /404');
        exit();
    }
}

function registerUser($userDTO, $connection) {
    $checkQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $connection->prepare($checkQuery);
    $stmt->bind_param("s", $userDTO->email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        return false;
    }

    $registerQuery = "INSERT INTO users (email, password) VALUES (?, ?)";
    $stmt = $connection->prepare($registerQuery);
    $stmt->bind_param("ss", $userDTO->email, $userDTO->password);

    if($stmt->execute()) {
        $stmt->close();
        $connection->close();
        return true;
    } else {
        $stmt->close();
        $connection->close();
        return false;
    }
}