<ul class="pagination m-t-0 m-b-0 pull-right">
    @if ($paginator->hasPages())
        @if ($paginator->onFirstPage())
            <li class="disabled"><a class="first" href="javascript:void(0);">首页</a></li>
        @else
            <li><a class="first" href="{{ $paginator->url(1) }}">首页</a></li>
            <li><a class="prev" href="{{ $paginator->previousPageUrl() }}">上一页</a></li>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span class="page-link">{{ $element }}</span></li>
            @endif
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <li><a class="next" href="{{ $paginator->nextPageUrl() }}">下一页</a></li>
            <li><a class="end" href="{{ $paginator->url($paginator->lastPage()) }}">末页</a></li>
        @else
            <li class="disabled"><a class="end" href="javascript:void(0);">末页</a></li>
        @endif
    @endif
    <li class="active">
        <a href="javascript:void(0);">共<span>{{ $paginator->total() }}</span>条记录，每页<span>{{ $paginator->perPage() }}</span>条,共<span>{{ $paginator->lastPage() }}</span>/<span>{{ $paginator->currentPage() }}</span>页</a>
    </li>
</ul>
{{--<li>count:{{ $paginator->count() }}</li>--}}
{{--<li>currentPage:{{ $paginator->currentPage() }}</li>--}}
{{--<li>firstItem:{{ $paginator->firstItem() }}</li>--}}
{{--<li>lastItem:{{ $paginator->lastItem() }}</li>--}}
{{--<li>hasMorePages:{{ $paginator->hasMorePages() }}</li>--}}
{{--<li>onFirstPage:{{ $paginator->onFirstPage() }}</li>--}}
{{--<li>lastPage:{{ $paginator->lastPage() }}</li>--}}
{{--<li>nextPageUrl:{{ $paginator->nextPageUrl() }}</li>--}}
{{--<li>previousPageUrl:{{ $paginator->previousPageUrl() }}</li>--}}
{{--<li>perPage:{{ $paginator->perPage() }}</li>--}}
{{--<li>total:{{ $paginator->total() }}</li>--}}
{{--<li>url:{{ $paginator->url(1) }}</li>--}}
