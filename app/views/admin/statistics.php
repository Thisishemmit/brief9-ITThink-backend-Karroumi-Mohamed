<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Statistics</title>
    <script src="/libs/tailwindcss.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-51">
    <button data-toggle-sidebar class="lg:hidden fixed top-5 left-4 z-50 p-2 rounded-lg bg-white shadow-lg">
        <span class="material-icons">menu</span>
    </button>

    <?php include __DIR__ . '/../components/dashboard/sidebar.php'; ?>

    <main class="lg:ml-64 p-4">
        <div class="container mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Statistics</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Total Users</h2>
                    <p class="text-3xl font-bold text-gray-900"><?= $statistics['total_users'] ?></p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Total Projects</h2>
                    <p class="text-3xl font-bold text-gray-900"><?= $statistics['total_projects'] ?></p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Total Offers</h2>
                    <p class="text-3xl font-bold text-gray-900"><?= $statistics['total_offers'] ?></p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">User Growth</h2>
                <canvas id="userGrowthChart"></canvas>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Project Categories</h2>
                <canvas id="projectCategoriesChart"></canvas>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Offer Status</h2>
                <canvas id="offerStatusChart"></canvas>
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

        // User Growth Chart
        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        const userGrowthChart = new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_keys($statistics['user_growth'])) ?>,
                datasets: [{
                    label: 'User Growth',
                    data: <?= json_encode(array_values($statistics['user_growth'])) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Project Categories Chart
        const projectCategoriesCtx = document.getElementById('projectCategoriesChart').getContext('2d');
        const projectCategoriesChart = new Chart(projectCategoriesCtx, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode(array_keys($statistics['project_categories'])) ?>,
                datasets: [{
                    label: 'Project Categories',
                    data: <?= json_encode(array_values($statistics['project_categories'])) ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        // Offer Status Chart
        const offerStatusCtx = document.getElementById('offerStatusChart').getContext('2d');
        const offerStatusChart = new Chart(offerStatusCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_keys($statistics['offer_status'])) ?>,
                datasets: [{
                    label: 'Offer Status',
                    data: <?= json_encode(array_values($statistics['offer_status'])) ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
