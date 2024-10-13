<?php
require_once './connection.php';

if (isset($_POST['task_id'], $_POST['title'], $_POST['description'])) {
    $task_id = $_POST['task_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $stmt = $connection->prepare('
        UPDATE tasks 
        SET title = ?, description = ? 
        WHERE id = ?
    ');
    $stmt->bind_param('ssi', $title, $description, $task_id);
    $stmt->execute();
    $stmt->close();

    header('Location: /tasks');
    exit();
}