@extends('publishment.layouts.dialog')

@push('plugins')
    <script src="https://clipboardjs.com/dist/clipboard.min.js"></script>
    <script>
        $(function () {
            $('textarea,input').focus(function () {
                var clipboard = new ClipboardJS(this, {
                    text: () => {
                        return $(this).val();
                    }
                });

                clipboard.on('success', function (e) {
                    layer.msg('复制成功');
                    e.clearSelection();
                });

                clipboard.on('error', function (e) {
                    layer.msg('复制失败，请手动复制');
                });
            });
        });
    </script>
@endpush

@section('content')
    <div class="row">
        <ins class="adsbyadnetwork"
             title="悬浮换量"
             width="336"
             height="280"
             data-ad-client="10086"
             data-ad-slot="6"
             data-ad-width="336"
             data-ad-height="280"></ins>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-wrapper">
                    <div class="panel-body p-b-0">
                        <div class="form-group">
                            <label>标准广告代码</label>
                            <textarea class="form-control" rows="7" readonly placeholder="标准广告代码">
<ins class="adsbyadnetwork"
     title="{{ $adsense->getAttribute('title') }}"
     data-ad-client="{{ $adsense->getAttribute('publishment_id') }}"
     data-ad-slot="{{ $adsense->getAttribute('id') }}"
     data-ad-width="{{ $adsense->size->getAttribute('width') }}"
     data-ad-height="{{ $adsense->size->getAttribute('height') }}"></ins></textarea>
                        </div>
                        <div class="form-group">
                            <label>自定义广告大小</label>
                            <textarea class="form-control" rows="9" readonly placeholder="自定义广告大小">
<ins class="adsbyadnetwork"
     title="{{ $adsense->getAttribute('title') }}"
     width="{{ $adsense->size->getAttribute('width') }}"
     height="{{ $adsense->size->getAttribute('height') }}"
     data-ad-client="{{ $adsense->getAttribute('publishment_id') }}"
     data-ad-slot="{{ $adsense->getAttribute('id') }}"
     data-ad-width="{{ $adsense->size->getAttribute('width') }}"
     data-ad-height="{{ $adsense->size->getAttribute('height') }}"></ins></textarea>
                            <span class="help-block">不推荐修改广告位尺寸，以免广告图片变形，给用户带来不好的用户体验</span>
                        </div>
                        @if($adsense->getAttribute('type')=='float')
                            <div class="form-group">
                                <label>自定义位置</label>
                                <textarea class="form-control" rows="9" readonly placeholder="自定义位置">
<ins class="adsbyadnetwork"
     title="{{ $adsense->getAttribute('title') }}"
     data-ad-client="{{ $adsense->getAttribute('publishment_id') }}"
     data-ad-slot="{{ $adsense->getAttribute('id') }}"
     data-ad-width="{{ $adsense->size->getAttribute('width') }}"
     data-ad-height="{{ $adsense->size->getAttribute('height') }}"
     data-ad-float-right="0"
     data-ad-float-bottom="0"></ins></textarea>
                            </div>
                        @endif
                        @if($adsense->getAttribute('type')=='couplet')
                            <div class="form-group">
                                <label>自定义位置</label>
                                <textarea class="form-control" rows="9" readonly placeholder="自定义位置">
<ins class="adsbyadnetwork"
     title="{{ $adsense->getAttribute('title') }}"
     data-ad-client="{{ $adsense->getAttribute('publishment_id') }}"
     data-ad-slot="{{ $adsense->getAttribute('id') }}"
     data-ad-width="{{ $adsense->size->getAttribute('width') }}"
     data-ad-height="{{ $adsense->size->getAttribute('height') }}"
     data-ad-couplet-top="100"
     data-ad-couplet-right="0"
     data-ad-couplet-left="0"></ins></textarea>
                            </div>
                        @endif
                        <div class="form-group">
                            <label>广告渲染引擎文件</label>
                            <input class="form-control" type="text" value="{{ $url }}" readonly placeholder="广告渲染引擎文件" autocomplete="off">
                            <span class="help-block">每个页面引入一次即可，无需重复引入。</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
