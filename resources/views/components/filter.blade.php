<div class="bg-white p-4 rounded-lg shadow-sm mb-6 border border-gray-200">
    <form method="GET" action="{{ url()->current() }}" class="flex justify-between">
        <!-- Preserve all existing non-filter query parameters -->
        @foreach(request()->except('filter', 'page') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <div class="box-border flex-col flex-1 mr-2">
            <x-dropdown trigger="Filters">
            <!-- Dynamic filter inputs -->
            @foreach($filters as $filterName => $filterOptions)
                <div class="m-2">
                    <input
                        type="text"
                        name="filter[{{ $filterName }}]"
                        id="filter_{{ $filterName }}"
                        value="{{ request('filter.'.$filterName) }}"
                        placeholder="{{ 'Filter by '.str_replace('_', ' ', $filterName) }}"
                        class="w-full px-2 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>
            @endforeach
            </x-dropdown>
        </div>

        <div class="flex justify-between items-center">
            <div>
                @if(request()->has('filter'))
                    <a
                        href="{{ url()->current() }}"
                        class="inline-flex items-center px-3 py-2 mr-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                    >
                        Clear All Filters
                    </a>
                @endif
            </div>
            <div>
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Apply Filters
                </button>
            </div>
        </div>
    </form>
</div>
