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

@push('plugins')
    <script>
        $(function () {
            $('[name=vacant]').change(function () {
                if ($(this).is(':checked')) {
                    $('[rel-vacant]').addClass('hidden');
                    $('[rel-vacant=' + $(this).val() + ']').removeClass('hidden');
                }
            }).trigger('change');
        });
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('publishment.adsense.update') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">名称</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="title" value="{{ $data->title }}" placeholder="请输入名称" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">频道</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->channel->title }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">类型</label>
                                <div class="col-md-10">
                                    <div class="radio-list">
                                        @foreach($filter['origin'] as $key => $origin)
                                            <label class="radio-inline">
                                                <input type="radio" name="origin" value="{{ $key }}" @checked($key == $data->origin)>
                                                {{ $origin }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">计费方式</label>
                                <div class="col-md-10">
                                    @foreach($filter['charging'] as $key => $charging)
                                        <div class="form-check">
                                            <label class="radio-inline">
                                                <input type="radio" name="charging" value="{{ $key }}" @checked($key == $data->charging)>
                                                {{ $charging }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">广告尺寸</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->size->title }} - {{ $data->size->width }}x{{ $data->size->height }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">设备</label>
                                <div class="col-md-10">
                                    <div class="radio-list">
                                        @foreach($filter['device'] as $key => $device)
                                            @if(in_array($key, $data->size->device))
                                                <label class="radio-inline">
                                                    <input type="radio" name="device" value="{{ $key }}" @checked($key == $data->device)>
                                                    {{ $device }}
                                                </label>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">展现类型</label>
                                <div class="col-md-10">
                                    @foreach($filter['type'] as $key => $type)
                                        @if(in_array($key, $data->size->type))
                                            <div class="form-check">
                                                <label class="radio-inline">
                                                    <input type="radio" name="type" value="{{ $key }}" @checked($key == $data->type)>
                                                    {{ $type }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">空闲设置</label>
                                <div class="col-md-10">
                                    @foreach($filter['vacant'] as $key => $vacant)
                                        <div class="form-check">
                                            <label class="radio-inline">
                                                <input type="radio" name="vacant" value="{{ $key }}" @checked($key == $data->vacant)>
                                                {{ $vacant }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group row" rel-vacant="default">
                                <label class="col-md-2 control-label col-form-label">广告地址</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="locator" value="{{ $data->locator }}" placeholder="请输入广告地址" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row" rel-action="viewer" preview>
                                <label class="col-md-2 control-label col-form-label">图片预览</label>
                                <div class="col-md-10">
                                    <a href="javascript:void(0);">
                                        <img src="{{ $data->image }}" style="max-height:200px;" class="img-responsive thumbnail m-b-0">
                                    </a>
                                </div>
                            </div>
                            <div class="form-group row" rel-vacant="default">
                                <label class="col-md-2 control-label col-form-label">图片地址</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="image" value="{{ $data->image }}" data-target="[preview]" placeholder="请上传图片地址" autocomplete="off">
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
                                    <textarea class="form-control" name="code" rows="5" placeholder="请输入联盟广告代码片段">{{ $data->code }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">状态</label>
                                <div class="col-md-10">
                                    <div class="radio-list">
                                        @foreach($filter['state'] as $key => $item)
                                            <label class="radio-inline">
                                                <input type="radio" name="state" value="{{ $key }}" @checked($key == $data->state)>
                                                {{ $item }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{ $data->id }}"/>
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
