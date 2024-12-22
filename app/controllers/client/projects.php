<?php
require_once __DIR__ . '/../../models/project.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../helpers/database.php';

$pdo = create_database();

require_auth();
if (!check_role(['client'])) {
    http_response_code(401);
    require __DIR__ . '/../../views/errors/401.php';
    die();
}

$user_id = $_SESSION['user']['id_user'];
$projects = get_client_projects($user_id, $pdo);

require __DIR__ . '/../../views/client/projects.php';
