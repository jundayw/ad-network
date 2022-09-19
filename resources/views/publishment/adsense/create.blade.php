@extends('backend.layouts.main')

@push('plugins')
    <script>
        $(function () {
            $('[name=size]').change(function () {
                let type = $(this).find('option:selected').attr('type').split(',');
                let device = $(this).find('option:selected').attr('device').split(',');
                $('[rel-type]').each(function () {
                    $(this).find('input').prop("checked", false);
                    if (type.indexOf($(this).attr('rel-type')) === -1) {
                        $(this).addClass('hidden');
                    } else {
                        $(this).removeClass('hidden');
                    }
                });
                $('[rel-device]').each(function () {
                    $(this).find('input').prop("checked", false);
                    if (device.indexOf($(this).attr('rel-device')) === -1) {
                        $(this).addClass('hidden');
                    } else {
                        $(this).removeClass('hidden');
                    }
                });
            }).trigger('change');
            $('[name=vacant]').change(function () {
                $('[rel-vacant]').addClass('hidden');
                $('[rel-vacant=' + $(this).val() + ']').removeClass('hidden');
            }).trigger('change');
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
                    <form action="{{ route('publishment.adsense.store') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">名称</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="title" value="" placeholder="请输入名称" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">频道</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="channel" rel-action="select">
                                        @foreach($filter['site'] as $key => $site)
                                            <optgroup label="{{ $site->title }} - {{ $site->protocol }}{{ $site->domain }}">
                                                @foreach($site['channel'] as $key => $channel)
                                                    <option value="{{ $channel->id }}">{{ $channel->title }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">类型</label>
                                <div class="col-md-10">
                                    <div class="radio-list">
                                        @foreach($filter['origin'] as $key => $origin)
                                            <label class="radio-inline">
                                                <input type="radio" name="origin" value="{{ $key }}" @checked($loop->first)>
                                                {{ $origin }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">广告尺寸</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="size" rel-action="select">
                                        @foreach($filter['size'] as $key => $size)
                                            <optgroup label="{{ $size->title }}">
                                                @foreach($size['size'] as $key => $size)
                                                    <option value="{{ $size->id }}" device="{{ implode(',', $size->device) }}" type="{{ implode(',', $size->type) }}">{{ $size->title }} - {{ $size->width }}x{{ $size->height }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">设备</label>
                                <div class="col-md-10">
                                    <div class="radio-list">
                                        @foreach($filter['device'] as $key => $device)
                                            <label class="radio-inline" rel-device="{{ $key }}">
                                                <input type="radio" name="device" value="{{ $key }}" @checked($loop->first)>
                                                {{ $device }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">展现类型</label>
                                <div class="col-md-10">
                                    @foreach($filter['type'] as $key => $type)
                                        <div class="form-check">
                                            <label class="radio-inline" rel-type="{{ $key }}">
                                                <input type="radio" name="type" value="{{ $key }}" @checked($loop->first)>
                                                {{ $type }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">空闲设置</label>
                                <div class="col-md-10">
                                    @foreach($filter['vacant'] as $key => $vacant)
                                        <div class="form-check">
                                            <label class="radio-inline">
                                                <input type="radio" name="vacant" value="{{ $key }}" @checked($loop->first)>
                                                {{ $vacant }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group row" rel-vacant="default">
                                <label class="col-md-2 control-label col-form-label">广告地址</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="locator" value="" placeholder="请输入广告地址" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row" rel-vacant="default">
                                <label class="col-md-2 control-label col-form-label">图片地址</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="image" value="" placeholder="请上传图片地址" autocomplete="off">
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
                            <div class="form-group row" rel-vacant="union">
                                <label class="col-md-2 control-label col-form-label">联盟广告代码</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="code" rows="5" placeholder="请输入联盟广告代码片段"></textarea>
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
