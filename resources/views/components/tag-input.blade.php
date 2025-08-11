<div class="tag-input space-y-4" id="tagInserter">
    <!-- Hidden input that will store our tags array -->
    <input type="hidden" name="tags" id="tagsInput" value="{{ json_encode(old('tags', $tags ?? [])) }}">

    <!-- Display area for added tags -->
    <div id="tagsContainer" class=" flex">
        @if(old('tags', $tags ?? []))
            @foreach(json_decode(old('tags', json_encode($tags ?? [])), true) as $index => $tag)
                <div class="tag-item border ml-3 flex text-green-500 border-green-500 items-center justify-between px-1 py-1 bg-gray-50 rounded-md">
                    <div>
                        <span class="font-medium">{{ $tag['name'] }}</span>
                    </div>
                    <button type="button" onclick="removeTag({{ $index }})" class="text-red-500 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Input for new tags -->
    <div class="flex space-x-2">
        <div class="flex-1">
            <input
                type="text"
                id="tagName"
                placeholder="Tag name"
                class="w-full px-3 py-2 border rounded-md"
            >
        </div>
        <button
            type="button"
            id="addTagBtn"
            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
            onclick="addTag()"
        >
            Add
        </button>
    </div>
</div>

<script>
// Initialize tags array
let tags = JSON.parse(document.getElementById('tagsInput').value || '[]');

// Update the hidden input
function updateTagsInput() {
    document.getElementById('tagsInput').value = JSON.stringify(tags);
}

// Add new tag
function addTag() {
    const name = document.getElementById('tagName').value.trim();

    if (name) {
        if (tags.some(tag => tag.name.toLowerCase() == name.toLowerCase())) return;
        tags.push({ name });
        renderTags();
        document.getElementById('tagName').value = '';
        document.getElementById('tagName').focus();
    }
}

// Remove tag
function removeTag(index) {
    tags.splice(index, 1);
    renderTags();
}

// Render all tags
function renderTags() {
    const container = document.getElementById('tagsContainer');
    container.innerHTML = tags.map((tag, index) => `
        <div class="tag-item border ml-3 flex text-green-500 border-green-500 items-center justify-between px-1 py-1 bg-gray-50 rounded-md">
            <div>
                <span class="font-medium">${tag.name}</span>
            </div>
            <button type="button" onclick="removeTag(${index})" class="text-red-500 ml-3 hover:text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    `).join('');

    updateTagsInput();
}

// Add event listener for Enter key
document.getElementById('tagName').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        addTag();
    }
});

// Initial render if there are existing tags
if (tags.length > 0) {
    renderTags();
}
</script>
