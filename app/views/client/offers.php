<!DOCTYPE html>
<html lang="en">
<head>
    <title>Received Offers</title>
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
                <h1 class="text-2xl font-bold text-gray-900">Received Offers</h1>
            </div>

            <?php if (empty($offers)): ?>
                <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
                    You haven't received any offers yet.
                    <a href="/client/projects/create" class="text-blue-600 hover:text-blue-700 ml-1">Create a new project</a>
                </div>
            <?php else: ?>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($offers as $offer): ?>
                        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h2 class="text-lg font-semibold text-gray-900">
                                    <?= htmlspecialchars($offer['project_title']) ?>
                                </h2>
                                <span class="px-2 py-1 text-xs rounded-full <?= 
                                    $offer['status'] === 'accepted' ? 'bg-green-100 text-green-800' : 
                                    ($offer['status'] === 'rejected' ? 'bg-red-100 text-red-800' : 
                                    'bg-yellow-100 text-yellow-800') ?>">
                                    <?= ucfirst($offer['status']) ?>
                                </span>
                            </div>

                            <div class="text-xs text-gray-500 space-y-1 mb-3">
                                <div class="flex items-center">
                                    <span class="material-icons text-gray-400 text-sm mr-1">person</span>
                                    <?= htmlspecialchars($offer['freelancer_name']) ?>
                                </div>
                                <div class="flex items-center">
                                    <span class="material-icons text-gray-400 text-sm mr-1">mail</span>
                                    <?= htmlspecialchars($offer['freelancer_email']) ?>
                                </div>
                                <div class="flex items-center">
                                    <span class="material-icons text-gray-400 text-sm mr-1">attach_money</span>
                                    $<?= number_format($offer['price'], 2) ?>
                                </div>
                                <div class="flex items-center">
                                    <span class="material-icons text-gray-400 text-sm mr-1">schedule</span>
                                    <?= date('M d, Y', strtotime($offer['created_at'])) ?>
                                </div>
                                <?php if (isset($offer['deadline'])): ?>
                                <div class="flex items-center">
                                    <span class="material-icons text-gray-400 text-sm mr-1">event</span>
                                    Deadline: <?= date('M d, Y', strtotime($offer['deadline'])) ?>
                                </div>
                                <?php endif; ?>
                            </div>

                            <?php if ($offer['status'] === 'pending'): ?>
                                <div class="flex justify-end space-x-2">
                                    <form method="POST" action="/client/offers/<?= $offer['id_offer'] ?>/accept" class="inline">
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                                            Accept
                                            <span class="material-icons ml-1 text-sm">check</span>
                                        </button>
                                    </form>
                                    <form method="POST" action="/client/offers/<?= $offer['id_offer'] ?>/reject" class="inline">
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all">
                                            Reject
                                            <span class="material-icons ml-1 text-sm">close</span>
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
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
