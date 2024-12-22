<?php
require_once __DIR__ . '/../../models/offer.php';
require_once __DIR__ . '/../../models/user.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/database.php';

require_auth();
if (!check_role(['freelancer'])) {
    abort(401);
}

$pdo = create_database();
$user_id = $_SESSION['user']['id_user'];

$freelancer = get_freelancer_by_user_id($user_id, $pdo);
if (!$freelancer) {
    header('Location: /freelancer/projects');
    exit;
}

$offers = get_freelancer_offers($freelancer['id_freelancer'], $pdo);

require __DIR__ . '/../../views/freelancer/offers.php';
