<style>
	@import '../../../styles/pages/tag_manage/tag_manage.css';
</style>

<section class="tag-manage">
	<form method="POST" action="../../../handlers/create_tag.php">
		<label for="tagTitle">Create tag:</label>

		<div class="tag-control-panel">
			<input type="text" name="tagTitle" id="tagTitle" placeholder="Name of the new tag" class="tag-manage-input" />
			<button type="submit">Add new tag</button>
		</div>
	</form>

	<strong>Or</strong>

	<form method="POST" action="../../../handlers/remove_tag.php">
		<label for="tagName">Remove tag:</label>

		<div class="tag-control-panel">
			<input type="text" name="tagName" id="tagName" placeholder="Name of the tag" class="tag-manage-input" />
			<button type="submit" class="remove-tag">Remove tag</button>
		</div>
	</form>
</section>