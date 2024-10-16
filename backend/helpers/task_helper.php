<?php
function buildTaskQuery($user_email, $is_completed, $searchQuery, $taskDate, $sortOrder = null) {
    $query = '
        SELECT
            `tasks`.*, GROUP_CONCAT(`task_tag`.`tag_id`) AS tag_ids 
        FROM `tasks`
            LEFT JOIN `task_tag` ON `tasks`.`id` = `task_tag`.`task_id` 
        WHERE `tasks`.`user_email` = ? AND `tasks`.`is_completed` = ?
    ';

    if (!empty($searchQuery)) {
        $query .= ' AND `tasks`.`title` LIKE ?';
    }

    if (!empty($taskDate)) {
        $query .= ' AND DATE(`tasks`.`created_at`) = ?';
    }

    $query .= ' GROUP BY `tasks`.`id`';

    if ($sortOrder === 'asc') {
        $query .= ' ORDER BY `tasks`.`title` ASC';
    } elseif ($sortOrder === 'desc') {
        $query .= ' ORDER BY `tasks`.`title` DESC';
    }

    $query .= ' LIMIT ?, ?';

    return $query;
}

function executeTaskQuery($connection, $query, $params) {
    $stmt = $connection->prepare($query);
    $stmt->bind_param(...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    $stmt->close();
    return $tasks;
}

function getTasks($connection, $offset, $itemsPerPage, $filter, $searchQuery = '', $taskDate = null, $sortOrder = null) {
    $user_email = $_SESSION['user'];
    $is_completed = ($filter === 'completed') ? 1 : 0;

    $query = buildTaskQuery($user_email, $is_completed, $searchQuery, $taskDate, $sortOrder);

    $params = [$user_email, $is_completed];

    if (!empty($searchQuery)) {
        $params[] = '%' . $searchQuery . '%';
    }

    if (!empty($taskDate)) {
        $params[] = $taskDate;
    }

    $params[] = $offset;
    $params[] = $itemsPerPage;

    $types = 'si';
    if (!empty($searchQuery)) {
        $types .= 's';
    }
    if (!empty($taskDate)) {
        $types .= 's';
    }
    $types .= 'ii';

    array_unshift($params, $types);
    return executeTaskQuery($connection, $query, $params);
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

function getFilteredTasksCount($connection, $user_email, $filter, $searchQuery = '', $taskDate = null) {
    $is_completed = ($filter === 'completed') ? 1 : 0;
    $query = '
        SELECT COUNT(*) AS total 
        FROM `tasks` 
        WHERE `tasks`.`user_email` = ? AND `tasks`.`is_completed` = ?
    ';

    if (!empty($searchQuery)) {
        $query .= ' AND `tasks`.`title` LIKE ?';
    }

    if (!empty($taskDate)) {
        $query .= ' AND DATE(`tasks`.`created_at`) = ?';
    }

    $stmt = $connection->prepare($query);
    $params = [$user_email, $is_completed];

    if (!empty($searchQuery)) {
        $params[] = '%' . $searchQuery . '%';
    }

    if (!empty($taskDate)) {
        $params[] = $taskDate;
    }

    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    $stmt->execute();
    $totalItems = $stmt->get_result()->fetch_assoc()['total'];
    $stmt->close();

    return $totalItems;
}

function resetTaskFilters() {
    unset($_POST['filter'], $_POST['search_query'], $_POST['task_date'], $_POST['is_completed'], $_POST['sort_order']);
}