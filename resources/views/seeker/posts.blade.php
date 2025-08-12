<x-wrapper>

<div class="max-w-5xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Explore Job Posts</h1>

    <x-filter :filters="[
    'employer_name' => [ 'label' => 'Employer Name', ],
    'employer_username' => [ 'label' => 'Employer Username', ],
    'employer_organization' => [ 'label' => 'Employer Oranization Name', ],
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
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
            <div class="flex justify-between items-baseline py-2">
                <div>
                <a class="text-l text-gray-700 hover:text-blue-700 transition" href="{{ route('seeker.employer-profile', $post->employer->user->username) }}">
                    <h1 class="">{{ $post->employer->user->name }}</h1>
                </a>
                    <h2 class="text-md  text-gray-400">({{ $post->employer->organization_name }})</h2>
                </div>
                <a class="py-2 text-l px-4  text-gray-700 rounded-lg hover:text-blue-700 transition"
                    href="{{ route('seeker.employer-profile', $post->employer->user->username) }}">
                    <sub class="">[{{
                        $post->employer->user->username }}]</sub>
                </a>
            </div>
            <p class="text-gray-600 mt-2">{{ $post->description }}</p>
            @if(count($post->tags) > 0)
            <div class="mt-4">
                <span class="text-gray-700 font-medium">Tags:</span>
                @foreach($post->tags as $tag)
                <span
                    class="text-blue-600 bg-white border border-blue-600 py-1 px-2 ml-1 mr-1 rounded-lg hover:bg-gray-100 transition">{{
                    $tag }}</span>
                @endforeach
            </div>
            @endif
            @if(count($post->skills) > 0)
            <div class="mt-4">
                <span class="text-gray-700 font-medium">Skills:</span>
                @foreach($post->skills as $skill)
                <span
                    class="text-green-600 bg-white border border-green-600 py-1 px-2 ml-1 mr-1 rounded-lg hover:bg-gray-100 transition">{{
                    $skill }}</span>
                @endforeach
            </div>
            @endif
            @if($post->applied)
            <div class="flex justify-end items-center py-2">
                <a href="{{ route('seeker.posts.unapply') }}"
                    class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                    Un-Apply
                </a>
            </div>
            @else
            <div class="flex justify-end items-center py-2">
                <a href="{{ route('seeker.posts.apply') }}"
                    class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                    Apply
                </a>
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
