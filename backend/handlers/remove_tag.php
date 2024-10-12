<?php
session_start();

require_once './connection.php';

function deleteTag($connection, $tagTitle, $user_email) {
    $stmt = $connection->prepare("DELETE FROM tags WHERE title = ? AND user_email = ?");
    $stmt->bind_param("ss", $tagTitle, $user_email);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tagTitle = $_POST["tagName"];
    $user_email = $_SESSION["user"];

    deleteTag($connection, $tagTitle, $user_email);

    header("Location: /");
    exit();
}