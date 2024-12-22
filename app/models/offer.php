<?php

function get_project_offers($project_id, $pdo)
{
    $stmt = $pdo->prepare("
        SELECT o.*, u.name as freelancer_name, u.email as freelancer_email
        FROM Offers o
        JOIN Freelancers f ON o.id_freelancer = f.id_freelancer
        JOIN Users u ON f.id_user = u.id_user
        WHERE o.id_project = :project_id
        ORDER BY o.created_at DESC
    ");
    $stmt->execute([':project_id' => $project_id]);
    return $stmt->fetchAll();
}

function get_client_offers($user_id, $pdo)
{
    $stmt = $pdo->prepare("
        SELECT o.*, p.title as project_title,
               u.name as freelancer_name, u.email as freelancer_email
        FROM Offers o
        JOIN Projects p ON o.id_project = p.id_project
        JOIN Freelancers f ON o.id_freelancer = f.id_freelancer
        JOIN Users u ON f.id_user = u.id_user
        WHERE p.id_user = :user_id
        ORDER BY o.created_at DESC
    ");
    $stmt->execute([':user_id' => $user_id]);
    return $stmt->fetchAll();
}

function update_offer_status($offer_id, $status, $pdo)
{
    $stmt = $pdo->prepare("
        UPDATE Offers
        SET status = :status
        WHERE id_offer = :offer_id
    ");
    return $stmt->execute([
        ':offer_id' => $offer_id,
        ':status' => $status
    ]);
}

function get_offer_by_id($offer_id, $pdo)
{
    $stmt = $pdo->prepare("
        SELECT o.*, p.title as project_title,
               u.name as freelancer_name, u.email as freelancer_email
        FROM Offers o
        JOIN Projects p ON o.id_project = p.id_project
        JOIN Freelancers f ON o.id_freelancer = f.id_freelancer
        JOIN Users u ON f.id_user = u.id_user
        WHERE o.id_offer = :offer_id
    ");
    $stmt->execute([':offer_id' => $offer_id]);
    return $stmt->fetch();
}

function get_freelancer_project_offer($project_id, $freelancer_id, $pdo)
{
    $stmt = $pdo->prepare("
        SELECT o.*, p.title as project_title,
               u.name as freelancer_name, u.email as freelancer_email,
               o.price as amount, o.deadline, o.created_at,
               o.status
        FROM Offers o
        JOIN Projects p ON o.id_project = p.id_project
        JOIN Freelancers f ON o.id_freelancer = f.id_freelancer
        JOIN Users u ON f.id_user = u.id_user
        WHERE o.id_project = :project_id
        AND o.id_freelancer = :freelancer_id
    ");
    $stmt->execute([
        ':project_id' => $project_id,
        ':freelancer_id' => $freelancer_id
    ]);
    return $stmt->fetch();
}

function submit_offer($project_id, $freelancer_id, $amount, $deadline, $pdo)
{
    $stmt = $pdo->prepare("
        INSERT INTO Offers (id_project, id_freelancer, price, deadline, status, created_at)
        VALUES (:project_id, :freelancer_id, :amount, :deadline, 'pending', CURRENT_TIMESTAMP)
    ");

    return $stmt->execute([
        ':project_id' => $project_id,
        ':freelancer_id' => $freelancer_id,
        ':amount' => $amount,
        ':deadline' => $deadline
    ]);
}

function update_offer($offer_id, $amount, $deadline, $pdo)
{
    $stmt = $pdo->prepare("
        UPDATE Offers
        SET price = :amount,
            deadline = :deadline
        WHERE id_offer = :offer_id
        AND status = 'pending'
    ");

    return $stmt->execute([
        ':offer_id' => $offer_id,
        ':amount' => $amount,
        ':deadline' => $deadline
    ]);
}

function reject_other_offers($project_id, $accepted_offer_id, $pdo)
{
    $stmt = $pdo->prepare("
        UPDATE Offers
        SET status = 'rejected'
        WHERE id_project = :project_id
        AND id_offer != :accepted_offer_id
        AND status = 'pending'
    ");

    return $stmt->execute([
        ':project_id' => $project_id,
        ':accepted_offer_id' => $accepted_offer_id
    ]);
}

function get_freelancer_offers($freelancer_id, $pdo) {
    $stmt = $pdo->prepare("
        SELECT o.id_offer, o.price, o.status, o.created_at, o.deadline,
               p.title as project_title, p.status as project_status,
               u.name as client_name
        FROM Offers o
        JOIN Projects p ON o.id_project = p.id_project
        JOIN Users u ON p.id_user = u.id_user
        WHERE o.id_freelancer = :freelancer_id
        ORDER BY o.created_at DESC
    ");
    $stmt->execute([':freelancer_id' => $freelancer_id]);
    return $stmt->fetchAll();
}


function create_offer($project_id, $freelancer_id, $price, $description, $pdo) {
    $stmt = $pdo->prepare("
        INSERT INTO Offers (id_project, id_freelancer, price, description, status)
        VALUES (:project_id, :freelancer_id, :price, :description, 'pending')
    ");
    return $stmt->execute([
        ':project_id' => $project_id,
        ':freelancer_id' => $freelancer_id,
        ':price' => $price,
        ':description' => $description
    ]);
}

function get_offer($offer_id, $pdo) {
    $stmt = $pdo->prepare("
        SELECT o.*, p.title as project_title, p.description as project_description,
               u.name as client_name
        FROM Offers o
        JOIN Projects p ON o.id_project = p.id_project
        JOIN Users u ON p.id_user = u.id_user
        WHERE o.id_offer = :offer_id
    ");
    $stmt->execute([':offer_id' => $offer_id]);
    return $stmt->fetch();
}

function delete_offer($offer_id, $pdo) {
    $stmt = $pdo->prepare("
        DELETE FROM Offers 
        WHERE id_offer = :offer_id
    ");
    return $stmt->execute([':offer_id' => $offer_id]);
}
