<x-wrapper>
    <!-- Profile Card -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex items-center space-x-6">
            <img src="{{ $seeker['avatar'] ?? 'https://via.placeholder.com/150' }}" alt="Profile Picture"
                class="w-32 h-32 rounded-full border">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $seeker['name'] }}</h1>
                <p class="text-gray-600">{{ $seeker['role'] }}</p>
                <p class="text-gray-500 mt-2">
                    Email: {{ $seeker['email'] }}
                </p>
            </div>
        </div>

        <!-- Skills -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Skills</h2>
            <div class="flex flex-wrap gap-2">
                @if ($seeker['skills'] && count($seeker['skills']) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($seeker['skills'] as $skill)
                    <div
                        class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <span class="font-medium text-gray-800">{{ $skill['name'] }}</span>
                            <span class="text-xs px-2 py-1 rounded-full
                                        @if($skill['proficiency'] === 'Beginner') bg-blue-100 text-blue-800
                                        @elseif($skill['proficiency'] === 'Intermediate') bg-indigo-100 text-indigo-800
                                        @elseif($skill['proficiency'] === 'Advanced') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                {{ $skill['proficiency'] }}
                            </span>
                        </div>
                        <div class="mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full
                                            @if($skill['proficiency'] === 'Beginner') bg-blue-400 w-1/3
                                            @elseif($skill['proficiency'] === 'Intermediate') bg-indigo-400 w-2/3
                                            @elseif($skill['proficiency'] === 'Advanced') bg-purple-400 w-full
                                            @else bg-gray-400 w-1/2 @endif">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500">No skills listed</p>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('seekers') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                ← Back to Explore
            </a>
        </div>
    </div>
</x-wrapper>
