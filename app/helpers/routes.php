<?php
require_once 'errors.php';
function handle_dynamic_route($path, $routes)
{
    foreach ($routes as $route => $config) {
        if (preg_match('#^' . $route . '$#', $path, $matches)) {
            $id = isset($matches[1]) ? $matches[1] : null;
            require $config['path'];
            die();
        }
    }
    abort(404);
}

function is_path_dynamic($path, $routes)
{
    foreach ($routes as $route => $config) {
        if (preg_match('#^' . $route . '$#', $path)) {
            return true;
        }
    }
    return false;
}
