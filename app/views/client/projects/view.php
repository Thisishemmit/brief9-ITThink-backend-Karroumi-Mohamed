<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= htmlspecialchars($project['title']) ?> - Project Details</title>
    <script src="/libs/tailwindcss.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-51">
    <button data-toggle-sidebar class="lg:hidden fixed top-5 left-4 z-50 p-2 rounded-lg bg-white shadow-lg">
        <span class="material-icons">menu</span>
    </button>

    <?php include __DIR__ . '/../../components/dashboard/sidebar.php'; ?>

    <main class="lg:ml-64 p-4">
        <div class="container mx-auto max-w-4xl">
            <nav class="flex items-center mb-6 text-gray-500 text-sm">
                <a href="/client/projects" class="hover:text-gray-700">Projects</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900"><?= htmlspecialchars($project['title']) ?></span>
            </nav>

            <!-- Project Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">
                            <?= htmlspecialchars($project['title']) ?>
                        </h1>
                        <div class="flex items-center text-sm text-gray-500">
                            <span class="material-icons mr-1 text-sm">calendar_today</span>
                            Created <?= date('M d, Y', strtotime($project['created_at'])) ?>
                            <span class="mx-2">•</span>
                            <span class="material-icons mr-1 text-sm">category</span>
                            <?= htmlspecialchars($project['category_name']) ?>
                            <?php if ($project['subcategory_name']): ?>
                                / <?= htmlspecialchars($project['subcategory_name']) ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <!-- Project Status Badge -->
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            <?= $project['status'] === 'open' 
                                ? 'bg-green-100 text-green-800' 
                                : 'bg-yellow-100 text-yellow-800' ?>">
                            <span class="material-icons text-sm mr-1">
                                <?= $project['status'] === 'open' ? 'lock_open' : 'lock' ?>
                            </span>
                            <?= ucfirst($project['status']) ?>
                        </span>

                        <!-- Actions Dropdown -->
                        <div class="relative inline-block">
                            <button type="button" 
                                    onclick="toggleDropdown()"
                                    class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                <span class="material-icons text-xl mr-2">settings</span>
                                Project Actions
                                <span class="material-icons text-xl ml-1">expand_more</span>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="dropdown" 
                                 class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1">
                                    <!-- Edit Option -->
                                    <a href="/client/projects/<?= $project['id_project'] ?>/edit" 
                                       class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <span class="material-icons text-gray-400 group-hover:text-blue-500 mr-3">edit</span>
                                        Edit Project
                                    </a>
                                    
                                    <!-- Status Toggle Option -->
                                    <form method="POST" class="contents">
                                        <input type="hidden" name="action" value="<?= $project['status'] === 'open' ? 'close' : 'reopen' ?>">
                                        <button type="submit" 
                                                class="group flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <span class="material-icons text-gray-400 group-hover:<?= $project['status'] === 'open' ? 'text-yellow-500' : 'text-green-500' ?> mr-3">
                                                <?= $project['status'] === 'open' ? 'lock' : 'lock_open' ?>
                                            </span>
                                            <?= $project['status'] === 'open' ? 'Close Project' : 'Reopen Project' ?>
                                        </button>
                                    </form>
                                    
                                    <!-- Delete Option -->
                                    <form method="POST" class="contents" onsubmit="return confirm('Are you sure you want to delete this project? This action cannot be undone.');">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" 
                                                class="group flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            <span class="material-icons text-red-400 group-hover:text-red-600 mr-3">delete</span>
                                            Delete Project
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="prose max-w-none mt-6">
                    <p class="text-gray-700 whitespace-pre-line">
                        <?= htmlspecialchars($project['description']) ?>
                    </p>
                </div>
            </div>

            <!-- Accepted Offers -->
            <?php if (!empty($accepted_offers)): ?>
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Selected Offer</h2>
                    <?php foreach ($accepted_offers as $offer): ?>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                            <div class="flex items-center mb-2">
                                <span class="material-icons text-green-600 mr-2">person</span>
                                <span class="font-medium text-gray-900"><?= htmlspecialchars($offer['freelancer_name']) ?></span>
                                <span class="ml-3 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Accepted</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div class="flex items-center text-sm text-gray-500">
                                    <span class="material-icons text-sm mr-1">payments</span>
                                    $<?= number_format($offer['price'], 2) ?>
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <span class="material-icons text-sm mr-1">event</span>
                                    <?= date('M d, Y', strtotime($offer['deadline'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Pending Offers -->
            <?php if (!empty($pending_offers) && $project['status'] === 'open'): ?>
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Pending Offers</h2>
                    <div class="space-y-4">
                        <?php foreach ($pending_offers as $offer): ?>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between">
                                    <div>
                                        <div class="flex items-center mb-2">
                                            <span class="material-icons text-gray-600 mr-2">person</span>
                                            <span class="font-medium text-gray-900"><?= htmlspecialchars($offer['freelancer_name']) ?></span>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="flex items-center text-sm text-gray-500">
                                                <span class="material-icons text-sm mr-1">payments</span>
                                                $<?= number_format($offer['price'], 2) ?>
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <span class="material-icons text-sm mr-1">event</span>
                                                <?= date('M d, Y', strtotime($offer['deadline'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <form method="POST">
                                            <input type="hidden" name="action" value="accept_offer">
                                            <input type="hidden" name="offer_id" value="<?= $offer['id_offer'] ?>">
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700">
                                                <span class="material-icons text-sm mr-1">check</span>
                                                Accept
                                            </button>
                                        </form>
                                        <form method="POST">
                                            <input type="hidden" name="action" value="reject_offer">
                                            <input type="hidden" name="offer_id" value="<?= $offer['id_offer'] ?>">
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700">
                                                <span class="material-icons text-sm mr-1">close</span>
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Rejected Offers -->
            <?php if (!empty($rejected_offers)): ?>
                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md p-6">
                    <button @click="open = !open" class="flex items-center justify-between w-full">
                        <h2 class="text-lg font-semibold text-gray-900">Rejected Offers</h2>
                        <span class="material-icons" :class="{ 'transform rotate-180': open }">expand_more</span>
                    </button>
                    <div x-show="open" class="mt-4 space-y-4">
                        <?php foreach ($rejected_offers as $offer): ?>
                            <div class="border border-gray-200 bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <span class="material-icons text-gray-600 mr-2">person</span>
                                    <span class="font-medium text-gray-900"><?= htmlspecialchars($offer['freelancer_name']) ?></span>
                                    <span class="ml-3 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-3">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <span class="material-icons text-sm mr-1">payments</span>
                                        $<?= number_format($offer['price'], 2) ?>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <span class="material-icons text-sm mr-1">event</span>
                                        <?= date('M d, Y', strtotime($offer['deadline'])) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <div class="lg:hidden">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 z-30 sidebar-overlay hidden"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('hidden');

            // Close dropdown when clicking outside
            document.addEventListener('click', function closeDropdown(e) {
                const isClickInside = dropdown.contains(e.target) || 
                                    e.target.closest('button')?.getAttribute('onclick') === 'toggleDropdown()';
                
                if (!isClickInside) {
                    dropdown.classList.add('hidden');
                    document.removeEventListener('click', closeDropdown);
                }
            });
        }
    </script>
</body>
</html>