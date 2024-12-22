<?php
require_once __DIR__ . '/../../../models/project.php';
require_once __DIR__ . '/../../../models/offer.php';
require_once __DIR__ . '/../../../models/user.php';
require_once __DIR__ . '/../../../helpers/auth.php';
require_once __DIR__ . '/../../../helpers/database.php';

require_auth();
if (!check_role(['freelancer'])) {
    abort(401);
}

$pdo = create_database();
if ($_SESSION['user']['role'] === 'freelancer') {
    $freelancer = get_freelancer_by_user_id($_SESSION['user']['id_user'], $pdo);
    $user_id = $freelancer['id_freelancer'];
}

$project_id = isset($id) ? (int)$id : 0;

if (!$project_id) {
    header('Location: /freelancer/projects');
    exit;
}

$project = get_project_by_id($project_id, $pdo);

if (!$project) {
    abort(404);
}

// Get the freelancer's offer for this project
$offer = get_freelancer_project_offer($project_id, $user_id, $pdo);
$already_made_offer = !empty($offer);

// Get other freelancers' offers if the project is closed or the offer is accepted
$show_other_offers = $project['status'] === 'closed' || ($already_made_offer && $offer['status'] === 'accepted');
$other_offers = $show_other_offers ? get_project_offers($project_id, $pdo) : [];

// Filter out the current freelancer's offer from other offers
if (!empty($other_offers)) {
    $other_offers = array_filter($other_offers, function($o) use ($user_id) {
        return $o['id_freelancer'] != $user_id;
    });
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'offer':
            $amount = $_POST['amount'] ?? '';
            $deadline = $_POST['deadline'] ?? '';

            if (!$already_made_offer && $project['status'] === 'open') {
                submit_offer($project_id, $user_id, $amount, $deadline, $pdo);
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
            break;
            
        case 'update_offer':
            if ($already_made_offer && $project['status'] === 'open' && $offer['status'] === 'pending') {
                $amount = $_POST['amount'] ?? '';
                $deadline = $_POST['deadline'] ?? '';
                
                update_offer($offer['id_offer'], $amount, $deadline, $pdo);
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
            break;

        case 'withdraw_offer':
            if ($already_made_offer && $project['status'] === 'open' && $offer['status'] === 'pending') {
                delete_offer($offer['id_offer'], $pdo);
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
            break;
    }
}

require_once __DIR__ . '/../../../views/freelancer/projects/view.php';
