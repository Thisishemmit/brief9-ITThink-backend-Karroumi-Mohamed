<?php
require_once 'app/models/project.php';
require_once 'app/models/category.php';
require_once 'app/helpers/database.php';

$pdo = create_database();

preg_match('#^/client/projects/([0-9]+)/edit$#', $path, $matches);
$project_id = $matches[1];

// Get project details
$project = get_project_by_id($project_id, $pdo);

// Check if project exists and belongs to user
if (!$project || $project['id_user'] != $_SESSION['user']['id_user']) {
    abort(404);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $subcategory_id = $_POST['subcategory_id'] ?? '';

    // Validate inputs
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

    if (empty($errors)) {
        // Update project using model method
        if (update_project($project_id, $title, $description, $category_id, $subcategory_id, $pdo)) {
            // Redirect back to project view
            header("Location: /client/projects/$project_id");
            exit;
        } else {
            $errors['general'] = 'Failed to update project';
        }
    }
}

// Get categories for form
$categories = get_categories($pdo);
$subcategories = [];
if ($project['id_category']) {
    $subcategories = get_subcategories($project['id_category'], $pdo);
}

require 'app/views/client/projects/edit.php';
