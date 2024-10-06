<?php
session_start();

require_once '../dto/user.php';
require_once './connection.php';

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

//    Обработка ошибок
//    if($password !== $confirm_password) {
//        exit();
//    }

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

//    Проверка на существование пользователя
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