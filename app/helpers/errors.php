<?php
function set_error($key, $message)
{
    $_SESSION["error_{$key}"] = $message;
}

function get_error($key)
{
    if (has_error($key)) {
        $error = $_SESSION["error_{$key}"];
        unset($_SESSION["error_{$key}"]);
        return $error;
    }
    return null;
}

function has_error($key)
{
    return isset($_SESSION["error_{$key}"]);
}


function abort($code = 404)
{
    http_response_code($code);
    require 'app/views/errors/' . $code . '.php';
    die();
}