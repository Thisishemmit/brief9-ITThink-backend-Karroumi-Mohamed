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

// Get testimonial ID from URL
preg_match('#^/client/testimonials/([0-9]+)/delete$#', $path, $matches);
$testimonial_id = $matches[1];

// Get testimonial details
$testimonial = get_testimonial_by_id($testimonial_id, $pdo);
if (!$testimonial) {
    abort(404);
}

// Verify testimonial belongs to this client
if ($testimonial['id_user'] != $user_id) {
    abort(403);
}

// Delete testimonial
if (delete_testimonial($testimonial_id, $pdo)) {
    header('Location: /client/testimonials');
    exit;
} else {
    set_error('delete_testimonial', 'Failed to delete testimonial');
    header('Location: /client/testimonials');
    exit;
}
