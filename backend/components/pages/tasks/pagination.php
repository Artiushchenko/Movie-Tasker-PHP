<style>
	@import '../../../styles/ui/pagination.css';
</style>

<?php
$totalItems = getFilteredTasksCount($connection, $_SESSION['user'], $filter, $searchQuery, $taskDate);
$totalPages = ceil($totalItems / $itemsPerPage);
?>

<?php if ($totalPages <= 1 || $totalItems <= 5): ?>
    <?php return; ?>
<?php endif; ?>

<div class="pagination">
    <form method="GET" action="/tasks">
        <button
            type="submit"
            name="current_page"
            value="<?= max($currentPage - 1, 1) ?>"
            <?= ($currentPage === 1) ? 'disabled' : '' ?>
        >
            «
        </button>

        <span>
	        Page
	        <strong><?= $currentPage ?></strong>
	        of
	        <strong><?= $totalPages ?></strong>
        </span>

        <button
            type="submit"
            name="current_page"
            value="<?= min($currentPage + 1, $totalPages) ?>"
            <?= ($currentPage === $totalPages) ? 'disabled' : '' ?>
        >
            »
        </button>
    </form>
</div>
