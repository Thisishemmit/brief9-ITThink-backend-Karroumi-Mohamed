<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - Testimonial Management</title>
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
                <h1 class="text-2xl font-bold text-gray-900">Testimonial Management</h1>
                <a href="/admin/testimonials?action=create"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 inline-flex items-center">
                    <span class="material-icons mr-2">add</span>
                    New Testimonial
                </a>
            </div>

            <?php if (empty($testimonials)): ?>
                <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
                    No testimonials found.
                </div>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Comment
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Freelancer
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($testimonials as $testimonial): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?= htmlspecialchars($testimonial['comment']) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                            <?= htmlspecialchars($testimonial['user_name']) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                            <?= htmlspecialchars($testimonial['freelancer_name']) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="/admin/testimonials?action=edit&id=<?= $testimonial['id_testimonial'] ?>"
                                           class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <form method="POST" action="/admin/testimonials?action=delete&id=<?= $testimonial['id_testimonial'] ?>" class="inline">
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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