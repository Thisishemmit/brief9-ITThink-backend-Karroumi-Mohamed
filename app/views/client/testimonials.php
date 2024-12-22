<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Testimonials</title>
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
                <h1 class="text-2xl font-bold text-gray-900">My Testimonials</h1>
                <button onclick="openAddModal()" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <span class="material-icons mr-2">add</span>
                    Add Testimonial
                </button>
            </div>

            <?php if (empty($testimonials)): ?>
                <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
                    You haven't written any testimonials yet.
                </div>
            <?php else: ?>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($testimonials as $testimonial): ?>
                        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <span class="material-icons text-gray-400 text-sm mr-2">person</span>
                                    <span class="font-medium text-gray-900">
                                        <?= htmlspecialchars($testimonial['freelancer_name']) ?>
                                    </span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <span class="material-icons text-gray-400 text-sm mr-1">schedule</span>
                                    <?= date('M d, Y', strtotime($testimonial['created_at'])) ?>
                                </div>
                            </div>

                            <p class="text-gray-600 mb-4">
                                <?= nl2br(htmlspecialchars($testimonial['comment'])) ?>
                            </p>

                            <div class="flex justify-end space-x-2">
                                <button onclick="openEditModal(<?= $testimonial['id_testimonial'] ?>, '<?= addslashes($testimonial['comment']) ?>')"
                                        class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                    Edit
                                    <span class="material-icons ml-1 text-sm">edit</span>
                                </button>
                                <form method="POST" action="/client/testimonials/<?= $testimonial['id_testimonial'] ?>/delete" 
                                      class="inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all">
                                        Delete
                                        <span class="material-icons ml-1 text-sm">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Add Testimonial Modal -->
    <div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Testimonial</h3>
                <form method="POST" action="/client/testimonials/create">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="freelancer">
                            Freelancer
                        </label>
                        <select name="freelancer_id" id="freelancer" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <?php foreach ($freelancers as $freelancer): ?>
                                <option value="<?= $freelancer['id_user'] ?>">
                                    <?= htmlspecialchars($freelancer['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="comment">
                            Comment
                        </label>
                        <textarea name="comment" id="comment" rows="4" required
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeAddModal()"
                                class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Testimonial Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Testimonial</h3>
                <form id="editForm" method="POST">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="edit_comment">
                            Comment
                        </label>
                        <textarea name="comment" id="edit_comment" rows="4" required
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeEditModal()"
                                class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function openEditModal(id, comment) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            const commentField = document.getElementById('edit_comment');
            
            form.action = `/client/testimonials/${id}/edit`;
            commentField.value = comment;
            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const addModal = document.getElementById('addModal');
            const editModal = document.getElementById('editModal');
            if (event.target === addModal) {
                closeAddModal();
            }
            if (event.target === editModal) {
                closeEditModal();
            }
        }

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
