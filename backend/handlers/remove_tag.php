<?php
session_start();

require_once './connection.php';
require_once '../validation/validation.php';

function deleteTag($connection, $tagTitle, $user_email) {
    $stmt = $connection->prepare('
        DELETE FROM tags 
        WHERE title = ? AND user_email = ?
    ');
    $stmt->bind_param('ss', $tagTitle, $user_email);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['errors'] = [];

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['errors']['general'] = 'Invalid CSRF token';
        header('Location: /tag-manage');
        exit();
    }

    unset($_SESSION['csrf_token']);

    $tagTitle = $_POST['tagName'];
    $user_email = $_SESSION['user'];

    $tagNameValidator = new Validator('tag-name');

    if(!$tagNameValidator->validate($tagTitle)) {
        $_SESSION['errors']['remove-tag-title'] = 'Tag title cannot be empty';
        header('Location: /tag-manage');
        exit();
    }

    deleteTag($connection, $tagTitle, $user_email);

    header('Location: /');
    exit();
}