<?php

function find_user_by_email($email, $pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    return $stmt->fetch();
}

function verify_user_credentials($email, $password, $pdo)
{
    $user = find_user_by_email($email, $pdo);

    if ($user && password_verify($password, $user['password'])) {
        unset($user['password']);
        return $user;
    }

    return false;
}

function register_user($name, $email, $password, $pdo)
{
    $stmt = $pdo->prepare("INSERT INTO Users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
}
