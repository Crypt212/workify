<x-wrapper>
    <h1 class="text-3xl font-bold mb-6">Explore Job Seekers</h1>

    <!-- Search Form -->
    <form method="GET" action="{{ route('seekers') }}"
        class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-white p-4 rounded-lg shadow">
        <input type="text" name="name" placeholder="Name" value="{{ request('name') }}"
            class="border border-gray-300 p-2 rounded w-full">

        <input type="text" name="role" placeholder="Role" value="{{ request('role') }}"
            class="border border-gray-300 p-2 rounded w-full">

        <input type="text" name="skills" placeholder="Skills" value="{{ request('skills') }}"
            class="border border-gray-300 p-2 rounded w-full">

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded">
            Search
        </button>
    </form>

    <!-- Results -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-1 gap-6">
        @forelse($seekers as $seeker)
        <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-xl font-semibold">{{ $seeker['name'] }}</h2>
            <p class="text-gray-600">{{ $seeker['role'] }}</p>
            @if(count($seeker['skills']) > 0)
            <div class="mt-4">
                <span class="text-gray-700 font-medium">Skills:</span>
                @foreach($seeker['skills'] as $skill)
                <span
                    class="text-green-600 bg-white border border-green-600 py-1 px-2 ml-1 mr-1 rounded-lg hover:bg-gray-100 transition">{{
                    $skill }}</span>
                @endforeach
            </div>
            @endif
            <a href="{{ url('/employer/seeker-profile/' . $seeker['username']) }}"
                class="inline-block mt-4 text-blue-500 hover:underline">View Profile</a>
        </div>
        @empty
        <p class="text-gray-500 col-span-3">No seekers found.</p>
        @endforelse
    </div>
</x-wrapper>
