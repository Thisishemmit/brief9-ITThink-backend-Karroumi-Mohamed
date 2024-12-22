<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Projects - Dashboard</title>
    <script src="/libs/tailwindcss.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="bg-gray-51">
    <button data-toggle-sidebar class="lg:hidden fixed top-5 left-4 z-50 p-2 rounded-lg bg-white shadow-lg">
        <span class="material-icons">menu</span>
    </button>

    <?php include __DIR__ . '/../components/dashboard/sidebar.php'; ?>

    <main class="lg:ml-64 p-4">
        <div class="container mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">My Projects</h1>
                <a href="/client/projects/create" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 inline-flex items-center">
                    <span class="material-icons mr-2">add</span>
                    New Project
                </a>
            </div>

            <?php if (empty($projects)): ?>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <span class="material-icons text-gray-400 text-5xl mb-4">work_outline</span>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">No Projects Yet</h2>
                    <p class="text-gray-600 mb-4">Start by creating your first project</p>
                    <a href="/client/projects/create" 
                       class="inline-flex items-center text-blue-600 hover:text-blue-700">
                        <span class="material-icons mr-2">add_circle</span>
                        Create Project
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($projects as $project): ?>
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-xl font-semibold text-gray-900 truncate">
                                        <?= htmlspecialchars($project['title']) ?>
                                    </h2>
                                </div>
                                
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    <?= htmlspecialchars($project['description']) ?>
                                </p>
                                
                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <span class="material-icons mr-1 text-sm">category</span>
                                    <?= htmlspecialchars($project['category_name'] ?? 'Uncategorized') ?>
                                    <?php if ($project['subcategory_name']): ?>
                                        <span class="mx-2">•</span>
                                        <?= htmlspecialchars($project['subcategory_name']) ?>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">
                                        <?= date('M d, Y', strtotime($project['created_at'])) ?>
                                    </span>
                                    <a href="/client/projects/<?= $project['id_project'] ?>" 
                                       class="text-blue-600 hover:text-blue-700 inline-flex items-center">
                                        View Details
                                        <span class="material-icons ml-1 text-sm">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

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
</body>
</html>