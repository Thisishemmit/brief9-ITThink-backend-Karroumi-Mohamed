<?php

require_once 'app/helpers/auth.php';
require_once 'app/helpers/database.php';
require_once 'app/models/category.php';

require_auth();
check_authorization(['admin']);

$pdo = create_database();

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $categories = get_categories($pdo);
        require 'app/views/admin/categories.php';
        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            create_category($name, $pdo);
            header('Location: /admin/categories');
            exit;
        }
        require 'app/views/admin/categories_create.php';
        break;

    case 'edit':
        $category_id = $_GET['id'];
        $category = get_category_by_id($category_id, $pdo);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            update_category($category_id, $name, $pdo);
            header('Location: /admin/categories');
            exit;
        }
        require 'app/views/admin/categories_edit.php';
        break;

    case 'delete':
        $category_id = $_GET['id'];
        delete_category($category_id, $pdo);
        header('Location: /admin/categories');
        exit;

    default:
        abort(404);
}
