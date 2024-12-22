<?php

function get_client_testimonials($user_id, $pdo) {
    $stmt = $pdo->prepare("
        SELECT t.*, u.name as freelancer_name
        FROM Testimonials t
        JOIN Users u ON t.id_freelancer = u.id_user
        WHERE t.id_user = :user_id
        ORDER BY t.created_at DESC
    ");
    $stmt->execute([':user_id' => $user_id]);
    return $stmt->fetchAll();
}

function create_testimonial($comment, $user_id, $freelancer_id, $pdo) {
    $stmt = $pdo->prepare("
        INSERT INTO Testimonials (comment, id_user, id_freelancer)
        VALUES (:comment, :user_id, :freelancer_id)
    ");
    return $stmt->execute([
        ':comment' => $comment,
        ':user_id' => $user_id,
        ':freelancer_id' => $freelancer_id
    ]);
}

function update_testimonial($testimonial_id, $comment, $pdo) {
    $stmt = $pdo->prepare("
        UPDATE Testimonials 
        SET comment = :comment 
        WHERE id_testimonial = :testimonial_id
    ");
    return $stmt->execute([
        ':testimonial_id' => $testimonial_id,
        ':comment' => $comment
    ]);
}

function delete_testimonial($testimonial_id, $pdo) {
    $stmt = $pdo->prepare("
        DELETE FROM Testimonials 
        WHERE id_testimonial = :testimonial_id
    ");
    return $stmt->execute([':testimonial_id' => $testimonial_id]);
}

function get_testimonial_by_id($testimonial_id, $pdo) {
    $stmt = $pdo->prepare("
        SELECT t.*, u.name as freelancer_name
        FROM Testimonials t
        JOIN Users u ON t.id_freelancer = u.id_user
        WHERE t.id_testimonial = :testimonial_id
    ");
    $stmt->execute([':testimonial_id' => $testimonial_id]);
    return $stmt->fetch();
}
