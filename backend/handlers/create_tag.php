<?php
session_start();

require_once '../dto/tag.php';
require_once './connection.php';

function createNewTag($connection, $tagDTO) {
    $stmt = $connection->prepare("INSERT INTO tags (title, user_email) VALUES (?, ?)");
    $stmt->bind_param("ss", $tagDTO->title, $tagDTO->user_email);

    if($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $tagTitle = $_POST["tagTitle"];
    $user_email = $_SESSION["user"];

    $tagDTO = new Tag($tagTitle, $user_email);

    if(createNewTag($connection, $tagDTO)) {
        header("Location: /");
        exit();
    }
}