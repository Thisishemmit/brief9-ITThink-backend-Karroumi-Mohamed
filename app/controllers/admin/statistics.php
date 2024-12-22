<?php

require_once 'app/helpers/auth.php';
require_once 'app/helpers/database.php';
require_once 'app/models/statistics.php';

require_auth();
check_authorization(['admin']);

$pdo = create_database();

$action = $_GET['action'] ?? 'view';

switch ($action) {
    case 'view':
        $statistics = get_statistics($pdo);
        require 'app/views/admin/statistics.php';
        break;

    default:
        abort(404);
}
