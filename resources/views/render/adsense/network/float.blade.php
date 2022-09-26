<iframe id="{{ $data['ne'] }}"
        name="{{ $data['ne'] }}"
        src="{{ $url }}"
        width="{{ $data['width'] }}"
        height="{{ $data['height'] }}"
        scrolling="no"
        frameborder="0"
></iframe>
<style>
    iframe[name={{ $data['ne'] }}] {
        position: fixed;
        z-index: 2147483646;
        @if($request->has('data-ad-float-top'))
            top: {{ $request->get('data-ad-float-top', 0) }}px;
        @else
            bottom: {{ $request->get('data-ad-float-bottom', 0) }}px;
        @endif
        @if($request->has('data-ad-float-left'))
            left: {{ $request->get('data-ad-float-left', 0) }}px;
        @else
            right: {{ $request->get('data-ad-float-right', 0) }}px;
        @endif
    }
</style>
