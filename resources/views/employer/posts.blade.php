<x-wrapper>
    <div class="flex justify-between items-center p-6">
        <h1 class="text-2xl font-bold">My Job Posts</h1>
        <a href="{{ route('employer.posts.create') }}"
            class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
            Create New Post
        </a>
    </div>

    <x-filter :filters="[
        'title' => ['label' => 'Post Title'],
        'tags' => ['label' => 'Post Tags'],
        'skills' => ['label' => 'Post Skills'],
    ]" />

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(count($posts) == 0)
        <p class="text-gray-600 text-center">No posts found. Create your first job post!</p>
    @else
        <!-- Top pagination -->
        <div class="mt-6">
            {{ $posts->withQueryString()->links('components/paginator') }}
        </div>

        <div class="grid gap-4">
            @foreach($posts as $post)
            <div class="bg-white rounded-lg shadow-md p-6 relative">
                <!-- Delete Button -->
                <form method="POST" action="{{ route('employer.posts.destroy', $post->id) }}" class="absolute top-4 right-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Are you sure you want to delete this post?')"
                            class="text-red-600 hover:text-red-800 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>

                <h2 class="text-xl font-semibold pr-8">{{ $post->title }}</h2>
                <p class="text-gray-600 mt-2">{{ $post->description }}</p>

                @if(count($post->tags) > 0)
                <div class="mt-4">
                    <span class="text-gray-700 font-medium">Tags:</span>
                    @foreach($post->tags as $tag)
                    <span class="text-blue-600 bg-white border border-blue-600 py-1 px-2 ml-1 mr-1 rounded-lg hover:bg-gray-100 transition">
                        {{ $tag }}
                    </span>
                    @endforeach
                </div>
                @endif

                @if(count($post->skills) > 0)
                <div class="mt-4">
                    <span class="text-gray-700 font-medium">Skills:</span>
                    @foreach($post->skills as $skill)
                    <span class="text-green-600 bg-white border border-green-600 py-1 px-2 ml-1 mr-1 rounded-lg hover:bg-gray-100 transition">
                        {{ $skill }}
                    </span>
                    @endforeach
                </div>
                @endif

                <div class="mt-4 text-sm text-gray-500">
                    Posted on {{ $post->created_at }}
                </div>
            </div>
            @endforeach
        </div>

        <!-- Bottom pagination -->
        <div class="mt-6">
            {{ $posts->withQueryString()->links('components/paginator') }}
        </div>
    @endif
</x-wrapper>
