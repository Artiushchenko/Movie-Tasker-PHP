<?php
function getTasks($connection, $offset, $itemsPerPage, $filter, $searchQuery = '') {
    $tasks = [];
    $user_email = $_SESSION['user'];

    $query = '
		SELECT
		    `tasks`.*, GROUP_CONCAT(`task_tag`.`tag_id`) AS tag_ids 
        FROM `tasks`
            LEFT JOIN `task_tag` ON `tasks`.`id` = `task_tag`.`task_id` 
        WHERE `tasks`.`user_email` = ? AND `tasks`.`is_completed` = ?
	';

    if(!empty($searchQuery)) {
        $query .= ' AND `tasks`.`title` LIKE ?';
    }

    $query .= ' GROUP BY `tasks`.`id` LIMIT ?, ?';

    $stmt = $connection->prepare($query);
    $is_completed = ($filter === 'completed') ? 1 : 0;

    if(!empty($searchQuery)) {
        $searchTerm = '%' . $searchQuery . '%';
        $stmt->bind_param('sisii', $user_email, $is_completed, $searchTerm, $offset, $itemsPerPage);
    } else {
        $stmt->bind_param('siii', $user_email, $is_completed, $offset, $itemsPerPage);
    }

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

function getTotalTasksCount($connection, $user_email) {
    $totalTaskQuery = '
        SELECT 
            COUNT(*) AS total 
        FROM `tasks` 
        WHERE `tasks`.`user_email` = ?;
    ';

    $stmt = $connection->prepare($totalTaskQuery);
    $stmt->bind_param('s', $user_email);
    $stmt->execute();
    $totalItems = $stmt->get_result()->fetch_assoc()['total'];
    $stmt->close();

    return $totalItems;
}

function getCurrentPageAndItemsPerPage() {
    $currentPage = $_GET['page'] ?? 1;
    $itemsPerPage = 5;

    return [$currentPage, $itemsPerPage];
}