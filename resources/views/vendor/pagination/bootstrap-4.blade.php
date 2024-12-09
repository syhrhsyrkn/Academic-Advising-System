<ul class="pagination">
    @if ($paginator->onFirstPage())
        <li class="page-item disabled">
            <span class="page-link">«</span>
        </li>
    @else
    <li class="page-item">
        <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev">
            <i class="fas fa-chevron-left"></i> <!-- Smaller arrow -->
        </a>
    </li>

    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
        @elseif (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
    <li class="page-item">
        <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next">
            <i class="fas fa-chevron-right"></i> <!-- Smaller arrow -->
        </a>
    </li>

    @else
        <li class="page-item disabled">
            <span class="page-link">»</span>
        </li>
    @endif
</ul>
