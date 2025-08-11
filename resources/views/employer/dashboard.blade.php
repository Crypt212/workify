<x-wrapper>
    <x-header />
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Employer Dashboard</h2>
            <p class="text-gray-600 mb-4">Manage your job posts and applications.</p>
            <a href="{{ route('employer.posts') }}"
                class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                View & Create Job Posts
            </a>
            <a href="{{ route('seekers.explore') }}"
                class="bg-blue-600 text-white py-2 px-4 rounded-lg ml-2 hover:bg-blue-700 transition">
                Explore Job Seekers
            </a>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition">
                Logout
            </button>
        </form>
    </div>
</x-wrapper>
