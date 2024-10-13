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