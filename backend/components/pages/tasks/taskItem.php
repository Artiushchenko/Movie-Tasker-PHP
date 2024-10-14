<?php
function renderTaskItem($task, $connection)
{
    $completedClass = $task['is_completed'] === 1 ? 'completed' : '';
	?>
	<div class="task-item <?= $completedClass ?>">
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

			<div class="task-buttons-container">
				<?php if ($task['is_completed'] === 0): ?>
					<button
						type="button"
						onclick='openEditModal(<?= json_encode($task) ?>)'
						class="task-edit-button"
					>
						Edit
					</button>
				<?php endif; ?>

				<form method="POST" action="../../../handlers/toggle_task_status.php">
					<input type="hidden" name="task_id" value="<?= htmlspecialchars($task['id']) ?>">
					<input type="hidden" name="action" value="toggle">
					<button type="submit">Done</button>
				</form>

				<button
					type="button"
					onclick="openDeleteModal(<?= htmlspecialchars($task['id']) ?>)"
					class="task-delete-button"
				>
					Remove
				</button>
			</div>
		</div>
	</div>
    <?php
}