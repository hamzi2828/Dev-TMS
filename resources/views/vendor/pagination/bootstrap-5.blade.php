@if ($paginator->hasPages())
    <nav aria-label="Page navigation" class="mt-2 pt-3 d-flex justify-content-end">
        <ul class="pagination">
            {{-- First Page Link --}}
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link waves-effect" href="{{ $paginator->url(1) }}">
                    <i class="tf-icon fs-6 ti ti-chevrons-left"></i>
                </a>
            </li>
            
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif
                
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @elseif ($page == 1 || $page == $paginator->lastPage() || ($page >= $paginator->currentPage() - 2 && $page <= $paginator->currentPage() + 2))
                            <li class="page-item"><a class="page-link waves-effect" href="{{ $url }}">{{ $page }}</a></li>
                        @elseif ($page == $paginator->currentPage() - 3 || $page == $paginator->currentPage() + 3)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            
            {{-- Last Page Link --}}
            <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link waves-effect" href="{{ $paginator->url($paginator->lastPage()) }}">
                    <i class="tf-icon fs-6 ti ti-chevrons-right"></i>
                </a>
            </li>
        </ul>
    </nav>
@endif
