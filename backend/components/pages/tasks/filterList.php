<?php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<div class="filter-list">
    <form method="POST" action="">
	    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
	    <label for="task_date">Date:</label>
	    <input
		    type="date"
		    id="task_date"
		    name="task_date"
		    value="<?= htmlspecialchars($taskDate) ?>"
		    onchange="this.form.submit()"
	    >

	    <input
		    type="text"
		    name="search_query"
		    placeholder="Search task by title..."
		    value="<?= htmlspecialchars($searchQuery) ?>"
	    >

	    <button type="submit" name="sort_order" value="asc">▲</button>
	    <button type="submit" name="sort_order" value="desc">▼</button>
        <button type="submit" name="filter" value="active">Active</button>
        <button type="submit" name="filter" value="completed">Completed</button>
	    <button type="submit" name="reset_filters" value="1">Reset Filters</button>
    </form>
</div>