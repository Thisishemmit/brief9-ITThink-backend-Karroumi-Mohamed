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

// Get skill ID from URL
preg_match('#^/freelancer/skills/([0-9]+)/delete$#', $path, $matches);
$skill_id = $matches[1];

// Get skill details
$skill = get_skill_by_id($skill_id, $pdo);
if (!$skill) {
    abort(404);
}

// Verify skill belongs to this freelancer
if ($skill['id_freelancer'] != $freelancer['id_freelancer']) {
    abort(403);
}

// Delete skill
if (delete_skill($skill_id, $pdo)) {
    header('Location: /freelancer/skills');
    exit;
} else {
    set_error('delete_skill', 'Failed to delete skill');
    header('Location: /freelancer/skills');
    exit;
}
