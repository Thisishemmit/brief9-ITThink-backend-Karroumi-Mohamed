<?php
require_once 'app/helpers/logs.php';
require_once 'app/helpers/auth.php';
require_once 'app/helpers/errors.php';
require_once 'app/helpers/routes.php';
require_once 'app/models/user.php';

$sidebar_routes = require_once 'app/config/sidebar.php';

$public_routes = [
    '/' => [
        'path' => 'app/controllers/index.php',
        'roles' => ['client', 'freelancer', 'admin']
    ],
    '/login' => [
        'path' => 'app/controllers/login.php',
        'roles' => ['all']
    ],
    '/register' => [
        'path' => 'app/controllers/register.php',
        'roles' => ['all']
    ],
    '/logout' => [
        'path' => 'app/controllers/logout.php',
        'roles' => [
            'client',
            'freelancer',
            'admin'
        ]
    ],
    '/dashboard' => [
        'path' => 'app/controllers/dashboard.php',
        'roles' => ['client', 'freelancer', 'admin']
    ],
    '/profile' => [
        'path' => 'app/controllers/profile.php',
        'roles' => ['client', 'freelancer', 'admin']
    ],
];

$client_actions = [
    '/client/projects/create' => [
        'path' => 'app/controllers/client/projects/create.php',
        'roles' => ['client']
    ],
    '/client/projects/get_subcategories' => [
        'path' => 'app/controllers/client/projects/get_subcategories.php',
        'roles' => ['client']
    ],
    '/client/projects/([0-9]+)' => [
        'path' => 'app/controllers/client/projects/view.php',
        'roles' => ['client']
    ],
    '/client/projects/([0-9]+)/edit' => [
        'path' => 'app/controllers/client/projects/edit.php',
        'roles' => ['client']
    ]
];

$freelancer_actions = [
    '/freelancer/projects/([0-9]+)' => [
        'path' => 'app/controllers/freelancer/projects/view.php',
        'roles' => ['freelancer']
    ]
];

$admin_actions = [
    '/admin/users/([0-9]+)/edit' => [
        'path' => 'app/controllers/admin/users/edit.php',
        'roles' => ['admin']
    ]
];

if (is_logged_in()) {

    $merged_routes = array_merge($sidebar_routes['freelancer'], $sidebar_routes['client'], $sidebar_routes['admin']);
    $routes = array_merge($public_routes, $merged_routes, $sidebar_routes['all'], $client_actions, $freelancer_actions, $admin_actions);
} else {
    $routes = $public_routes;
}

$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri)['path'];

$action_routes = array_merge($client_actions, $freelancer_actions, $admin_actions);
$requires_auth = false;
if (!array_key_exists($path, $public_routes)) {
    foreach ($client_actions as $route => $config) {
        if (preg_match('#^' . $route . '$#', $path) || $path === '/client/projects') {
            $requires_auth = true;
            break;
        }
    }
    foreach ($freelancer_actions as $route => $config) {
        if (preg_match('#^' . $route . '$#', $path) || $path === '/freelancer/projects') {
            $requires_auth = true;
            break;
        }
    }

    if (
        isset($sidebar_routes['client'][$path]) ||
        isset($sidebar_routes['freelancer'][$path]) ||
        isset($sidebar_routes['admin'][$path])
    ) {
        $requires_auth = true;
    }
}

if ($requires_auth && !is_logged_in()) {
    header('Location: /login');
    exit;
}

if (array_key_exists($path, $routes) || is_path_dynamic($path, $action_routes)) {
    if (is_path_dynamic($path, $action_routes)) {
        foreach ($action_routes as $route => $config) {
            if (preg_match('#^' . $route . '$#', $path)) {
                check_authorization($config['roles']);
                handle_dynamic_route($path, $action_routes);
                break;
            }
        }
    } else {
        check_authorization($routes[$path]['roles']);
        require $routes[$path]['path'];
    }
} else {
    abort(404);
}
