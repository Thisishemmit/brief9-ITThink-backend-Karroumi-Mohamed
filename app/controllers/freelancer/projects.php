<?php
require_once __DIR__ . '/../../models/project.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/database.php';

require_auth();
if (!check_role(['freelancer'])) {
    abort(401);
}

$pdo = create_database();
$projects = get_available_projects($pdo);
function is_project_open($project){
    if($project['status'] === 'open') return true;
}
$projects = array_filter($projects, 'is_project_open');

require __DIR__ . '/../../views/freelancer/projects.php';
