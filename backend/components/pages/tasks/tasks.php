<?php
require_once 'handlers/connection.php';

function getTasks($connection)
{
    $tasks = [];
    $user_email = $_SESSION['user'];

    $stmt = $connection->prepare("
		SELECT t.*, GROUP_CONCAT(tt.tag_id) AS tag_ids FROM tasks t
		LEFT JOIN task_tag tt ON t.id = tt.task_id 
		WHERE t.user_email = ?
		GROUP BY t.id
	");
	$stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    $stmt->close();
    return $tasks;
}

$tasks = getTasks($connection);

function getTagTitle($connection, $tag_id) {
	$stmt = $connection->prepare("SELECT title FROM tags WHERE id = ?");
	$stmt->bind_param("i", $tag_id);
	$stmt->execute();
	$result = $stmt->get_result();

	if($row = $result->fetch_assoc()) {
		$stmt->close();
		return $row['title'];
	}

    $stmt->close();
    return null;
}

function convertTimeToHoursMinutes($totalMinutes) {
    $hours = floor($totalMinutes / 60);
    $minutes = $totalMinutes % 60;
    return "$hours Hours $minutes Minutes";
}
?>

<section>
	<div class="tasks-header">
		<h1>Tasks</h1>

		<!-- Здесь будет компонент фильтра -->
		<!--        --><?php //include('./components/base/FilterList.php'); ?>
	</div>

    <?php if (empty($tasks)): ?>
		<div class="no-tasks">
			<h1>No tasks available yet</h1>
		</div>
    <?php else: ?>
		<div class="task-list">
            <?php foreach ($tasks as $task): ?>
				<div class="task-item">
					<div class="item-header">
						<div class="item-stats">
							<span class="item-label"><?= htmlspecialchars($task['category']) ?></span>
							<span>
					            <strong>Total Time:</strong> <?= convertTimeToHoursMinutes(htmlspecialchars($task['time'])) ?>
				            </span>
						</div>
					</div>

					<div class="item-content">
						<h1><?= htmlspecialchars($task['title']) ?></h1>
						<p><?= htmlspecialchars($task['description']) ?></p>

						<div class="tag-list">
							<div class="tag-wrapper">
                                <?php
                                if (!empty($task['tag_ids'])) {
                                    $tag_ids = explode(",", $task['tag_ids']);

                                    foreach ($tag_ids as $tag_id) {
                                        $tag_title = getTagTitle($connection, $tag_id);

                                        if ($tag_title) {
                                            echo '<div class="tag"><span>' . htmlspecialchars($tag_title) . '</span></div>';
                                        }
                                    }
                                }
                                ?>
							</div>
						</div>
					</div>
				</div>
            <?php endforeach; ?>
		</div>
    <?php endif; ?>

	<!-- Пагинация -->
	<!--    --><?php //include('./components/base/Pagination.php'); ?>

	<!-- Модальное окно редактирования задачи -->
	<!--    --><?php //include('./components/base/TaskEditModal.php'); ?>
</section>
