<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 - Unauthorized | ITThink</title>
    <script src="/libs/tailwindcss.js"></script>
    <link rel="stylesheet" href="/styles/font.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="bg-gray-50 font-gabarito">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="text-center space-y-6 max-w-lg">
            <!-- Fun 401 Illustration -->
            <div class="relative">
                <span class="material-icons text-[150px] text-red-100">gpp_bad</span>
                <span class="material-icons absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-6xl text-red-500 animate-pulse">
                    lock
                </span>
            </div>

            <!-- Error Message -->
            <div class="space-y-2">
                <h1 class="text-6xl font-bold text-gray-900">401</h1>
                <h2 class="text-2xl font-semibold text-gray-700">Access Denied</h2>
                <p class="text-gray-500 mt-2">
                    Sorry! You don't have permission to access this area.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                <a href="javascript:history.back()" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <span class="material-icons mr-2 text-sm">arrow_back</span>
                    Go Back
                </a>
                <a href="/" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <span class="material-icons mr-2 text-sm">home</span>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html> 