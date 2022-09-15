@if ($paginator->hasPages())
    <ul class="pagination m-t-0 m-b-0 pull-right">
        @if ($paginator->onFirstPage())
            <li class="disabled"><a class="first" href="javascript:void(0);">首页</a></li>
        @else
            <li><a class="next" href="{{ $paginator->previousPageUrl() }}">上一页</a></li>
        @endif
        @if ($paginator->hasMorePages())
            <li><a class="next" href="{{ $paginator->nextPageUrl() }}">下一页</a></li>
        @else
            <li class="disabled"><a class="end" href="javascript:void(0);">末页</a></li>
        @endif
    </ul>
@endif
