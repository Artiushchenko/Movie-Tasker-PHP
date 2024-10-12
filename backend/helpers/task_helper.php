<?php
function getTasks($connection) {
    $tasks = [];
    $user_email = $_SESSION['user'];

    $stmt = $connection->prepare('
		SELECT
		    `tasks`.*, GROUP_CONCAT(`task_tag`.`tag_id`) AS tag_ids 
        FROM `tasks`
            LEFT JOIN `task_tag` ON `tasks`.`id` = `task_tag`.`task_id` 
        WHERE `tasks`.`user_email` = ? AND `tasks`.`is_completed` = 0
        GROUP BY `tasks`.`id`;
	');
    $stmt->bind_param('s', $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    $stmt->close();
    return $tasks;
}

function getTagTitle($connection, $tag_id) {
    $stmt = $connection->prepare('
        SELECT 
            `tags`.`title` 
        FROM `tags` 
        WHERE `tags`.`id` = ?;
    ');
    $stmt->bind_param('i', $tag_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $stmt->close();
        return $row['title'];
    }

    $stmt->close();
    return null;
}

function convertTimeToHoursMinutes($totalMinutes)
{
    $hours = floor($totalMinutes / 60);
    $minutes = $totalMinutes % 60;
    return "$hours Hours $minutes Minutes";
}