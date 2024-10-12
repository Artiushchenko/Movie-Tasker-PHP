<?php
require_once './connection.php';

function toggleTaskStatus($connection, $task_id)
{
    $stmt = $connection->prepare("SELECT is_completed FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $current_status = $row['is_completed'];
        $newStatus = $current_status ? 0 : 1;

        $stmt = $connection->prepare("UPDATE tasks SET is_completed = ? WHERE id = ?");
        $stmt->bind_param("ii", $newStatus, $task_id);
        $stmt->execute();
        $stmt->close();

        return true;
    }

    $stmt->close();
    return false;
}

if (isset($_POST['task_id'])) {
    $task_id = intval($_POST['task_id']);
    if (toggleTaskStatus($connection, $task_id)) {
        header("Location: /tasks");
        exit;
    }
}