<form action="{{ route($routeName) }}" method="POST" class="space-y-4">
    @csrf
    <input type="hidden" name="sender_id" value="{{ $senderId }}" class="sr-only" />
    <input type="hidden" name="receiver_id" value="{{ $receiverId }}" class="sr-only" />

    <h1 class="text-xl font-semibold">Message</h1>
    <div class="mb-4">

        <label for="title" class="text-l text-gray-400">Title</label>
        <input type="input" name="title" placeholder="Title" value="{{ old('title') }}" class="w-full p-2 my-2 border border-gray-300 rounded-lg " />
        <label for="body" class="text-l text-gray-400">Body</label>
        <textarea
            id="body"
            name="body"
            rows="6"
            class="w-full px-4 py-3 my-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Write your message here..."
            required
        >{{ old('body') }}</textarea>
        @error('message')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end">
        <button
            type="submit"
            class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors" >
            Send Message
        </button>
    </div>
</form>
