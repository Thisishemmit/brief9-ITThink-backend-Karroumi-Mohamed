<?php
<<<<<<< Updated upstream
function login_user($email, $password, $pdo)
{
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
    $stmt->execute(['email' => $email, 'password' => $password]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        return true;
    } else {
        return false;
    }
}

function register_user($email, $password, $pdo)
{
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
        return false;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (email, password, role) VALUES (:email, :password)');
    $stmt->execute(['email' => $email, 'password' => $hash]);
}

function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

function require_login()
=======

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
>>>>>>> Stashed changes
{
    if (!is_logged_in()) {
        header('Location: /login');
        exit;
    }
}

<<<<<<< Updated upstream
function logout_user()
{
    unset($_SESSION['user_id']);
    session_destroy();
=======
function require_guest()
{
    if (is_logged_in()) {
        header('Location: /');
        exit;
    }
>>>>>>> Stashed changes
}
