<?php
require_once './connection.php';

if (isset($_POST['task_id'])) {
    $task_id = intval($_POST['task_id']);

    $stmt = $connection->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $stmt->close();

    header("Location: /tasks");
    exit;
}