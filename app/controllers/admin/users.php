<?php

require_once 'app/helpers/auth.php';
require_once 'app/helpers/database.php';
require_once 'app/models/user.php';

require_auth();
check_authorization(['admin']);

$pdo = create_database();

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $users = get_all_users($pdo);
        require 'app/views/admin/users.php';
        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            register_user($name, $email, $password, $role, $pdo);
            header('Location: /admin/users');
            exit;
        }
        require 'app/views/admin/users_create.php';
        break;

    case 'edit':
        $user_id = $_GET['id'];
        $user = get_user_by_id($user_id, $pdo);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            update_user($user_id, $name, $email, $role, $pdo);
            header('Location: /admin/users');
            exit;
        }
        require 'app/views/admin/users_edit.php';
        break;

    case 'delete':
        $user_id = $_GET['id'];
        delete_user($user_id, $pdo);
        header('Location: /admin/users');
        exit;

    default:
        abort(404);
}
