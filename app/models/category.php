<?php

function get_categories($pdo) {
    $stmt = $pdo->prepare("
        SELECT * FROM Categories 
        ORDER BY name ASC
    ");
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_subcategories($id_category, $pdo) {
    $stmt = $pdo->prepare("
        SELECT * FROM Subcategories 
        WHERE id_category = :id_category 
        ORDER BY name ASC
    ");
    $stmt->execute([':id_category' => $id_category]);
    return $stmt->fetchAll();
}

function get_category_by_id($category_id, $pdo) {
    $stmt = $pdo->prepare("
        SELECT * FROM Categories 
        WHERE id_category = :category_id
    ");
    $stmt->execute([':category_id' => $category_id]);
    return $stmt->fetch();
}

function create_category($name, $pdo) {
    $stmt = $pdo->prepare("
        INSERT INTO Categories (name) 
        VALUES (:name)
    ");
    return $stmt->execute([':name' => $name]);
}

function update_category($category_id, $name, $pdo) {
    $stmt = $pdo->prepare("
        UPDATE Categories 
        SET name = :name 
        WHERE id_category = :category_id
    ");
    return $stmt->execute([
        ':category_id' => $category_id,
        ':name' => $name
    ]);
}

function delete_category($category_id, $pdo) {
    $stmt = $pdo->prepare("
        DELETE FROM Categories 
        WHERE id_category = :category_id
    ");
    return $stmt->execute([':category_id' => $category_id]);
}

// Subcategory functions
function get_subcategories_by_category($category_id, $pdo) {
    $stmt = $pdo->prepare("
        SELECT * FROM Subcategories 
        WHERE id_category = :category_id 
        ORDER BY name ASC
    ");
    $stmt->execute([':category_id' => $category_id]);
    return $stmt->fetchAll();
}

function get_subcategory_by_id($subcategory_id, $pdo) {
    $stmt = $pdo->prepare("
        SELECT s.*, c.name as category_name 
        FROM Subcategories s
        JOIN Categories c ON s.id_category = c.id_category
        WHERE s.id_subcategory = :subcategory_id
    ");
    $stmt->execute([':subcategory_id' => $subcategory_id]);
    return $stmt->fetch();
}

function create_subcategory($name, $category_id, $pdo) {
    $stmt = $pdo->prepare("
        INSERT INTO Subcategories (name, id_category) 
        VALUES (:name, :category_id)
    ");
    return $stmt->execute([
        ':name' => $name,
        ':category_id' => $category_id
    ]);
}

function update_subcategory($subcategory_id, $name, $category_id, $pdo) {
    $stmt = $pdo->prepare("
        UPDATE Subcategories 
        SET name = :name, 
            id_category = :category_id 
        WHERE id_subcategory = :subcategory_id
    ");
    return $stmt->execute([
        ':subcategory_id' => $subcategory_id,
        ':name' => $name,
        ':category_id' => $category_id
    ]);
}

function delete_subcategory($subcategory_id, $pdo) {
    $stmt = $pdo->prepare("
        DELETE FROM Subcategories 
        WHERE id_subcategory = :subcategory_id
    ");
    return $stmt->execute([':subcategory_id' => $subcategory_id]);
}

// Helper function to get all categories with their subcategories
function get_categories_with_subcategories($pdo) {
    $categories = get_categories($pdo);
    foreach ($categories as &$category) {
        $category['subcategories'] = get_subcategories_by_category($category['id_category'], $pdo);
    }
    return $categories;
}
