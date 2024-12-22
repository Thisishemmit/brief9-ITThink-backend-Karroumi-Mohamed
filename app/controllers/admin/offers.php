<?php

require_once 'app/helpers/auth.php';
require_once 'app/helpers/database.php';
require_once 'app/models/offer.php';

require_auth();
check_authorization(['admin']);

$pdo = create_database();

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $offers = get_all_offers($pdo);
        require 'app/views/admin/offers.php';
        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project_id = $_POST['project_id'];
            $freelancer_id = $_POST['freelancer_id'];
            $price = $_POST['price'];
            $description = $_POST['description'];

            create_offer($project_id, $freelancer_id, $price, $description, $pdo);
            header('Location: /admin/offers');
            exit;
        }
        require 'app/views/admin/offers_create.php';
        break;

    case 'edit':
        $offer_id = $_GET['id'];
        $offer = get_offer_by_id($offer_id, $pdo);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $price = $_POST['price'];
            $description = $_POST['description'];

            update_offer($offer_id, $price, $description, $pdo);
            header('Location: /admin/offers');
            exit;
        }
        require 'app/views/admin/offers_edit.php';
        break;

    case 'delete':
        $offer_id = $_GET['id'];
        delete_offer($offer_id, $pdo);
        header('Location: /admin/offers');
        exit;

    default:
        abort(404);
}
