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

function getCurrentUserRole() {
    return $_SESSION['user']['role'] ?? null;
}

function getCurrentUserName() {
    return $_SESSION['user']['name'] ?? null;
}

function check_role($required_roles_set) {
    if (!is_logged_in()) {
        return false;
    }
    $user_role = $_SESSION['user']['role'];

    if (!in_array($user_role, $required_roles_set)) {
        return false;
    }
    return true;
}

function check_authorization($roles) {
    if (in_array('all', $roles)) {
        return;
    }
    if (is_logged_in() && !check_role($roles)) {
        http_response_code(401);
        require 'app/views/errors/401.php';
        die();
    }
}
