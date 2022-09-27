@extends('publishment.layouts.main')

@push('plugins')
    <script>
        $(function () {
            $('[preview]').each(function () {
                $(this).find('img').attr('src') ? $(this).removeClass('hidden') : $(this).addClass('hidden');
            });
            $('[name=image]').bind('file:upload.success', function (event, data, files) {
                $($(this).data('target')).removeClass('hidden').find('img').attr('src', files.shift());
            })
        });
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('publishment.material.store') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">名称</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="title" value="" placeholder="请输入名称" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">设备</label>
                                <div class="col-md-10">
                                    <div class="radio-list">
                                        @foreach($filter['device'] as $key => $device)
                                            <label class="radio-inline">
                                                <input type="radio" name="device" value="{{ $key }}" @checked($loop->first)>
                                                {{ $device }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">广告尺寸</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="size" rel-action="select">
                                        @foreach($filter['device'] as $key => $device)
                                            <optgroup label="{{ $device }}">
                                                @foreach($filter['size'][$key] as $key => $size)
                                                    <option value="{{ $size->id }}">{{ $size->title }} - {{ $size->width }}x{{ $size->height }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">链接地址</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="location" value="" placeholder="请输入链接地址" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row" rel-action="viewer" preview>
                                <label class="col-md-2 control-label col-form-label">图片预览</label>
                                <div class="col-md-4">
                                    <a href="javascript:void(0);">
                                        <img src="" style="max-height:200px;" class="img-responsive thumbnail m-b-0">
                                    </a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">图片地址</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="image" value="" data-target="[preview]" placeholder="请上传图片地址" autocomplete="off">
                                        <label for="image" class="input-group-addon">上传</label>
                                        <input
                                                id="image"
                                                type="file"
                                                rel-action="file"
                                                rel-target="[name=image]"
                                                rel-url="{{ route('utils.upload.images') }}"
                                                class="hidden">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">状态</label>
                                <div class="col-md-10">
                                    <div class="radio-list">
                                        @foreach($filter['state'] as $key => $item)
                                            <label class="radio-inline">
                                                <input type="radio" name="state" value="{{ $key }}" @checked($loop->first)>
                                                {{ $item }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="offset-md-2">
                                <button type="submit" class="btn btn-default btn-outline">保存</button>
                                <button type="reset" class="btn btn-default btn-outline">重置</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
