<?php

require_once 'app/helpers/auth.php';
require_once 'app/helpers/database.php';
require_once 'app/models/project.php';

require_auth();
check_authorization(['admin']);

$pdo = create_database();

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $projects = get_all_projects($pdo);
        require 'app/views/admin/projects.php';
        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $user_id = $_POST['user_id'];
            $category_id = $_POST['category_id'];
            $subcategory_id = $_POST['subcategory_id'];

            create_project($title, $description, $user_id, $category_id, $subcategory_id, $pdo);
            header('Location: /admin/projects');
            exit;
        }
        require 'app/views/admin/projects_create.php';
        break;

    case 'edit':
        $project_id = $_GET['id'];
        $project = get_project_by_id($project_id, $pdo);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $category_id = $_POST['category_id'];
            $subcategory_id = $_POST['subcategory_id'];

            update_project($project_id, $title, $description, $category_id, $subcategory_id, $pdo);
            header('Location: /admin/projects');
            exit;
        }
        require 'app/views/admin/projects_edit.php';
        break;

    case 'delete':
        $project_id = $_GET['id'];
        delete_project($project_id, $pdo);
        header('Location: /admin/projects');
        exit;

    default:
        abort(404);
}
