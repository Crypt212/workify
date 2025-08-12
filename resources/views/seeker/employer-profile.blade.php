<x-wrapper>
    <!-- Profile Card -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex items-center space-x-6">
            <div class="w-full">
                <div class="user-identity flex justify-between w-full">
                    <h1 class="text-xl font-semibold">{{ $employer->user->name }}</h1>
                    <sub class="text-l text-gray-400">[{{ $employer->user->username }}]</sub>
                </div>
                <p class="text-gray-600">{{ $employer->role }}</p>
                <p class="text-gray-500 mt-2">
                    Email: {{ $employer->user->email }}
                </p>
            </div>
        </div>

        <!-- Organization Name -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Organization Name</h2>
                <p class="text-gray-500 mt-2"> {{ $employer->organization_name }}</p>
        </div>
    </div>

    <!-- Message Form -->
    <div class="bg-white shadow-lg mt-3 rounded-lg p-6">
        <x-message-form :routeName='"seeker.employer-profile.sendMessage"' :receiverId="$employer->user->id" :senderId="auth()->user()->id" />
    </div>
</x-wrapper>
