<?php
require_once __DIR__ . '/../../../models/project.php';
require_once __DIR__ . '/../../../models/offer.php';
require_once __DIR__ . '/../../../helpers/auth.php';
require_once __DIR__ . '/../../../helpers/database.php';

require_auth();
if (!check_role(['client'])) {
    abort(401);
}

$pdo = create_database();
$user_id = $_SESSION['user']['id_user'];

// Get project ID from URL parameter
$project_id = isset($id) ? (int)$id : 0;

if (!$project_id) {
    header('Location: /client/projects');
    exit;
}

// Get project details
$project = get_project_by_id($project_id, $pdo);

// Check if project exists and belongs to current user
if (!$project || $project['id_user'] != $user_id) {
    abort(404);
}

// Get project offers
$all_offers = get_project_offers($project_id, $pdo);

// Organize offers by status
$accepted_offers = array_filter($all_offers, function($offer) {
    return $offer['status'] === 'accepted';
});

$pending_offers = array_filter($all_offers, function($offer) {
    return $offer['status'] === 'pending';
});

$rejected_offers = array_filter($all_offers, function($offer) {
    return $offer['status'] === 'rejected';
});

// Handle project actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'close':
            if ($project['status'] === 'open') {
                update_project_status($project_id, 'closed', $pdo);
                header('Location: /client/projects/' . $project_id);
                exit;
            }
            break;

        case 'reopen':
            if ($project['status'] === 'closed') {
                update_project_status($project_id, 'open', $pdo);
                header('Location: /client/projects/' . $project_id);
                exit;
            }
            break;

        case 'delete':
            if (delete_project($project_id, $pdo)) {
                header('Location: /client/projects');
                exit;
            }
            break;

        case 'accept_offer':
            $offer_id = $_POST['offer_id'] ?? 0;
            if ($offer_id && $project['status'] === 'open') {
                // First reject all other pending offers
                reject_other_offers($project_id, $offer_id, $pdo);
                // Then accept this offer
                update_offer_status($offer_id, 'accepted', $pdo);
                // Close the project
                update_project_status($project_id, 'closed', $pdo);
                header('Location: /client/projects/' . $project_id);
                exit;
            }
            break;

        case 'reject_offer':
            $offer_id = $_POST['offer_id'] ?? 0;
            if ($offer_id && $project['status'] === 'open') {
                update_offer_status($offer_id, 'rejected', $pdo);
                header('Location: /client/projects/' . $project_id);
                exit;
            }
            break;
    }
}

// Load the view
require __DIR__ . '/../../../views/client/projects/view.php';