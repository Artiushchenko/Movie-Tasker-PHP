<?php
require_once 'handlers/connection.php';
require_once 'faker/faker.php';

$users = [];

$result = $connection->query('SELECT `users`.`email` FROM `users`;');

while($row = $result->fetch_assoc()) {
    array_push($users, $row['email']);
}

$tasksFaker = new TasksFaker($users);

function insertTasks($connection, $taskData) {
    $stmt = $connection->prepare('
        INSERT INTO `tasks` (`category`, `is_completed`, `description`, `time`, `title`, `user_email`) 
        VALUES (?, ?, ?, ?, ?, ?);
    ');
    $stmt->bind_param(
        'sisiss',
        $taskData['category'],
        $taskData['is_completed'],
        $taskData['description'],
        $taskData['time'],
        $taskData['title'],
        $taskData['user_email']
    );

    if(!$stmt->execute()) {
        throw new Error('Error: ' . $stmt->error);
    }

    $stmt->close();
}

$taskCount = 1000;

for($i = 0; $i < $taskCount; $i++) {
    $taskData = $tasksFaker->generateData();
    insertTasks($connection, $taskData);
}

mysqli_close($connection);