<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Welcome, {{ Auth::user()->name }}!</h1>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Employer Dashboard</h2>
            <p class="text-gray-600 mb-4">Manage your job posts and applications.</p>
            <div class="flex space-x-4 mb-6">
                <a href="{{ route('employer.posts') }}"
                    class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                    View & Create Job Posts
                </a>
            </div>

            <!-- List of Job Posts with Applicants Link -->
            <h3 class="text-lg font-semibold mb-4">Your Job Posts</h3>
            @if (Auth::user()->employer && Auth::user()->employer->posts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="py-2 px-4">Title</th>
                                <th class="py-2 px-4">Description</th>
                                <th class="py-2 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Auth::user()->employer->posts as $post)
                                <tr class="border-b">
                                    <td class="py-2 px-4">{{ $post->title }}</td>
                                    <td class="py-2 px-4">{{ Str::limit($post->description, 50) }}</td>
                                    <td class="py-2 px-4">
                                        <a href="{{ route('employer.applications.index', $post) }}"
                                            class="text-blue-600 hover:underline">View Applicants</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600">You have no job posts yet.</p>
            @endif
        </div>
        <!-- Accepted Applicants Table -->
        <h3 class="text-lg font-semibold mb-4">Accepted Applicants</h3>
        @php
            $acceptedApplicants = collect();
            if (Auth::user()->employer) {
                foreach (Auth::user()->employer->posts as $post) {
                    foreach ($post->applications->where('status', 'accepted') as $application) {
                        $acceptedApplicants->push($application);
                    }
                }
            }
        @endphp

        @if ($acceptedApplicants->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-green-200">
                            <th class="py-2 px-4">Seeker Name</th>
                            <th class="py-2 px-4">Applied Post</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($acceptedApplicants as $app)
                            <tr class="border-b">
                                <td class="py-2 px-4">{{ $app->seeker->user->name ?? 'N/A' }}</td>
                                <td class="py-2 px-4">{{ $app->post->title }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">No applicants have been accepted yet.</p>
        @endif
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