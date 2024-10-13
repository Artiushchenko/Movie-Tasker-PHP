<?php
require_once 'handlers/connection.php';
require_once 'components/pages/tasks/taskItem.php';
require_once 'helpers/task_helper.php';

$tasks = getTasks($connection);
?>

<style>
	@import '../../../styles/pages/tasks/tasks.css';
</style>

<section>
	<div class="tasks-header">
		<h1>Tasks</h1>
	</div>

    <?php if (empty($tasks)): ?>
		<div class="no-tasks">
			<h1>No tasks available yet</h1>
		</div>
    <?php else: ?>
		<div class="task-list">
            <?php foreach ($tasks as $task): ?>
                <?php renderTaskItem($task, $connection); ?>
            <?php endforeach; ?>
		</div>
    <?php endif; ?>

    <?php include 'components/ui/editModalWindow/editModalWindow.php' ?>
    <?php include 'components/ui/confirmDeleteModalWindow/confirmDeleteModalWindow.php' ?>
</section>

<script src="../../../js/editModal/editModal.js"></script>
<script src="../../../js/confirmDeleteModal/confirmDeleteModal.js"></script>