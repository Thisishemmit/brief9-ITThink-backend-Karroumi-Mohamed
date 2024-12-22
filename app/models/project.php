<?php

function get_client_projects($user_id, $pdo) {
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name, s.name as subcategory_name 
        FROM Projects p
        LEFT JOIN Categories c ON p.id_category = c.id_category
        LEFT JOIN Subcategories s ON p.id_subcategory = s.id_subcategory
        WHERE p.id_user = :user_id
        ORDER BY p.created_at DESC
    ");
    $stmt->execute([':user_id' => $user_id]);
    return $stmt->fetchAll();
}

function get_project_by_id($project_id, $pdo) {
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name, s.name as subcategory_name,
               u.name as client_name, u.email as client_email
        FROM Projects p
        LEFT JOIN Categories c ON p.id_category = c.id_category
        LEFT JOIN Subcategories s ON p.id_subcategory = s.id_subcategory
        LEFT JOIN Users u ON p.id_user = u.id_user
        WHERE p.id_project = :project_id
    ");
    $stmt->execute([':project_id' => $project_id]);
    return $stmt->fetch();
}

function create_project($title, $description, $user_id, $category_id, $subcategory_id, $pdo) {
    // Convert empty string to null for subcategory_id
    $subcategory_id = $subcategory_id === '' ? null : $subcategory_id;
    $stmt = $pdo->prepare("
        INSERT INTO Projects (title, description, id_user, id_category, id_subcategory) 
        VALUES (:title, :description, :user_id, :category_id, :subcategory_id)
    ");
    return $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':user_id' => $user_id,
        ':category_id' => $category_id,
        ':subcategory_id' => $subcategory_id
    ]);
}

function update_project($project_id, $title, $description, $category_id, $subcategory_id, $pdo) {
    $stmt = $pdo->prepare("
        UPDATE Projects 
        SET title = :title, 
            description = :description, 
            id_category = :category_id, 
            id_subcategory = :subcategory_id
        WHERE id_project = :project_id
    ");
    return $stmt->execute([
        ':project_id' => $project_id,
        ':title' => $title,
        ':description' => $description,
        ':category_id' => $category_id,
        ':subcategory_id' => $subcategory_id
    ]);
}

function update_project_status($project_id, $status, $pdo) {
    $stmt = $pdo->prepare("
        UPDATE Projects 
        SET status = :status 
        WHERE id_project = :project_id
    ");
    return $stmt->execute([
        ':project_id' => $project_id,
        ':status' => $status
    ]);
}

function delete_project($project_id, $pdo) {
    $stmt = $pdo->prepare("DELETE FROM Projects WHERE id_project = :project_id");
    return $stmt->execute([':project_id' => $project_id]);
}

function get_available_projects($pdo) {
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name, s.name as subcategory_name,
               u.name as client_name
        FROM Projects p
        LEFT JOIN Categories c ON p.id_category = c.id_category
        LEFT JOIN Subcategories s ON p.id_subcategory = s.id_subcategory
        LEFT JOIN Users u ON p.id_user = u.id_user
        WHERE p.status = 'open'
        ORDER BY p.created_at DESC
    ");
    $stmt->execute();
    return $stmt->fetchAll();
}
