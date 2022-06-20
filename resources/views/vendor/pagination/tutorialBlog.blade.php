@if ($paginator->hasPages())
    <div id="tutorial" class="simple-pagination" data-aos="fade-up">
        <ul>
            @if ($paginator->onFirstPage())
                <li class="disabled"><i class="icofont-rounded-left"></i></li>
            @else
                <li class="btn-tooltip-hide" id="theme-toggle">
                    <a href="{{ $paginator->previousPageUrl() }}"><i class="icofont-rounded-left"></i>
                    </a>
                </li>
            @endif

            @if ($paginator->hasMorePages())
                <li class="btn-tooltip-hide" id="theme-toggle">
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
