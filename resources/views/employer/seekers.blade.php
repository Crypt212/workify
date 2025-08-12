<x-wrapper>
    <h1 class="text-3xl font-bold mb-6">Explore Job Seekers</h1>

    <x-filter :filters="[
    'name' => [
        'label' => 'Full Name',
    ],
    'email' => [
        'label' => 'Email Address'
    ],
    'role' => [
        'label' => 'Role'
    ],
    'skills' => [
        'label' => 'Skills'
    ],
    'phone' => [
        'label' => 'Phone Number'
    ],
]" />

    <!-- Top pagination -->
    <div class="mt-6">
        {{ $seekers->withQueryString()->links('components/paginator') }}
    </div>

    <!-- Results -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-1 gap-6">
        @forelse($seekers as $seeker)
        <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
            <div class="user-identity flex justify-between">
                <h2 class="text-xl font-semibold">{{ $seeker->user->name }}</h2>
                <sub class="text-l text-gray-400">[{{ $seeker->user->username }}]</sub>
            </div>
            <p class="text-gray-600">{{ $seeker->role }}</p>
            @if(count($seeker->skills()->pluck("name")) > 0)
            <div class="mt-4">
                <span class="text-gray-700 font-medium">Skills:</span>
                @foreach($seeker->skills()->pluck("name") as $skill)
                <span
                    class="text-green-600 bg-white border border-green-600 py-1 px-2 ml-1 mr-1 rounded-lg hover:bg-gray-100 transition">{{
                    $skill }}</span>
                @endforeach
            </div>
            @endif
            <a href="{{ url('/employer/seeker-profile/' . $seeker->user->username) }}"
                class="inline-block mt-4 text-blue-500 hover:underline">View Profile</a>
        </div>
        @empty
        <p class="text-gray-500 col-span-3">No seekers found.</p>
        @endforelse
    </div>

    <!-- Bottom pagination -->
    <div class="mt-6">
        {{ $seekers->withQueryString()->links('components/paginator') }}
    </div>

</x-wrapper>
