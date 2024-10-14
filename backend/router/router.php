<?php
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

function isAuthenticated() {
    return isset($_SESSION['user']);
}

$authRoutes = [
    '/' => 'components/pages/new_task/new_task.php',
    '/tasks' => 'components/pages/tasks/tasks.php',
    '/tasks/([0-9]+)' => 'components/pages/tasks/tasks.php',
    '/tag-manage' => 'components/pages/tag_manage/tag_manage.php',
];

$publicRoutes = [
    '/login' => 'components/pages/auth/login.php',
    '/register' => 'components/pages/auth/register.php',
    '/404' => 'components/pages/not_found/not_found.php',
];

$foundRoute = false;

foreach ($authRoutes as $route => $file) {
    if(preg_match("~^$route$~",$request_uri, $matches)) {
        if(isAuthenticated()) {
            if(count($matches) > 1) {
                $_GET['page'] = $matches[1];
            } else {
                $_GET['page'] = $_GET['current_page'] ?? 1;
            }

            return $file;
        } else {
            header('Location: /login');
            exit();
        }
    }
}

foreach ($publicRoutes as $route => $file) {
    if($request_uri === $route) {
        return $file;
    }
}

return './components/pages/not_found/not_found.php';