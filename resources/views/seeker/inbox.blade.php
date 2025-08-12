<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seeker Inbox</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-5xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">📬 Inbox</h1>

    <!-- Filters -->
 <form method="GET" action="{{ route('seeker.inbox') }}" class="mb-6 bg-white p-4 rounded-lg shadow flex gap-4">
    <input type="text" name="employer_name" placeholder="Employer Name"
           value="{{ request('employer_name') }}"
           class="border p-2 rounded w-1/4">
    <input type="email" name="email" placeholder="Employer Email"
           value="{{ request('email') }}"
           class="border p-2 rounded w-1/4">
    <input type="date" name="date" value="{{ request('date') }}"
           class="border p-2 rounded w-1/4">
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
</form>

    <!-- Messages -->
    @foreach($messages as $message)
        <div class="bg-white p-5 mb-4 rounded-lg shadow border border-gray-200">
            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-3 mb-3">
                <div>
                    <h2 class="text-lg font-semibold">{{ $message->employer->user->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $message->employer->user->email }}</p>
                </div>
            <a href="{{ route('seekers.profile.byEmail', $message->employer->user->email) }}" class="text-blue-600 hover:underline">View Profile</a>

            </div>
            <!-- Body -->
            <p class="text-gray-700 mb-3">{{ Str::limit($message->body, 150) }}</p>
            <p class="text-xs text-gray-400">Sent: {{ $message->created_at->format('Y-m-d H:i') }}</p>
        </div>
    @endforeach

    <!-- Pagination -->
    <div class="mt-6">
        {{ $messages->withQueryString()->links() }}
    </div>
</div>

</body>
</html>
