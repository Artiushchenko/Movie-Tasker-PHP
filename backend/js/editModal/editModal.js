function openEditModal(task) {
	document.getElementById('editModal').style.visibility = 'visible';

	const taskIdInput = document.getElementById('task_id');
	const taskTitleInput = document.getElementById('task_title');
	const taskDescriptionInput = document.getElementById('task_description');

	taskIdInput.value = task.id;
	taskTitleInput.value = task.title;
	taskDescriptionInput.value = task.description;
}

function closeModal() {
	document.getElementById('editModal').style.visibility = 'hidden';
}