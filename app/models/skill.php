<?php

function get_freelancer_skills($freelancer_id, $pdo) {
    $stmt = $pdo->prepare("
        SELECT *
        FROM Skills
        WHERE id_freelancer = :freelancer_id
        ORDER BY name ASC
    ");
    $stmt->execute([':freelancer_id' => $freelancer_id]);
    return $stmt->fetchAll();
}

function create_skill($name, $freelancer_id, $pdo) {
    $stmt = $pdo->prepare("
        INSERT INTO Skills (name, id_freelancer)
        VALUES (:name, :freelancer_id)
    ");
    return $stmt->execute([
        ':name' => $name,
        ':freelancer_id' => $freelancer_id
    ]);
}

function update_skill($skill_id, $name, $pdo) {
    $stmt = $pdo->prepare("
        UPDATE Skills 
        SET name = :name 
        WHERE id_skill = :skill_id
    ");
    return $stmt->execute([
        ':skill_id' => $skill_id,
        ':name' => $name
    ]);
}

function delete_skill($skill_id, $pdo) {
    $stmt = $pdo->prepare("
        DELETE FROM Skills 
        WHERE id_skill = :skill_id
    ");
    return $stmt->execute([':skill_id' => $skill_id]);
}

function get_skill_by_id($skill_id, $pdo) {
    $stmt = $pdo->prepare("
        SELECT *
        FROM Skills
        WHERE id_skill = :skill_id
    ");
    $stmt->execute([':skill_id' => $skill_id]);
    return $stmt->fetch();
}
