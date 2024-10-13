<?php
require_once 'handlers/connection.php';
require_once 'helpers/new_task_helper.php';

$user_email = $_SESSION['user'];
$tags = getUserTags($connection, $user_email);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- CSS STYLES LINKS -->
	<link rel="stylesheet"
	      href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/css/multi-select-tag.css">
	<link rel="stylesheet" href="../../../styles/pages/new_task/new_task.css">

	<!-- JS PRELOAD SCRIPTS -->
	<script src="../../../js/toggleTypeFields/toggleTypeFields.js"></script>
	<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/js/multi-select-tag.js"></script>
</head>
<body>
<section>
	<h1>Create new task</h1>

	<form method="POST" action="../../../handlers/create_task.php">
		<div class="form-group">
			<input
				type="text"
				name="taskTitle"
				placeholder="What we will watch?"
				class="form-control"
				required
			/>
		</div>

		<div class="form-group">
                <textarea
	                name="taskDescription"
	                placeholder="Enter description here"
	                class="form-control"
                ></textarea>
		</div>

		<div class="form-group">
			<label for="taskCategory">Category:</label>
			<select id="taskCategory" name="taskCategory" class="form-control">
				<option value="Film">Film</option>
				<option value="Serial">Serial</option>
			</select>
		</div>
		<div id="filmFields" style="display: none;">
			<div class="total-time-settings">
				<div class="total-time-group">
					<label>Hours:</label>
					<input type="number" name="filmHours" class="form-control"/>
				</div>
				<div class="total-time-group">
					<label>Minutes:</label>
					<input type="number" name="filmMinutes" class="form-control"/>
				</div>
			</div>
		</div>
		<div id="serialFields" style="display: none;">
			<div class="total-time-settings">
				<div class="total-time-group">
					<label>Seasons:</label>
					<input type="number" name="serialSeasons" class="form-control"/>
				</div>
				<div class="total-time-group">
					<label>Series:</label>
					<input type="number" name="serialSeries" class="form-control"/>
				</div>
				<div class="total-time-group">
					<label>Duration one series:</label>
					<input type="number" name="serialSeriesMinutes" class="form-control"/>
				</div>
			</div>
		</div>

		<div class="multiselect">
			<label for="tags">
				<a class="create-tag-link" href="/tag-manage">Create</a>,
				<a class="remove-tag-link" href="/tag-manage">remove</a>
				or select tags:
			</label>
			<select name="tags[]" id="tags" multiple>
                <?php foreach ($tags as $tag): ?>
					<option value="<?php echo htmlspecialchars($tag['id']) ?>">
                        <?php echo htmlspecialchars($tag['title']) ?>
					</option>
                <?php endforeach; ?>
			</select>
		</div>

		<button type="submit" class="sendTask">Create</button>
	</form>
</section>

<!-- MULTISELECT JS SCRIPT -->
<script src="../../../js/multiSelect/multiSelect.js"></script>
</body>
</html>