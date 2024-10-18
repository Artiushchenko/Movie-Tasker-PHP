<?php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<style>
    @import '../../../styles/pages/tag_manage/tag_manage.css';
</style>

<section class="tag-manage">
	<form method="POST" action="../../../handlers/create_tag.php">
		<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

		<label for="tagTitle">Create tag:</label>

		<div class="tag-control-panel">
			<input
				type="text"
				name="tagTitle"
				id="tagTitle"
				placeholder="Name of the new tag"
				class="tag-manage-input <?php echo isset($_SESSION['errors']['create-tag-title']) ? 'error' : ''; ?>"
			/>
			<button type="submit">Add new tag</button>
		</div>

        <?php if (isset($_SESSION['errors']['create-tag-title'])): ?>
			<p class="error-message">
                <?php
                echo $_SESSION['errors']['create-tag-title'];
                ?>
			</p>
        <?php endif; ?>
	</form>

	<strong>Or</strong>

	<form method="POST" action="../../../handlers/remove_tag.php">
		<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

		<label for="tagName">Remove tag:</label>

		<div class="tag-control-panel">
			<input
				type="text"
				name="tagName"
				id="tagName"
				placeholder="Name of the tag"
				class="tag-manage-input <?php echo isset($_SESSION['errors']['remove-tag-title']) ? 'error' : ''; ?>"
			/>
			<button type="submit" class="remove-tag">Remove tag</button>
		</div>

        <?php if (isset($_SESSION['errors']['remove-tag-title'])): ?>
			<p class="error-message">
                <?php
                echo $_SESSION['errors']['remove-tag-title'];
                ?>
			</p>
        <?php endif; ?>
	</form>
</section>