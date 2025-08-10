<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Job Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-4">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Your Job Posts</h1>
            <a href="{{ route('employer.posts.create') }}"
                class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                Create New Post
            </a>
        </div>

        @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
        @endif

        @if(count($posts) == 0)
        <p class="text-gray-600 text-center">No posts found. Create your first job post!</p>
        @else
        <div class="grid gap-4">
            @foreach($posts as $post)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold">{{ $post['title'] }}</h2>
                <p class="text-gray-600 mt-2">{{ $post['description'] }}</p>
                @if(count($post['tags']) > 0)
                <div class="mt-4">
                    <span class="text-gray-700 font-medium">Tags:</span>
                    @foreach($post['tags'] as $tag)
                    <span
                        class="text-blue-600 bg-white border border-blue-600 py-1 px-2 ml-1 mr-1 rounded-lg hover:bg-gray-100 transition">{{
                        $tag }}</span>
                    @endforeach
                </div>
                @endif
                @if(count($post['skills']) > 0)
                <div class="mt-4">
                    <span class="text-gray-700 font-medium">Skills:</span>
                    @foreach($post['skills'] as $skill)
                    <span
                        class="text-green-600 bg-white border border-green-600 py-1 px-2 ml-1 mr-1 rounded-lg hover:bg-gray-100 transition">{{
                        $skill }}</span>
                    @endforeach
                </div>
                @endif
                <div class="mt-4 text-sm text-gray-500">
                    Posted on {{ $post['created_at'] }}
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('employer.dashboard') }}"
                class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition">
                Back to Dashboard
            </a>
        </div>
    </div>
</body>

</html>
