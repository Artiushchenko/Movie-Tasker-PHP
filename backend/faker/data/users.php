<?php
require_once 'handlers/connection.php';
require_once 'faker/faker.php';

$passwordLength = 10;
$userFaker = new UsersFaker($passwordLength);

function insertUsers($connection, $userData) {
	$stmt = $connection->prepare('
        INSERT INTO `users` (`users`.`email`, `users`.`password`) 
        VALUES (?, ?)
    ');
	$stmt->bind_param('ss', $userData['email'], $userData['password']);

	if(!$stmt->execute()) {
		throw new Error('Error: ' . $stmt->error);
	}

	$stmt->close();
}

$count = 1000;

for($i = 0; $i < $count; $i++) {
	$userData = $userFaker->generateData();
	insertUsers($connection, $userData);
}

mysqli_close($connection);