<?php
require_once __DIR__ . '/../../../models/offer.php';
require_once __DIR__ . '/../../../helpers/auth.php';
require_once __DIR__ . '/../../../helpers/database.php';

require_auth();
if (!check_role(['freelancer'])) {
    http_response_code(401);
    require __DIR__ . '/../../../views/errors/401.php';
    die();
}

$pdo = create_database();
$user_id = $_SESSION['user']['id_user'];

// Get offer ID from URL
preg_match('#^/freelancer/offers/([0-9]+)/delete$#', $path, $matches);
$offer_id = $matches[1];

// Get offer details
$offer = get_offer($offer_id, $pdo);

// Verify offer exists and belongs to this freelancer
$freelancer = get_freelancer_by_user_id($user_id, $pdo);
if (!$offer || !$freelancer || $offer['id_freelancer'] != $freelancer['id_freelancer']) {
    abort(404);
}

// Delete the offer
if (delete_offer($offer_id, $pdo)) {
    header('Location: /freelancer/offers');
    exit;
} else {
    set_error('delete_offer', 'Failed to delete offer');
    header('Location: /freelancer/offers');
    exit;
}
