@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-center">
        <ul class="pagination gap-1 overflow-x-auto">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link d-flex box-30 rounded-circle align-items-center justify-content-center" aria-hidden="true">
                        <i class="bi bi-arrow-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link d-flex box-30 rounded-circle align-items-center justify-content-center bg-light text-dark" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link d-flex box-30 rounded-circle align-items-center justify-content-center bg-light text-dark">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link d-flex box-30 rounded-circle align-items-center justify-content-center bg-primary text-white border-primary">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link d-flex box-30 rounded-circle align-items-center justify-content-center bg-light text-dark" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link d-flex box-30 rounded-circle align-items-center justify-content-center bg-light text-dark" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link d-flex box-30 rounded-circle align-items-center justify-content-center" aria-hidden="true">
                        <i class="bi bi-arrow-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
