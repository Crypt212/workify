<!-- resources/views/employer/seeker-profile.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seeker Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto py-10">
        <!-- Profile Card -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex items-center space-x-6">
                <img src="{{ $seeker['avatar'] ?? 'https://via.placeholder.com/150' }}"
                     alt="Profile Picture"
                     class="w-32 h-32 rounded-full border">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $seeker['name'] }}</h1>
                    <p class="text-gray-600">{{ $seeker['role'] }}</p>
                    <p class="text-gray-500 mt-2">
                        Email: {{ $seeker['email'] }}
                    </p>
                </div>
            </div>

            <!-- Skills -->
            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Skills</h2>
                <div class="flex flex-wrap gap-2">
                    @if ($seeker['skills'])
                        {{ $seeker['skills'] }}
                    @else
                        <p class="text-gray-500">No skills listed</p>
                    @endif
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-8">
                <a href="{{ route('seekers.explore') }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                    ← Back to Explore
                </a>
            </div>
        </div>
    </div>

</body>
</html>
