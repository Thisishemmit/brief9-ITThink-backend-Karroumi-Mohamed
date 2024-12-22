<?php
require_once __DIR__ . '/../../models/offer.php';
require_once __DIR__ . '/../../models/user.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/database.php';

require_auth();
if (!check_role(['client'])) {
    abort(401);
}

$pdo = create_database();
$user_id = $_SESSION['user']['id_user'];

// Get all offers for client's projects
$offers = get_client_offers($user_id, $pdo);

require __DIR__ . '/../../views/client/offers.php';
