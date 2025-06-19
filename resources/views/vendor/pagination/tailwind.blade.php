@if ($paginator->hasPages())
    <nav>
        <ul class="flex items-center justify-center gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-md cursor-not-allowed">
                    <span>&lt;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-orange-50 hover:text-orange-600">
                        &lt;
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                $start = $current;
                $elements = 3; // Number of elements to show
            @endphp

            {{-- Generate the sliding window of page numbers --}}
            @for ($i = 0; $i < $elements && ($start + $i) <= $last; $i++)
                @if (($start + $i) == $current)
                    <li class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-500 border border-blue-500 rounded-md">
                        {{ $start + $i }}
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->url($start + $i) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-orange-50 hover:text-orange-600">
                            {{ $start + $i }}
                        </a>
                    </li>
                @endif
            @endfor

            {{-- Show dots if not on last pages --}}
            @if ($current + $elements - 1 < $last)
                <li class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-md">
                    ...
                </li>
                <li>
                    <a href="{{ $paginator->url($last) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-orange-50 hover:text-orange-600">
                        {{ $last }}
                    </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-orange-50 hover:text-orange-600">
                        &gt;
                    </a>
                </li>
            @else
                <li class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-md cursor-not-allowed">
                    <span>&gt;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif