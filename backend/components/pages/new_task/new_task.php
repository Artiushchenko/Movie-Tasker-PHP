<?php
require_once 'handlers/connection.php';

function getUserTags($connection, $user_email)
{
    $stmt = $connection->prepare("SELECT * FROM tags WHERE user_email = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    $tags = [];

    while ($row = $result->fetch_assoc()) {
        $tags[] = $row;
    }

    $stmt->close();
    return $tags;
}

$user_email = $_SESSION['user'];
$tags = getUserTags($connection, $user_email);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet"
	      href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/css/multi-select-tag.css">
	<style>
        section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        input[type='text'],
        input[type='number'],
        textarea {
            padding: 8px;
            width: 100%;
            font-size: 14px;
            border: 2px solid var(--black-color);
        }

        input[type='number'] {
            width: 15%;
        }

        textarea {
            height: 80px;
            resize: none;
        }

        .total-time-settings {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .total-time-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 15px;
        }

        .multiselect > label > a {
            cursor: pointer;
            text-decoration: none;
            color: var(--black-color);
            position: relative;
            transition: 0.3s ease-in-out;
        }

        .multiselect > label > a:hover {
	        font-weight: bold;
        }

        .sendTask {
            margin-left: auto;
        }
	</style>
	<script>
		function toggleFields() {
			const taskCategory = document.getElementById('taskCategory').value;
			const filmFields = document.getElementById('filmFields');
			const serialFields = document.getElementById('serialFields');

			if (taskCategory === 'Film') {
				filmFields.style.display = 'block';
				serialFields.style.display = 'none';
			} else if (taskCategory === 'Serial') {
				filmFields.style.display = 'none';
				serialFields.style.display = 'block';
			} else {
				filmFields.style.display = 'none';
				serialFields.style.display = 'none';
			}
		}

		window.onload = function() {
			toggleFields();
			document.getElementById('taskCategory').addEventListener('change', toggleFields);
		};
	</script>
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
				<a href="/new-tag">Create</a>
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

<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/js/multi-select-tag.js"></script>
<script>
	new MultiSelectTag('tags', {
		tagColor: {
			textColor: '#000000',
			borderColor: '#000000',
			bgColor: '#FFFFFF'
		}
	});
</script>
</body>
</html>