<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <?php if (has_error('login')) : ?>
        <p style="color: red;"><?= get_error('login') ?></p>
    <?php endif; ?>
    <h2>Login</h2>
    <form method="POST" action="/login">
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>

</html>
