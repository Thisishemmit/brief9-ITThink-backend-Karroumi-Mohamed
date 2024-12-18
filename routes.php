<?php
$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri)['path'];


$routers = [
    '/' => 'app/controllers/index.php',
    '/login' => 'app/controllers/login.php',
    '/register' => 'app/controllers/register.php',
];

if (array_key_exists($path, $routers)) {
    require $routers[$path];
} else {
    http_response_code(404);
    echo '404';
    die();
}
