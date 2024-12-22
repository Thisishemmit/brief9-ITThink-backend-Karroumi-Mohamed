<!DOCTYPE html
<html lang="en">

<head>
    <title><?= htmlspecialchars($project['title']) ?> - Project Details</title>
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
                <a href="/freelancer/projects" class="hover:text-gray-700">Available Projects</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900"><?= htmlspecialchars($project['title']) ?></span>
            </nav>

            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">
                            <?= htmlspecialchars($project['title']) ?>
                        </h1>
                        <div class="flex items-center text-sm text-gray-500">
                            <span class="material-icons mr-1 text-sm">calendar_today</span>
                            Posted <?= date('M d, Y', strtotime($project['created_at'])) ?>
                            <span class="mx-2">•</span>

                            <span class="material-icons mr-1 text-sm">person</span>
                            <?= htmlspecialchars($project['client_name']) ?>
                            <span class="mx-2">•</span>

                            <span class="material-icons mr-1 text-sm">category</span>
                            <?= htmlspecialchars($project['category_name']) ?>
                            <?php if ($project['subcategory_name']): ?>
                                / <?= htmlspecialchars($project['subcategory_name']) ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <?php if (!$already_made_offer && $project['status'] === 'open'): ?>
                            <button onclick="openOfferModal('submit')"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <span class="material-icons mr-2">local_offer</span>
                                Make Offer
                            </button>
                        <?php elseif ($already_made_offer): ?>
                            <button onclick="openOfferModal('update')"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <span class="material-icons mr-2">edit</span>
                                Manage Offer
                            </button>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                <?php 
                                    switch($offer['status']) {
                                        case 'accepted':
                                            echo 'bg-green-100 text-green-800';
                                            break;
                                        case 'rejected':
                                            echo 'bg-red-100 text-red-800';
                                            break;
                                        default:
                                            echo 'bg-yellow-100 text-yellow-800';
                                    }
                                ?>">
                                <span class="material-icons text-sm mr-1">
                                    <?php 
                                        switch($offer['status']) {
                                            case 'accepted':
                                                echo 'check_circle';
                                                break;
                                            case 'rejected':
                                                echo 'cancel';
                                                break;
                                            default:
                                                echo 'pending';
                                        }
                                    ?>
                                </span>
                                <?= ucfirst($offer['status'] ?? 'pending') ?>
                            </span>
                        <?php endif; ?>

                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            <?= $project['status'] === 'open'
                                ? 'bg-green-100 text-green-800'
                                : 'bg-yellow-100 text-yellow-800' ?>">
                            <span class="material-icons text-sm mr-1">
                                <?= $project['status'] === 'open' ? 'lock_open' : 'lock' ?>
                            </span>
                            <?= ucfirst($project['status']) ?>
                        </span>
                    </div>
                </div>

                <div class="prose max-w-none mt-6">
                    <p class="text-gray-700 whitespace-pre-line">
                        <?= htmlspecialchars($project['description']) ?>
                    </p>
                </div>

                <?php if ($already_made_offer): ?>
                <div class="mt-8 border-t pt-6">
                    <h2 class="text-lg font-semibold mb-4">Your Offer Details</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Amount</p>
                                <p class="font-medium">$<?= number_format($offer['amount'], 2) ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Deadline</p>
                                <p class="font-medium"><?= date('M d, Y', strtotime($offer['deadline'])) ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Submitted</p>
                                <p class="font-medium"><?= date('M d, Y', strtotime($offer['created_at'])) ?></p>
                            </div>
                        </div>
                        <?php if (!empty($offer['description'])): ?>
                            <div class="mt-4">
                                <p class="text-sm text-gray-500">Description</p>
                                <p class="mt-1"><?= nl2br(htmlspecialchars($offer['description'])) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Offer Modal -->
    <div id="offerModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4" id="modalTitle">Submit Your Offer</h3>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" id="formAction" value="offer">

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Price (USD)</label>
                        <input type="number"
                            id="amount"
                            name="amount"
                            required
                            min="1"
                            step="0.01"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            value="<?= $already_made_offer ? htmlspecialchars($offer['amount']) : '' ?>">
                    </div>

                    <div>
                        <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
                        <input type="date"
                            id="deadline"
                            name="deadline"
                            required
                            min="<?= date('Y-m-d') ?>"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            value="<?= $already_made_offer ? date('Y-m-d', strtotime($offer['deadline'])) : '' ?>">
                    </div>

                    <div class="flex justify-end gap-3 mt-5">
                        <button type="button" onclick="closeOfferModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <span id="submitButtonText">Submit Offer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openOfferModal(mode) {
            const modal = document.getElementById('offerModal');
            const modalTitle = document.getElementById('modalTitle');
            const formAction = document.getElementById('formAction');
            const submitButtonText = document.getElementById('submitButtonText');
            
            modal.classList.remove('hidden');
            
            if (mode === 'update') {
                modalTitle.textContent = 'Update Your Offer';
                formAction.value = 'update_offer';
                submitButtonText.textContent = 'Update Offer';
            } else {
                modalTitle.textContent = 'Submit Your Offer';
                formAction.value = 'offer';
                submitButtonText.textContent = 'Submit Offer';
            }
        }

        function closeOfferModal() {
            document.getElementById('offerModal').classList.add('hidden');
        }
    </script>

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

        // Close modal when clicking outside
        document.getElementById('offerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeOfferModal();
            }
        });
    </script>
</body>

</html>