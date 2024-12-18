<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | YourApp</title>
    <script src="/libs/tailwindcss.js"></script>
    <link rel="stylesheet" href="/styles/font.css">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>

<body class="bg-gray-50 font-gabarito">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-bold text-gray-900">Welcome back</h2>
                <p class="mt-2 text-sm text-gray-600">Please sign in to your account</p>
            </div>

            <?php if (has_error('login')) : ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                    <p class="text-red-700"><?= get_error('login') ?></p>
                </div>
            <?php endif; ?>

            <form class="mt-8 space-y-6" method="POST" action="/login">
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <input type="email" name="email" required 
                            class="mt-1 appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" required 
                            class="mt-1 appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Sign in
                    </button>
                </div>

                <p class="text-center text-sm text-gray-600">
                    Don't have an account? 
                    <a href="/register" class="font-medium text-blue-600 hover:text-blue-500">Sign up</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
