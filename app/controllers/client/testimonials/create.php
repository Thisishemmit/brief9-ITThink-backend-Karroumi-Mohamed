<?php
require_once __DIR__ . '/../../../models/testimonial.php';
require_once __DIR__ . '/../../../helpers/auth.php';
require_once __DIR__ . '/../../../helpers/database.php';

require_auth();
if (!check_role(['client'])) {
    abort(401);
}

$pdo = create_database();
$user_id = $_SESSION['user']['id_user'];

// Validate input
if (!isset($_POST['freelancer_id']) || !isset($_POST['comment']) || empty(trim($_POST['comment']))) {
    set_error('create_testimonial', 'Please provide both freelancer and comment');
    header('Location: /client/testimonials');
    exit;
}

$freelancer_id = $_POST['freelancer_id'];
$comment = trim($_POST['comment']);

// Create testimonial
if (create_testimonial($comment, $user_id, $freelancer_id, $pdo)) {
    header('Location: /client/testimonials');
    exit;
} else {
    set_error('create_testimonial', 'Failed to create testimonial');
    header('Location: /client/testimonials');
    exit;
}
