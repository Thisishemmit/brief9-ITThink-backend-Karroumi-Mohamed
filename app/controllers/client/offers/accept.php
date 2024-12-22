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
preg_match('#^/client/offers/([0-9]+)/accept$#', $path, $matches);
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

// Only allow accepting pending offers
if ($offer['status'] !== 'pending') {
    set_error('accept_offer', 'Can only accept pending offers');
    header('Location: /client/offers');
    exit;
}

// Accept this offer and reject all others
$pdo->beginTransaction();
try {
    if (update_offer_status($offer_id, 'accepted', $pdo)) {
        reject_other_offers($offer['id_project'], $offer_id, $pdo);
        $pdo->commit();
        header('Location: /client/offers');
        exit;
    } else {
        throw new Exception('Failed to accept offer');
    }
} catch (Exception $e) {
    $pdo->rollBack();
    set_error('accept_offer', 'Failed to accept offer');
    header('Location: /client/offers');
    exit;
}
