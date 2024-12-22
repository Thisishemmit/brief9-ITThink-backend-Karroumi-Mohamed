<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User</title>
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
                <h1 class="text-2xl font-bold text-gray-900">Edit User</h1>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <form method="POST" action="">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" id="role" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="client" <?= $user['role'] === 'client' ? 'selected' : '' ?>>Client</option>
                            <option value="freelancer" <?= $user['role'] === 'freelancer' ? 'selected' : '' ?>>Freelancer</option>
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
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
