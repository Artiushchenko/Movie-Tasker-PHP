function openDeleteModal(taskId) {
	document.getElementById('deleteModal').style.visibility = 'visible';
	document.getElementById('delete_task_id').value = taskId;
}

function closeDeleteModal() {
	document.getElementById('deleteModal').style.visibility = 'hidden';
}