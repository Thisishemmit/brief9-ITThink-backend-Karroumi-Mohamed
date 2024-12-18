<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../helpers/database.php';
require_once __DIR__ . '/../helpers/errors.php';

$error = '';

require_guest();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $pdo = create_database();
    if (empty($email) || empty($password)) {
        $error = 'fill in all fields';
        set_error('login', $error);
    } else {
        $user = verify_user_credentials($email, $password, $pdo);
        if ($user) {
            login_user($user);
            header('Location: /');
            exit;
        } else {
            $error = 'invalid email or password';
            set_error('login', $error);
        }
    }
}
require_once __DIR__ . '/../views/login.php';
