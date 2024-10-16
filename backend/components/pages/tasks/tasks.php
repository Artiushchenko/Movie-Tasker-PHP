<?php
require_once 'handlers/connection.php';
require_once 'components/pages/tasks/taskItem.php';
require_once 'helpers/task_helper.php';

list($currentPage, $itemsPerPage) = getCurrentPageAndItemsPerPage();

$totalItems = getTotalTasksCount($connection, $_SESSION['user']);

if (isset($_POST['reset_filters'])) {
    resetTaskFilters();
}

$filter = $_POST['filter'] ?? 'active';
$searchQuery = $_POST['search_query'] ?? '';
$taskDate = $_POST['task_date'] ?? null;
$sortOrder = $_POST['sort_order'] ?? null;

$offset = ($currentPage - 1) * $itemsPerPage;

$tasks = getTasks($connection, $offset, $itemsPerPage, $filter, $searchQuery, $taskDate, $sortOrder);
?>

<style>
	@import '../../../styles/pages/tasks/tasks.css';
</style>

<section class="tasks">
	<div class="tasks-header">
		<h1>Tasks</h1>
		<?php include 'components/pages/tasks/filterList.php'; ?>
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

        <?php include 'components/pages/tasks/pagination.php'?>
    <?php endif; ?>

    <?php include 'components/ui/editModalWindow/editModalWindow.php' ?>
    <?php include 'components/ui/confirmDeleteModalWindow/confirmDeleteModalWindow.php' ?>
</section>

<script src="../../../js/editModal/editModal.js"></script>
<script src="../../../js/confirmDeleteModal/confirmDeleteModal.js"></script>