@if ($paginator->hasPages())
    <div class="d-flex justify-content-between mt-3 pe-3 ps-3">
        <div class="align-items-center d-flex">
            <p class="small text-muted">
                {!! __('Showing') !!}
                <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                {!! __('of') !!}
                <span class="fw-semibold">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-round pagination-secondary">
                <li class="page-item first">
                    <a class="page-link waves-effect" href="{{ $paginator->url(1) }}">
                        <i class="ti ti-chevrons-left ti-xs"></i>
                    </a>
                </li>
                
                <!-- Loop through the pages -->
                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    <li class="page-item {{ ($i == $paginator->currentPage()) ? 'active' : '' }}">
                        <a class="page-link waves-effect  {{ ($i == $paginator->currentPage()) ? 'bg-primary' : '' }}"
                           href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                
                <li class="page-item last">
                    <a class="page-link waves-effect" href="{{ $paginator->url($paginator->lastPage()) }}">
                        <i class="ti ti-chevrons-right ti-xs"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
@endif