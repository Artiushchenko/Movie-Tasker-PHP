<?php
$request_uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

function isAuthenticated() {
    return isset($_SESSION['user']);
}

$authRoutes = [
    '/' => 'components/pages/new_task/new_task.php',
    '/tasks' => 'components/pages/tasks/tasks.php',
    '/new-tag' => 'components/pages/new_tag/new_tag.php',
];

$publicRoutes = [
    '/login' => 'components/pages/auth/login.php',
    '/register' => 'components/pages/auth/register.php',
    '/404' => 'components/pages/not_found/not_found.php',
];

if(array_key_exists($request_uri, $authRoutes)) {
    if(isAuthenticated()) {
        return $authRoutes[$request_uri];
    } else {
        header('Location: /login');
        exit();
    }
} elseif (array_key_exists($request_uri, $publicRoutes)) {
    return $publicRoutes[$request_uri];
} else {
    return './components/pages/not_found/not_found.php';
}