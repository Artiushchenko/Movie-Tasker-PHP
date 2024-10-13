<?php
session_start();

require_once './connection.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskTitle = $_POST['taskTitle'] ?? '';
    $taskDescription = $_POST['taskDescription'] ?? '';
    $taskCategory = $_POST['taskCategory'] ?? '';
    $tags = $_POST['tags'] ?? [];
    $user_email = $_SESSION['user'];

    $is_completed = 0;
    $time = null;

    if($taskCategory === 'Film') {
        $hours = $_POST['filmHours'] ?? 0;
        $minutes = $_POST['filmMinutes'] ?? 0;
        $time = $hours * 60 + $minutes;
    } elseif($taskCategory === 'Serial') {
        $seasons = $_POST['serialSeasons'] ?? 0;
        $series = $_POST['serialSeries'] ?? 0;
        $seriesMinutes = $_POST['serialSeriesMinutes'] ?? 0;
        $time = $seasons * $series * $seriesMinutes;
    }

    $stmt = $connection->prepare('
        INSERT INTO 
            tasks (title, description, category, is_completed, time, user_email)
        VALUES (?, ?, ?, ?, ?, ?);
    ');
    $stmt->bind_param('sssiis', $taskTitle, $taskDescription, $taskCategory, $is_completed, $time, $user_email);

    if($stmt->execute()) {
        $task_id = $stmt->insert_id;

        if(!empty($tags)) {
            $stmt_tags = $connection->prepare('
                INSERT INTO 
                    task_tag (task_id, tag_id) 
                VALUES (?, ?);
            ');

            foreach ($tags as $tag_id) {
                $stmt_tags->bind_param('ii', $task_id, $tag_id);
                $stmt_tags->execute();
            }

            $stmt_tags->close();
        }
    }

    $stmt->close();
    header('location: /tasks');
    exit();
}