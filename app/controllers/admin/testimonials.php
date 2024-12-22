<?php

require_once 'app/helpers/auth.php';
require_once 'app/helpers/database.php';
require_once 'app/models/testimonial.php';

require_auth();
check_authorization(['admin']);

$pdo = create_database();

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $testimonials = get_all_testimonials($pdo);
        require 'app/views/admin/testimonials.php';
        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comment = $_POST['comment'];
            $user_id = $_POST['user_id'];
            $freelancer_id = $_POST['freelancer_id'];

            create_testimonial($comment, $user_id, $freelancer_id, $pdo);
            header('Location: /admin/testimonials');
            exit;
        }
        require 'app/views/admin/testimonials_create.php';
        break;

    case 'edit':
        $testimonial_id = $_GET['id'];
        $testimonial = get_testimonial_by_id($testimonial_id, $pdo);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comment = $_POST['comment'];

            update_testimonial($testimonial_id, $comment, $pdo);
            header('Location: /admin/testimonials');
            exit;
        }
        require 'app/views/admin/testimonials_edit.php';
        break;

    case 'delete':
        $testimonial_id = $_GET['id'];
        delete_testimonial($testimonial_id, $pdo);
        header('Location: /admin/testimonials');
        exit;

    default:
        abort(404);
}
