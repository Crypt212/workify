<x-wrapper>
    <h1 class="text-2xl font-bold mb-4">
        Your Applications
    </h1>

    <x-filter :filters="[
    'employer_name' => [ 'label' => 'Employer Name', ],
    'employer_username' => [ 'label' => 'Employer Username', ],
    'employer_organization' => [ 'label' => 'Employer Oranization Name', ],
    'title' => ['label' => 'Post Title'],
    'tags' => ['label' => 'Post Tags'],
    'skills' => ['label' => 'Post Skills'],
]" />

    <!-- Top pagination -->
    <div class="mt-6">
        {{ $applications->withQueryString()->links('components/paginator') }}
    </div>

    @if ($applications->count() > 0)

    @foreach ($applications as $application)
    <div class="bg-white mx-auto max-w-4xl rounded-lg shadow-md my-3 p-5 relative">
        <div>
        </div>
        <div class="flex items-baseline flex-col">
            <a class="text-l text-gray-700 hover:text-blue-700 transition"
                href="{{ route('seeker.employer-profile', $application->post->employer->user->username) }}">
                <h1 class="">{{ $application->post->employer->user->name }}</h1>
            </a>
            <h2 class="text-md  text-gray-400">({{ $application->post->employer->organization_name }})</h2>
        </div>
        <hr>
        <h1 class="text-xl text-bold">{{ $application->post->title }}</h1>
        <div class="body ml-4 indent-4">
            <h2>{{ $application->post->description }}</h2>
        </div>
        <hr>
        @if(count($application->post->tags) > 0)
        <div class="mt-4">
            <span class="text-gray-700 font-medium">Tags:</span>
            @foreach($application->post->tags as $tag)
            <span
                class="text-blue-600 bg-white border border-blue-600 py-1 px-2 ml-1 mr-1 rounded-lg hover:bg-gray-100 transition">
                {{ $tag->name }}
            </span>
            @endforeach
        </div>
        @endif

        @if(count($application->post->skills) > 0)
        <div class="mt-4">
            <span class="text-gray-700 font-medium">Skills:</span>
            @foreach($application->post->skills as $skill)
            <span
                class="text-green-600 bg-white border border-green-600 py-1 px-2 ml-1 mr-1 rounded-lg hover:bg-gray-100 transition">
                {{ $skill->name }}
            </span>
            @endforeach
        </div>
        @endif

        <div class="flex justify-end pt-3 space-x-2 mt-3">
            <form action="{{ route('employer.application.accept', $application->id) }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="application_id" value="{{ $application->id }}">
                <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                    Accept
                </button>
            </form>
            <form action="{{ route('employer.application.reject', $application->id) }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="application_id" value="{{ $application->id }}">
                <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                    Reject
                </button>
            </form>
        </div>
    </div>
    @endforeach

    @else
    <p class="text-gray-600">No applications found</p>
    @endif

    <!-- Bottom pagination -->
    <div class="mt-6">
        {{ $applications->withQueryString()->links('components/paginator') }}
    </div>


    </div>
</x-wrapper>
