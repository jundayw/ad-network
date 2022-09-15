@extends('backend.layouts.main')

@push('plugins')
    <script>
        $(function () {
            $('[name=icon]').blur(function () {
                $(this).prev().find('i').prop('class', $(this).val());
            });
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
                    <form action="{{ route('backend.policy.update') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">名称</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="title" value="{{ $data->title }}" placeholder="请输入名称" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">图标</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="{{ $data->icon }}"></i></div>
                                        <input class="form-control" type="text" name="icon" value="{{ $data->icon }}" placeholder="请输入图标" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">地址</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="url" rel-action="select">
                                        <option value="">请选择地址</option>
                                        @foreach($filter['routes'] as $key => $routes)
                                            <optgroup label="{{ $key }}">
                                                @foreach($routes as $key => $route)
                                                    <option value="{{ $key }}" @selected($data->url==$key)>{{ $key }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">授权语句</label>
                                <div class="col-md-10">
                                    <select class="form-control select2-multiple" name="statement[]" multiple="multiple" data-placeholder="请选择策略授权" rel-action="select">
                                        @foreach($filter['routes'] as $key => $routes)
                                            <optgroup label="{{ $key }}">
                                                @foreach($routes as $key => $route)
                                                    <option value="{{ $key }}" @selected(in_array($key,$data->statement))>{{ $key }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">描述</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="description" rows="5" placeholder="请输入描述">{{ $data->description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">排序</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="sorting" value="{{ $data->sorting }}" placeholder="请输入排序，数字越大越靠前" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">状态</label>
                                <div class="col-md-10">
                                    <div class="radio-list">
                                        @foreach($filter['states'] as $key => $state)
                                            <label class="radio-inline">
                                                <input type="radio" name="state" value="{{ $key }}" @checked($data->state==$key)>
                                                {{ $state }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{ $data->id }}"/>
                        <input type="hidden" name="pid" value="{{ $data->pid }}"/>
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
