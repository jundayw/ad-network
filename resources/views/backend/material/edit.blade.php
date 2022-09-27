@extends('backend.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.material.update') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">名称</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="title" value="{{ $data->title }}" placeholder="请输入名称" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">设备</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">
                                        @foreach($filter['device'] as $key => $device)
                                            @if($data->device == $key)
                                                {{ $device }}
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">广告尺寸</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->size->title }} - {{ $data->size->width }}x{{ $data->size->height }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">链接地址</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="location" value="{{ $data->location }}" placeholder="请输入链接地址" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row" rel-action="viewer" rel-origin="[name=image]">
                                <label class="col-md-2 control-label col-form-label">图片预览</label>
                                <div class="col-md-4">
                                    <a href="javascript:void(0);">
                                        <img src="{{ $data->image }}" style="max-height:200px;" class="img-responsive thumbnail m-b-0">
                                    </a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">图片地址</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="image" value="{{ $data->image }}" rel-action="preview" rel-src="[rel-origin='[name=image]']" placeholder="请上传图片地址" autocomplete="off">
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
                                                <input type="radio" name="state" value="{{ $key }}" @checked($data->state == $key)>
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
