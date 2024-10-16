<?php
session_start();

$pathToInclude = include './router/router.php';
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Movie Tasker</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- FAVICON LINK -->
	<link rel="icon" type="image/x-icon" href="./assets/images/favicon.png">

	<!-- CSS STYLES LINKS -->
	<link rel="stylesheet" type="text/css" href="./styles/main.css">
	<link rel="stylesheet" type="text/css" href="./styles/layout/header.css">
	<link rel="stylesheet" type="text/css" href="./styles/layout/main.css">
	<link rel="stylesheet" type="text/css" href="./styles/ui/button.css">
</head
<body>
<div id="app">
	<header>
		<span class="logo">Movie Tasker</span>

		<nav>
			<ul>
                <?php if (isset($_SESSION['user'])): ?>
					<li>
						<a href="/">New task</a>
					</li>
					<li>
						<a href="/tasks">Tasks</a>
					</li>
					<li>
						<a href="./handlers/logout.php">Logout</a>
					</li>
                <?php else: ?>
					<li>
						<a href="/login">Login</a>
					</li>
					<li>
						<a href="/register">Registration</a>
					</li>
                <?php endif; ?>
			</ul>
		</nav>
	</header>

	<main>
        <?php include $pathToInclude; ?>
	</main>
</div>
</body>
</html>