<iframe id="{{ $data['ne'] }}_l"
        name="{{ $data['ne'] }}"
        src="{{ $url }}"
        width="{{ $data['width'] }}"
        height="{{ $data['height'] }}"
        scrolling="no"
        frameborder="0"
></iframe>
<iframe id="{{ $data['ne'] }}_r"
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
        z-index: 2147483645;
    }

    iframe[name={{ $data['ne'] }}]:first-of-type {
        top: {{ $request->get('data-ad-couplet-top',0) }}px;
        left: {{ $request->get('data-ad-couplet-left',0) }}px;
    }

    iframe[name={{ $data['ne'] }}]:last-of-type {
        top: {{ $request->get('data-ad-couplet-top',0) }}px;
        right: {{ $request->get('data-ad-couplet-right',0) }}px;
    }
</style>
