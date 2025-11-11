@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center">

            {{-- Tombol Previous --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&laquo; Sebelumnya</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Sebelumnya</a>
                </li>
            @endif

            {{-- Nomor Halaman --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link"
                                    href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Next --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Selanjutnya &raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Selanjutnya &raquo;</span>
                </li>
            @endif

        </ul>
    </nav>
@endif
