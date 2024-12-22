<?php
require_once __DIR__ . '/../../../models/category.php';
require_once __DIR__ . '/../../../helpers/auth.php';
require_once __DIR__ . '/../../../helpers/database.php';

// Ensure user is authenticated and is a client
require_auth();
if (!check_role(['client'])) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$pdo = create_database();
$category_id = $_GET['category_id'] ?? null;

if ($category_id) {
    $subcategories = get_subcategories_by_category($category_id, $pdo);
    header('Content-Type: application/json');
    echo json_encode($subcategories);
} else {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Category ID is required']);
}
