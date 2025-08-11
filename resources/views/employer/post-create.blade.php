<x-wrapper>
    <div class="bg-white rounded-lg shadow-md w-full max-w-2xl p-6">
        <h1 class="text-2xl font-bold text-center mb-6">Create a New Job Post</h1>

        @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('employer.posts.store') }}">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700 mb-2">Job Title</label>
                <input type="text" id="title" name="title" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('title') }}">
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    rows="6">{{ old('description') }}</textarea>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tags" class="block text-gray-700 mb-2">Tags</label>
                <x-tag-input :tags="[]" />
                @error('tags')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="skills" class="block text-gray-700 mb-2">Skills</label>
                <x-skill-input :skills="[]" />
                @error('skills')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end space-x-2">
                <a href="{{ route('employer.posts') }}"
                    class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                    Create Post
                </button>
            </div>
        </form>
    </div>
</x-wrapper>
