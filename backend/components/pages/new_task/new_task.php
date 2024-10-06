<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../styles/pages/new_task/new_task.css">
</head>
<body>
<section>
    <h1>Create new task</h1>

    <form method="post" action="">
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
            <select name="taskCategory" class="form-control">
                <option value="Film">Film</option>
                <option value="Serial">Serial</option>
            </select>
        </div>

        <div class="total-time" id="totalTime">
            <div class="total-time-settings film-time">
                <div class="total-time-group">
                    <label>Hours:</label>
                    <input type="number" name="filmHours" class="form-control" />
                </div>
                <div class="total-time-group">
                    <label>Minutes:</label>
                    <input type="number" name="filmMinutes" class="form-control" />
                </div>
            </div>

            <div class="total-time-settings serial-time">
                <div class="total-time-group">
                    <label>How many seasons?</label>
                    <input type="number" name="serialSeasons" class="form-control" />
                </div>
                <div class="total-time-group">
                    <label>How many series?</label>
                    <input type="number" name="serialSeries" class="form-control" />
                </div>
                <div class="total-time-group">
                    <label>How long is one series (in minutes)?</label>
                    <input type="number" name="serialSeriesMinutes" class="form-control" />
                </div>
            </div>
        </div>

        <div class="tag-list">
            <div class="tag-wrapper">
                <div class="tag">
                    <span>Add New</span>
                </div>
            </div>
        </div>

        <div class="tag-list new-tag">
            <input type="text" name="tagTitle" placeholder="Name of the new tag" class="form-control" />
            <button type="button" class="add-new-tag">Add new tag</button>
        </div>

        <div class="tag-list existing-tags">
            <div class="tag-wrapper">
                <div class="tag">
                    <span>Tag 1</span>
                    <span class="remove-tag-icon">
                            <i class="fa-solid fa-xmark"></i>
                        </span>
                </div>
                <div class="tag">
                    <span>Tag 2</span>
                    <span class="remove-tag-icon">
                            <i class="fa-solid fa-xmark"></i>
                        </span>
                </div>
            </div>
        </div>

        <button type="submit" class="sendTask">Create</button>
    </form>
</section>
</body>
</html>
