@if ($paginator->hasPages())
    <nav class="flex items-center justify-between my-6" role="navigation" aria-label="Pagination">
        {{-- Previous Page Link --}}
        <div class="flex-1 flex justify-start">
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 border rounded-md text-gray-400 cursor-not-allowed">
                    &larr; Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                    &larr; Previous
                </a>
            @endif
        </div>

        {{-- Pagination Elements --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-center">
            <div class="flex items-center gap-1">
                {{-- First Page Link --}}
                @if ($paginator->currentPage() > 3)
                    <a href="{{ $paginator->url(1) }}"
                       class="px-3 py-1 border rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        1
                    </a>
                    @if ($paginator->currentPage() > 4)
                        <span class="px-2 text-gray-400">...</span>
                    @endif
                @endif

                {{-- Array Of Links --}}
                @foreach (range(1, $paginator->lastPage()) as $i)
                    @if ($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                        @if ($i == $paginator->currentPage())
                            <span class="px-3 py-1 border rounded-md bg-blue-500 text-white">
                                {{ $i }}
                            </span>
                        @else
                            <a href="{{ $paginator->url($i) }}"
                               class="px-3 py-1 border rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                                {{ $i }}
                            </a>
                        @endif
                    @endif
                @endforeach

                {{-- Last Page Link --}}
                @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                    @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                        <span class="px-2 text-gray-400">...</span>
                    @endif
                    <a href="{{ $paginator->url($paginator->lastPage()) }}"
                       class="px-3 py-1 border rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        {{ $paginator->lastPage() }}
                    </a>
                @endif
            </div>
        </div>

        {{-- Next Page Link --}}
        <div class="flex-1 flex justify-end">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                    Next &rarr;
                </a>
            @else
                <span class="px-4 py-2 border rounded-md text-gray-400 cursor-not-allowed">
                    Next &rarr;
                </span>
            @endif
        </div>
    </nav>
@endif
