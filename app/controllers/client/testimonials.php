<?php
require_once __DIR__ . '/../../models/testimonial.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/database.php';

require_auth();
if (!check_role(['client'])) {
    abort(401);
}

$pdo = create_database();
$user_id = $_SESSION['user']['id_user'];

// Get all testimonials by this client
$testimonials = get_client_testimonials($user_id, $pdo);

require __DIR__ . '/../../views/client/testimonials.php';
