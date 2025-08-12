<div x-data="{ open: false }" class="relative inline-block text-left w-full">
    <!-- Dropdown Trigger Button -->
    <div>
        <button
            type="button"
            @click="open = !open"
            class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            id="dropdown-button"
            aria-expanded="true"
            aria-haspopup="true"
        >
            {{ $trigger }}
            <!-- Heroicon: chevron-down -->
            <svg
                :class="{ 'transform rotate-180': open }"
                class="-mr-1 ml-2 h-5 w-5 text-gray-400 transition-transform duration-200"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
            >
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <!-- Dropdown Panel -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="origin-top-right absolute right-0 mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="dropdown-button"
        @click.away="open = false"
        style="display: none;"
    >
        <div class="py-1">
            {{ $slot }}
        </div>
    </div>
</div>
