<?php
require_once __DIR__ . '/../../../models/offer.php';
require_once __DIR__ . '/../../../models/user.php';
require_once __DIR__ . '/../../../helpers/auth.php';
require_once __DIR__ . '/../../../helpers/database.php';

require_auth();
if (!check_role(['client'])) {
    abort(401);
}

$pdo = create_database();
$user_id = $_SESSION['user']['id_user'];

// Get offer ID from URL
preg_match('#^/client/offers/([0-9]+)/reject$#', $path, $matches);
$offer_id = $matches[1];

// Get offer details
$offer = get_offer($offer_id, $pdo);
if (!$offer) {
    abort(404);
}

// Verify this offer is for a project owned by this client
$stmt = $pdo->prepare("
    SELECT id_project 
    FROM Projects 
    WHERE id_project = :project_id 
    AND id_user = :user_id
");
$stmt->execute([
    ':project_id' => $offer['id_project'],
    ':user_id' => $user_id
]);
if (!$stmt->fetch()) {
    abort(403);
}

// Only allow rejecting pending offers
if ($offer['status'] !== 'pending') {
    set_error('reject_offer', 'Can only reject pending offers');
    header('Location: /client/offers');
    exit;
}

// Reject the offer
if (update_offer_status($offer_id, 'rejected', $pdo)) {
    header('Location: /client/offers');
    exit;
} else {
    set_error('reject_offer', 'Failed to reject offer');
    header('Location: /client/offers');
    exit;
}
