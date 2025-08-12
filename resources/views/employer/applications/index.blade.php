<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicants for {{ $post->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-4">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">
            Applicants for "{{ $post->title }}"
        </h1>

        @if ($applications->count() > 0)
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="p-3">Name</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr class="border-b">
                            <td class="p-3">{{ $application->seeker->user->name }}</td>
                            <td class="p-3">{{ $application->seeker->user->email }}</td>
                            <td class="p-3 capitalize">{{ $application->status }}</td>
                            <td class="p-3 space-x-2">
                                <form action="{{ route('employer.applications.accept', $application) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                        Accept
                                    </button>
                                </form>
                                <form action="{{ route('employer.applications.reject', $application) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        Reject
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $applications->links() }}
            </div>
        @else
            <p class="text-gray-600">No applicants yet for this post.</p>
        @endif

        <div class="mt-6">
            <a href="{{ route('employer.dashboard') }}" class="text-blue-600 hover:underline">← Back to Dashboard</a>
        </div>
    </div>
</body>

</html>