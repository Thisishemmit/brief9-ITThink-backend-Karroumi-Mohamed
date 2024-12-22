<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Project - Dashboard</title>
    <script src="/libs/tailwindcss.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="bg-gray-51">
    <button data-toggle-sidebar class="lg:hidden fixed top-5 left-4 z-50 p-2 rounded-lg bg-white shadow-lg">
        <span class="material-icons">menu</span>
    </button>

    <?php include __DIR__ . '/../../components/dashboard/sidebar.php'; ?>

    <main class="lg:ml-64 p-4">
        <div class="container mx-auto max-w-3xl">
            <div class="flex items-center mb-6">
                <a href="/client/projects" class="mr-4 text-gray-500 hover:text-gray-700">
                    <span class="material-icons">arrow_back</span>
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Create New Project</h1>
            </div>

            <?php if (!empty($errors['general'])): ?>
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <?= htmlspecialchars($errors['general']) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="bg-white rounded-lg shadow-md p-6">
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Project Title</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?= !empty($errors['title']) ? 'border-red-500' : '' ?>"
                           placeholder="Enter project title">
                    <?php if (!empty($errors['title'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?= htmlspecialchars($errors['title']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Project Description</label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?= !empty($errors['description']) ? 'border-red-500' : '' ?>"
                              placeholder="Describe your project"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                    <?php if (!empty($errors['description'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?= htmlspecialchars($errors['description']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="mb-6">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="category_id" 
                            name="category_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?= !empty($errors['category_id']) ? 'border-red-500' : '' ?>">
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id_category'] ?>" 
                                    <?= (isset($_POST['category_id']) && $_POST['category_id'] == $category['id_category']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['category_id'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?= htmlspecialchars($errors['category_id']) ?></p>
                    <?php endif; ?>
                </div>

                <div id="subcategory-container" class="mb-6" style="display: none;">
                    <label for="subcategory_id" class="block text-sm font-medium text-gray-700 mb-2">Subcategory</label>
                    <select id="subcategory_id" 
                            name="subcategory_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select a subcategory (optional)</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="/client/projects" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Create Project
                    </button>
                </div>
            </form>
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

        // Category change handler
        const categorySelect = document.getElementById('category_id');
        const subcategoryContainer = document.getElementById('subcategory-container');
        const subcategorySelect = document.getElementById('subcategory_id');

        if (categorySelect) {
            categorySelect.addEventListener('change', function() {
                const categoryId = this.value;
                
                if (!categoryId) {
                    subcategoryContainer.style.display = 'none';
                    return;
                }

                // Fetch subcategories
                fetch(`/client/projects/get_subcategories?category_id=${categoryId}`)
                    .then(response => response.json())
                    .then(subcategories => {
                        // Clear existing options
                        subcategorySelect.innerHTML = '<option value="">Select a subcategory (optional)</option>';
                        
                        // Add new options
                        subcategories.forEach(subcategory => {
                            const option = document.createElement('option');
                            option.value = subcategory.id_subcategory;
                            option.textContent = subcategory.name;
                            subcategorySelect.appendChild(option);
                        });

                        // Show subcategory select
                        subcategoryContainer.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error fetching subcategories:', error);
                        subcategoryContainer.style.display = 'none';
                    });
            });
        }
    });
    </script>
</body>
</html>
