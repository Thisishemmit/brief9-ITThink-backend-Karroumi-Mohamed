<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <script src="libs/tailwindcss.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body class="bg-gray-51">
    <button data-toggle-sidebar class="lg:hidden fixed top-5 left-4 z-50 p-2 rounded-lg bg-white shadow-lg">
        <span class="material-icons">menu</span>
    </button>

    <?php include __DIR__ . '/components/dashboard/sidebar.php'; ?>

    <?php include __DIR__ . '/client/dashboard.php'; ?>
</body>

</html>
