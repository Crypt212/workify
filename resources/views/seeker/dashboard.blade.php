<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seeker Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Welcome, {{ Auth::user()->name }}!</h1>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Seeker Dashboard</h2>
            <p class="text-gray-600 mb-4">Manage your job application.</p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition">
                Logout
            </button>
        </form>
    </div>
</body>

</html>