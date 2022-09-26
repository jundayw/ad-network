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
        z-index: 2147483647;
        top: {{ explode('x',$data['si'])[1]/2 - $data['height']/2 }}px;
        left: {{ explode('x',$data['si'])[0]/2 - $data['width']/2 }}px;
    }
</style>
