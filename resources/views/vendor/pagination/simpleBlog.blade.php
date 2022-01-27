@if ($paginator->hasPages())
    <div class="simple-pagination" data-aos="fade-up">
        <ul>
            @if ($paginator->onFirstPage())
                <li class="disabled"><i class="icofont-rounded-left"></i></li>
            @else
                <li class="btn-tooltip-hide" data-toggle="tooltip" data-placement="bottom"
                    title="{{ trans('pagination.previous') }}" id="theme-toggle">
                    <a href="{{ $paginator->previousPageUrl() }}"><i class="icofont-rounded-left"></i>
                    </a>
                </li>
            @endif

            @if ($paginator->hasMorePages())
                <li class="btn-tooltip-hide" data-toggle="tooltip" data-placement="bottom"
                    title="{{ trans('pagination.next') }}" id="theme-toggle">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i class="icofont-rounded-right"></i>
                    </a>
                </li>
            @else
                <li class="disabled"><i class="icofont-rounded-right"></i></li>
            @endif
        </ul>
    </div>
@endif
