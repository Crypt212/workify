<x-wrapper>
    <!-- Profile Card -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex items-center space-x-6">
            <div class="w-full">
                <div class="user-identity flex justify-between w-full">
                    <h1 class="text-xl font-semibold">{{ $seeker->user->name }}</h1>
                    <sub class="text-l text-gray-400">[{{ $seeker->user->username }}]</sub>
                </div>
                <p class="text-gray-600">{{ $seeker->role }}</p>
                <p class="text-gray-500 mt-2">
                    Email: {{ $seeker->user->email }}
                </p>
            </div>
        </div>

        <!-- Skills -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Skills</h2>
            <div class="flex flex-wrap gap-2">
                @if(count($seeker->skills) > 0)
                <div class="mt-4 flex w-full flex-wrap">
                    @foreach($seeker->skills as $skill)
                    <div
                        class="skill flex flex-row bg-white border border-green-600 py-1 px-2 mx-1 my-1 rounded-lg hover:bg-gray-100 transition">
                        <span class="text-green-600 ">{{ $skill->name }}</span>
                        <span class="text-gray-500 ">({{ $skill->pivot->proficiency }})</span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500">No skills listed</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Skills -->
    <div class="bg-white shadow-lg mt-3 rounded-lg p-6">
        <x-message-form :routeName='"employer.seeker-profile.sendMessage"' :receiverId="$seeker->user->id" :senderId="auth()->user()->id" />
    </div>
</x-wrapper>
