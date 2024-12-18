<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../helpers/database.php';
require_once __DIR__ . '/../helpers/errors.php';

$error = '';

require_guest();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $pdo = create_database();
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'fill in all fields';
        set_error('register', $error);
    } else {
        if (find_user_by_email($email, $pdo)) {
            $error = 'email already in use';
            set_error('register', $error);
        } else {
            register_user($name, $email, $password, $pdo);
            header('Location: /login.php');
        }
        login_user($user);
        header('Location: /');
        exit;
    }
}

require_once __DIR__ . '/../views/register.php';
