@extends('advertisement.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    搜索：{{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('advertisement.creative.list') }}" class="form-horizontal" method="get">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">名称</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="title" value="{{ $request->get('title') }}" placeholder="请输入名称" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">广告单元</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="program" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['element'] as $key => $element)
                                            <option value="{{ $element->id }}" @selected($element->id == $request->get('program'))>{{ $element->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 control-label col-form-label">广告单元</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="element" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['element'] as $key => $element)
                                            <optgroup label="{{ $element->title }}">
                                                @foreach($element['element'] as $key => $element)
                                                    <option value="{{ $element->id }}" @selected($element->id == $request->get('element'))>{{ $element->title }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 control-label col-form-label">广告尺寸</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="size" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['size'] as $key => $size)
                                            <optgroup label="{{ $size->title }}">
                                                @foreach($size['size'] as $key => $size)
                                                    <option value="{{ $size->id }}" @selected($size->id == $request->get('size'))>{{ $size->title }} - {{ $size->width }}x{{ $size->height }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 control-label col-form-label">状态</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="state" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['state'] as $key => $state)
                                            <option value="{{ $key }}" @selected($key == $request->get('state'))>{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="offset-md-1">
                                <button type="submit" class="btn btn-default btn-outline">查询</button>
                                <a class="btn btn-default btn-outline" href="{{ route('advertisement.creative.list') }}">重置</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                    <div class="panel-action">
                        <div class="btn-group">
                            @policy('advertisement.creative.create')
                            <a class="btn btn-default btn-outline" href="{{ route('advertisement.creative.create') }}">
                                <i class="fa fa-file-text m-r-5"></i>
                                <span>新增</span>
                            </a>
                            @endpolicy
                        </div>
                    </div>
                </div>
                <div class="panel-wrapper">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped">
                                @if($data->isEmpty()===false)
                                    <thead>
                                    <tr>
                                        <th class="text-center">编号</th>
                                        <th class="text-center">名称</th>
                                        <th class="text-center">广告计划</th>
                                        <th class="text-center">广告单元</th>
                                        <th class="text-center" colspan="2">广告尺寸</th>
                                        <th class="text-center">修改时间</th>
                                        <th class="text-center">状态</th>
                                        <th class="text-center text-nowrap">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $items)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $items->title }}</td>
                                            <td class="text-center">{{ $items->program->title }}</td>
                                            <td class="text-center">{{ $items->element->title }}</td>
                                            <td class="text-center">{{ $items->size->title }}</td>
                                            <td class="text-center">{{ $items->size->width }}x{{ $items->size->height }}</td>
                                            <td class="text-center">{{ $items->update_time }}</td>
                                            <td class="text-center">{{ $items->state }}</td>
                                            <td class="text-center text-nowrap">
                                                @policy('advertisement.creative.edit')
                                                <a href="{{ $items->edit }}" data-toggle="tooltip" data-original-title="编辑">编辑</a>
                                                @endpolicy
                                                @policy('advertisement.creative.destroy')
                                                <a href="{{ $items->destroy }}" rel-action="confirm" rel-certain="删除" rel-msg="确定执行删除操作" data-toggle="tooltip" data-original-title="删除">删除</a>
                                                @endpolicy
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @else
                                    <tr>
                                        <td>暂无数据</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer clearfix">
                        {{ $data->appends($request->query())->links('backend.layouts.page') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
