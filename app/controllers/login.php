<?php
if (isset($_SESSION['user'])) {
    header('Location: /');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($email === 'admin@admin.com' && $password === 'admin') {
        $_SESSION['user'] = $email;
        header('Location: /');
        die();
    }
}
 require __DIR__ . '/../views/login.php';
