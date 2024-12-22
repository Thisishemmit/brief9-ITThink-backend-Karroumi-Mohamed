<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Project - <?= htmlspecialchars($project['title']) ?></title>
    <script src="/libs/tailwindcss.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                <a href="/client/projects/<?= $project['id_project'] ?>" class="hover:text-gray-700">
                    <?= htmlspecialchars($project['title']) ?>
                </a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">Edit</span>
            </nav>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Project</h1>

                <form method="POST" class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="<?= htmlspecialchars($project['title']) ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <?php if (isset($errors['title'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?= $errors['title'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category_id"
                                id="category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                onchange="loadSubcategories(this.value)">
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id_category'] ?>"
                                        <?= $category['id_category'] == $project['id_category'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['category_id'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?= $errors['category_id'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="subcategory_id" class="block text-sm font-medium text-gray-700">Subcategory (Optional)</label>
                        <select name="subcategory_id"
                                id="subcategory_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select a subcategory</option>
                            <?php foreach ($subcategories as $subcategory): ?>
                                <option value="<?= $subcategory['id_subcategory'] ?>"
                                        <?= $subcategory['id_subcategory'] == $project['id_subcategory'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($subcategory['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description"
                                  id="description"
                                  rows="6"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"><?= htmlspecialchars($project['description']) ?></textarea>
                        <?php if (isset($errors['description'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?= $errors['description'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="/client/projects/<?= $project['id_project'] ?>"
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
    function loadSubcategories(categoryId) {
        if (!categoryId) {
            document.getElementById('subcategory_id').innerHTML = '<option value="">Select a subcategory</option>';
            return;
        }

        fetch(`/client/projects/get_subcategories?category_id=${categoryId}`)
            .then(response => response.json())
            .then(subcategories => {
                const select = document.getElementById('subcategory_id');
                select.innerHTML = '<option value="">Select a subcategory</option>';

                subcategories.forEach(subcategory => {
                    const option = document.createElement('option');
                    option.value = subcategory.id;
                    option.textContent = subcategory.name;
                    if (subcategory.id == <?= json_encode($project['id_subcategory']) ?>) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                });
            });
    }
    </script>
</body>
</html>
