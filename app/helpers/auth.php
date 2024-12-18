<?php

function is_logged_in()
{
    return isset($_SESSION['user']);
}

function login_user($user)
{
    $_SESSION['user'] = $user;
}

function logout_user()
{
    unset($_SESSION['user']);
    session_destroy();
}

function require_auth()
{
    if (!is_logged_in()) {
        header('Location: /login');
        exit;
    }
}

function require_guest()
{
    if (is_logged_in()) {
        header('Location: /');
        exit;
    }
}
