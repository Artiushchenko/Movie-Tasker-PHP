<style>
    @import '../../../styles/ui/confirmDeleteModalWindow.css';
</style>

<div id="deleteModal" class="modal" style="visibility: hidden;">
    <div class="confirm-modal-content">
        <p>Are you sure you want to delete this task?</p>
        <form id="deleteForm" method="POST" action="../../../handlers/remove_task.php">
            <input type="hidden" name="task_id" id="delete_task_id">
            <input type="hidden" name="action" value="delete">
	        <div class="buttons-container">
		        <button type="button" onclick="closeDeleteModal()">Cancel</button>
		        <button type="submit" class="remove-task-button">Confirm</button>
	        </div>
        </form>
    </div>
</div>