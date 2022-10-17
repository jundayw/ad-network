@extends('backend.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.system.update') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">名称</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="title" value="{{ $data->title }}" placeholder="请输入名称" autocomplete="off">
                                </div>
                            </div>
                            @if($data->type == 'static')
                                <div class="form-group row">
                                    <label class="col-md-2 control-label col-form-label">键值</label>
                                    <div class="col-md-10">
                                        <p class="form-control-static">{{ $data->value }}</p>
                                        <input class="form-control" type="hidden" name="value" value="static" placeholder="请输入键值" autocomplete="off">
                                    </div>
                                </div>
                            @endif
                            @if($data->type == 'text')
                                <div class="form-group row">
                                    <label class="col-md-2 control-label col-form-label">键值</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" name="value" value="{{ $data->value }}" placeholder="请输入键值" autocomplete="off">
                                    </div>
                                </div>
                            @endif
                            @if($data->type == 'radio')
                                <div class="form-group row">
                                    <label class="col-md-2 control-label col-form-label">键值</label>
                                    <div class="col-md-10">
                                        <div class="radio-list">
                                            @foreach($filter['options'] as $key => $item)
                                                <label class="radio-inline">
                                                    <input type="radio" name="value" value="{{ $key }}" @checked($key == $data->value)>
                                                    {{ $item }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($data->type == 'checkbox')
                                <div class="form-group row">
                                    <label class="col-md-2 control-label col-form-label">设备</label>
                                    <div class="col-md-10">
                                        <div class="checkbox-list">
                                            @foreach($filter['options'] as $key => $option)
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="value[]" value="{{ $key }}" @checked(in_array($key, $data->value))>
                                                    {{ $option }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($data->type == 'select')
                                <div class="form-group row">
                                    <label class="col-md-2 control-label col-form-label">键值</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="value" rel-action="select">
                                            @foreach($filter['options'] as $key => $option)
                                                <option value="{{ $key }}" @selected($key == $data->value)>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            @if($data->type == 'textarea')
                                <div class="form-group row">
                                    <label class="col-md-2 control-label col-form-label">键值</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="value" rows="5" placeholder="请输入描述">{{ $data->value }}</textarea>
                                    </div>
                                </div>
                            @endif
                            @if($data->type == 'datetimepicker')
                                <div class="form-group row">
                                    <label class="col-md-2 control-label col-form-label">键值</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" name="value" value="{{ $data->value }}" placeholder="请选择日期时间" readonly autocomplete="off" rel-action="datetimepicker">
                                    </div>
                                </div>
                            @endif
                            @if($data->type == 'timepicker')
                                <div class="form-group row">
                                    <label class="col-md-2 control-label col-form-label">键值</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" name="value" value="{{ $data->value }}" placeholder="请选择时间" readonly autocomplete="off" rel-action="timepicker">
                                    </div>
                                </div>
                            @endif
                            @if($data->type == 'datepicker')
                                <div class="form-group row">
                                    <label class="col-md-2 control-label col-form-label">键值</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" name="value" value="{{ $data->value }}" placeholder="请选择日期" readonly autocomplete="off" rel-action="datepicker">
                                    </div>
                                </div>
                            @endif
                            @if($data->type == 'file')
                                <div class="form-group row" rel-action="viewer" rel-origin="[name=value]">
                                    <label class="col-md-2 control-label col-form-label">图片预览</label>
                                    <div class="col-md-10">
                                        <a href="javascript:void(0);">
                                            <img src="{{ $data->value }}" style="max-height:200px;" class="img-responsive thumbnail m-b-0">
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 control-label col-form-label">键值</label>
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="value" value="{{ $data->value }}" rel-action="preview" rel-src="[rel-origin='[name=value]']" placeholder="请上传图片地址" autocomplete="off">
                                            <label for="value" class="input-group-addon">上传</label>
                                            <input id="value" type="file" rel-action="file" rel-target="[name=value]" rel-url="{{ route('utils.upload.images') }}" class="hidden">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">描述</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="description" rows="5" placeholder="请输入描述">{{ $data->description }}</textarea>
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
