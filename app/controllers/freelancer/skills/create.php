<?php
require_once __DIR__ . '/../../../models/skill.php';
require_once __DIR__ . '/../../../models/user.php';
require_once __DIR__ . '/../../../helpers/auth.php';
require_once __DIR__ . '/../../../helpers/database.php';

require_auth();
if (!check_role(['freelancer'])) {
    abort(401);
}

$pdo = create_database();
$user_id = $_SESSION['user']['id_user'];

// Get freelancer ID
$freelancer = get_freelancer_by_user_id($user_id, $pdo);
if (!$freelancer) {
    header('Location: /freelancer/projects');
    exit;
}

// Validate input
if (!isset($_POST['name']) || empty(trim($_POST['name']))) {
    set_error('create_skill', 'Please provide a skill name');
    header('Location: /freelancer/skills');
    exit;
}

$name = trim($_POST['name']);

// Create skill
if (create_skill($name, $freelancer['id_freelancer'], $pdo)) {
    header('Location: /freelancer/skills');
    exit;
} else {
    set_error('create_skill', 'Failed to create skill');
    header('Location: /freelancer/skills');
    exit;
}
