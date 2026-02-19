@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="page-link disabled"><i class="ri-arrow-left-s-line"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-link"><i class="ri-arrow-left-s-line"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="page-link disabled">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-link active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-link"><i class="ri-arrow-right-s-line"></i></a>
        @else
            <span class="page-link disabled"><i class="ri-arrow-right-s-line"></i></span>
        @endif
    </div>
@endif
