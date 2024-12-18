<!-- app/views/index.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
</head>

<body>
    <h1>Welcome to the Home Page</h1>
    <?php if (isset($_SESSION['user'])): ?>
        <p>Hello, <?php echo htmlspecialchars($_SESSION['user']); ?>!</p>
        <a href="/logout">Logout</a>
    <?php else: ?>
        <p><a href="/login">Login</a> | <a href="/register">Register</a></p>
    <?php endif; ?>
</body>

</html>
