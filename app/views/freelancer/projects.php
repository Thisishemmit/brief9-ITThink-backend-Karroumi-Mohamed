<!DOCTYPE html>
<html lang="en">
<head>
    <title>Available Projects</title>
    <script src="/libs/tailwindcss.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="bg-gray-51">
    <button data-toggle-sidebar class="lg:hidden fixed top-5 left-4 z-50 p-2 rounded-lg bg-white shadow-lg">
        <span class="material-icons">menu</span>
    </button>

    <?php include __DIR__ . '/../components/dashboard/sidebar.php'; ?>

    <main class="lg:ml-64 p-4">
        <div class="container mx-auto max-w-6xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Available Projects</h1>
            </div>

            <?php if (empty($projects)): ?>
                <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
                    No projects available at the moment.
                </div>
            <?php else: ?>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($projects as $project): ?>
                        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-4">
                            <h2 class="text-lg font-semibold text-gray-900 mb-2">
                                <?= htmlspecialchars($project['title']) ?>
                            </h2>
                            
                            <p class="text-sm text-gray-600 mb-3">
                                <?= htmlspecialchars(substr($project['description'], 0, 50)) ?><?= strlen($project['description']) > 50 ? '...' : '' ?>
                            </p>

                            <div class="text-xs text-gray-500 space-y-1 mb-3">
                                <div class="flex items-center">
                                    <span class="material-icons text-gray-400 text-sm mr-1">person</span>
                                    <?= htmlspecialchars($project['client_name']) ?>
                                </div>
                                <div class="flex items-center">
                                    <span class="material-icons text-gray-400 text-sm mr-1">category</span>
                                    <?= htmlspecialchars($project['category_name']) ?>
                                    <?php if ($project['subcategory_name']): ?>
                                        <span class="mx-1">•</span>
                                        <?= htmlspecialchars($project['subcategory_name']) ?>
                                    <?php endif; ?>
                                </div>
                                <div class="flex items-center">
                                    <span class="material-icons text-gray-400 text-sm mr-1">schedule</span>
                                    <?= date('M d, Y', strtotime($project['created_at'])) ?>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="/freelancer/projects/<?= $project['id_project'] ?>" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                    View Details
                                    <span class="material-icons ml-1 text-sm">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <div class="lg:hidden">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 z-30 sidebar-overlay hidden"></div>
    </div>

    <script>
        // Toggle sidebar
        const sidebarToggle = document.querySelector('[data-toggle-sidebar]');
        const sidebar = document.querySelector('[data-sidebar]');
        const overlay = document.querySelector('.sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        sidebarToggle?.addEventListener('click', toggleSidebar);
        overlay?.addEventListener('click', toggleSidebar);
    </script>
</body>
</html>
