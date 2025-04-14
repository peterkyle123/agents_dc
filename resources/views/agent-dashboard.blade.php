<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard</title>
    @vite('resources/css/app.css')
    <link href="https://unpkg.com/tailwindcss@^3.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md text-center">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Welcome, Agent!</h2>
        <p class="text-gray-600 mb-4">You are now logged in to your dashboard.</p>

        <form action="{{ route('agent.logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Logout
            </button>
        </form>
    </div>
</body>
</html>
