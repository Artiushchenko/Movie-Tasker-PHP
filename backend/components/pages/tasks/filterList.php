<div class="filter-list">
    <form method="POST" action="">
        <input
            type="text"
            name="search_query"
            placeholder="Search task by title..."
            value="<?= htmlspecialchars($searchQuery) ?>"
        >

        <button type="submit" name="filter" value="active">Active</button>
        <button type="submit" name="filter" value="completed">Completed</button>
    </form>
</div>