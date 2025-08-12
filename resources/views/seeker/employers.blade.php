<x-wrapper>
    <h1 class="text-3xl font-bold mb-6">Explore Employers</h1>

    <x-filter :filters="[
    'name' => [
        'label' => 'Full Name',
    ],
    'email' => [
        'label' => 'Email Address'
    ],
    'organization_name' => [
        'label' => 'Organization Name'
    ],
    'phone' => [
        'label' => 'Phone Number'
    ],
]" />

    <!-- Top pagination -->
    <div class="mt-6">
        {{ $employers->withQueryString()->links('components/paginator') }}
    </div>

    <!-- Results -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-1 gap-6">
        @forelse($employers as $employer)
        <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
            <div class="user-identity flex justify-between">
                <h2 class="text-xl font-semibold">{{ $employer->user->name }}</h2>
                <sub class="text-l text-gray-400">[{{ $employer->user->username }}]</sub>
            </div>
            <p class="text-gray-600">{{ $employer->organization_name }}</p>
            <a href="{{ url('/seeker/employer-profile/' . $employer->user->username) }}"
                class="inline-block mt-4 text-blue-500 hover:underline">View Profile</a>
        </div>
        @empty
        <p class="text-gray-500 col-span-3">No employers found.</p>
        @endforelse
    </div>

    <!-- Bottom pagination -->
    <div class="mt-6">
        {{ $employers->withQueryString()->links('components/paginator') }}
    </div>

</x-wrapper>
