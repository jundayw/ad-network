@extends('backend.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.size.store') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">所属</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="pid" rel-action="select">
                                        <option value="0">作为顶级栏目</option>
                                        @foreach($filter['size'] as $key => $size)
                                            <option value="{{ $size->getKey() }}">{{ $size->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">名称</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="title" value="" placeholder="请输入名称" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">尺寸</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <span class="input-group-addon">宽度</span>
                                        <input class="form-control" type="text" name="width" value="" placeholder="请输入宽度" autocomplete="off">
                                        <span class="input-group-addon">px</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label"></label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <span class="input-group-addon">高度</span>
                                        <input class="form-control" type="text" name="height" value="" placeholder="请输入高度" autocomplete="off">
                                        <span class="input-group-addon">px</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">设备</label>
                                <div class="col-md-10">
                                    <div class="checkbox-list">
                                        @foreach($filter['device'] as $key => $device)
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="device[]" value="{{ $key }}" @checked($loop->first)>
                                                {{ $device }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">展现类型</label>
                                <div class="col-md-10">
                                    <div class="checkbox-list">
                                        @foreach($filter['type'] as $key => $type)
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="type[]" value="{{ $key }}" @checked($loop->first)>
                                                {{ $type }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">描述</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="description" rows="5" placeholder="请输入描述"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">排序</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="sorting" value="1" placeholder="请输入排序，数字越大越靠前" autocomplete="off">
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
