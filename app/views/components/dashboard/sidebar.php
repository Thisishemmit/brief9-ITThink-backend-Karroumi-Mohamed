<?php
require_once __DIR__ . '/../../../helpers/logs.php';
// Load sidebar configuration
$sidebarConfig = require __DIR__ . '/../../../config/sidebar.php';
require_once __DIR__ . '/../../../helpers/auth.php';
// Get current user role (you'll need to implement this based on your auth system)
$userRole = getCurrentUserRole();
echo "<script>console.log('userRole: " . $userRole . "');</script>";
// Get menu items for current role
console_log($sidebarConfig);
$menuItems = $sidebarConfig[$userRole] ?? [];
$menuItems = array_merge($sidebarConfig['all'], $menuItems);

$currentRoute = $_SERVER['REQUEST_URI'];
?>

<aside class="fixed left-0 top-0 z-40 h-screen w-64 transition-transform bg-white border-r border-gray-200">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <div class="flex items-center mb-5 px-2">
            <span class="self-center text-xl font-semibold font-gabarito">ITThink</span>
        </div>

        <ul class="space-y-2 font-medium">
            <?php foreach ($menuItems as $route => $item): ?>
                <?php
                $isActive = $currentRoute === $route;
                $activeClass = $isActive ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100';
                ?>

                <li>
                    <a href="<?= htmlspecialchars($route) ?>"
                       class="flex items-center p-2 rounded-lg <?= $activeClass ?> transition-colors duration-200">
                        <span class="material-icons w-5 h-5 mr-2 text-inherit">
                            <?= htmlspecialchars($item['icon']) ?>
                        </span>
                        <span><?= htmlspecialchars($item['name']) ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <span class="material-icons w-8 h-8 rounded-full bg-gray-100 p-1">
                        account_circle
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        <?= htmlspecialchars(getCurrentUserName()) ?> <!-- Implement this function -->
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        <?= htmlspecialchars(ucfirst($userRole)) ?>
                    </p>
                </div>
                <a href="/logout" class="text-gray-500 hover:text-gray-700">
                    <span class="material-icons">logout</span>
                </a>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Menu Overlay -->
<div class="lg:hidden">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 z-30 sidebar-overlay hidden"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle functionality
    const toggleButton = document.querySelector('[data-toggle-sidebar]');
    const sidebar = document.querySelector('aside');
    const overlay = document.querySelector('.sidebar-overlay');

    if (toggleButton && sidebar && overlay) {
        toggleButton.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    }

    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
});
</script>
