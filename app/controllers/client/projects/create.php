<?php
require_once __DIR__ . '/../../../models/project.php';
require_once __DIR__ . '/../../../models/category.php';
require_once __DIR__ . '/../../../helpers/auth.php';
require_once __DIR__ . '/../../../helpers/database.php';

// Ensure user is authenticated and is a client
require_auth();
if (!check_role(['client'])) {
    http_response_code(401);
    require __DIR__ . '/../../../views/errors/401.php';
    die();
}

$pdo = create_database();
$user_id = $_SESSION['user']['id_user'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $category_id = $_POST['category_id'] ?? null;
    $subcategory_id = $_POST['subcategory_id'] ?? null;

    // Basic validation
    $errors = [];
    if (empty($title)) {
        $errors['title'] = 'Title is required';
    }
    if (empty($description)) {
        $errors['description'] = 'Description is required';
    }
    if (empty($category_id)) {
        $errors['category_id'] = 'Category is required';
    }

    // If no errors, create the project
    if (empty($errors)) {
        if (create_project($title, $description, $user_id, $category_id, $subcategory_id, $pdo)) {
            header('Location: /client/projects');
            exit;
        } else {
            $errors['general'] = 'Failed to create project. Please try again.';
        }
    }
}

// Get categories for the form
$categories = get_categories($pdo);
$subcategories = [];
if (!empty($_POST['category_id'])) {
    $subcategories = get_subcategories_by_category($_POST['category_id'], $pdo);
}

// Load the view
require __DIR__ . '/../../../views/client/projects/create.php';
