<style>
    @import url('../../../styles/ui/editModalWindow.css');
</style>

<div class="modal-overlay" id="editModal" style="visibility: hidden;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Task</h2>
        </div>

        <div class="modal-body">
            <form id="editTaskForm" method="POST" action="../../../handlers/edit_task.php">
                <input type="hidden" name="task_id" id="task_id" value="">
                <div>
                    <p>Title:</p>
                    <input type="text" name="title" id="task_title"/>
                </div>

                <div>
                    <p>Description:</p>
                    <textarea name="description" id="task_description"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal()">Cancel</button>
                    <button type="submit">OK</button>
                </div>
            </form>
        </div>
    </div>
</div>