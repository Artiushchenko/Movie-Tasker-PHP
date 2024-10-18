<?php
session_start();

require_once '../dto/tag.php';
require_once './connection.php';
require_once '../validation/validation.php';

function createNewTag($connection, $tagDTO) {
    $stmt = $connection->prepare('INSERT INTO tags (title, user_email) VALUES (?, ?)');
    $stmt->bind_param('ss', $tagDTO->title, $tagDTO->user_email);

    if($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['errors'] = [];

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['errors']['general'] = 'Invalid CSRF token';
        header('Location: /tag-manage');
        exit();
    }

    unset($_SESSION['csrf_token']);

    $tagTitle = $_POST['tagTitle'];
    $user_email = $_SESSION['user'];

    $tagNameValidator = new Validator('tag-name');

    if(!$tagNameValidator->validate($tagTitle)) {
        $_SESSION['errors']['create-tag-title'] = 'Tag title cannot be empty';
        header('Location: /tag-manage');
        exit();
    }

    $tagDTO = new Tag($tagTitle, $user_email);

    if(createNewTag($connection, $tagDTO)) {
        header('Location: /');
        exit();
    }
}