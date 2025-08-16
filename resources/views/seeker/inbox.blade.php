<x-wrapper>

<div class="max-w-5xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">My Inbox</h1>

    <x-filter :filters="[
    'title' => [
        'label' => 'Message Title',
    ],
    'body' => [
        'label' => 'Message Body',
    ],
    'sender_name' => [
        'label' => 'Full Name',
    ],
    'sender_email' => [
        'label' => 'Email Address'
    ],
    'sender_organization_name' => [
        'label' => 'Organization Name'
    ],
    'sender_phone' => [
        'label' => 'Phone Number'
    ],
]" />

    <!-- Pagination -->
    <div class="mt-6">
        {{ $messages->withQueryString()->links('components/paginator') }}
    </div>

    <!-- Messages -->
    @foreach($messages as $message)
        <div class="bg-white p-5 mb-4 rounded-lg shadow border border-gray-200">
            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-3 mb-3">
                <div>
                    <h2 class="text-lg font-semibold">{{ $message->title }}</h2>
                    <p class="text-sm text-gray-500">{{ $message->sender->name }}</p>
                    <p class="text-sm text-gray-500">{{ $message->sender->email }}</p>
                </div>
                <a href="{{ route('seeker.employer-profile', $message->sender->username) }}" class="text-blue-600 hover:underline">View Profile</a>

            </div>
            <!-- Body -->
            <p class="text-gray-700 mb-3 whitespace-pre-wrap">{{ $message->body }}</p>
            <p class="text-xs text-gray-400">Sent: {{ $message->created_at->format('Y-m-d H:i') }}</p>
        </div>
    @endforeach

    <!-- Pagination -->
    <div class="mt-6">
        {{ $messages->withQueryString()->links('components/paginator') }}
    </div>
</div>
</x-wrapper>
