@extends('backend.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    搜索：{{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.size.list') }}" class="form-horizontal" method="get">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">名称</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="title" value="{{ $request->get('title') }}" placeholder="请输入名称" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">展现类型</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="device" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['device'] as $key => $device)
                                            <option value="{{ $key }}" @selected($key == $request->get('device'))>{{ $device }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 control-label col-form-label">设备</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="type" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['type'] as $key => $type)
                                            <option value="{{ $key }}" @selected($key == $request->get('type'))>{{ $type }}</option>
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
                                <a class="btn btn-default btn-outline" href="{{ route('backend.size.list') }}">重置</a>
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
                            @policy('backend.size.create')
                            <a class="btn btn-default btn-outline" href="{{ route('backend.size.create') }}">
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
                                        <th class="text-center" colspan="2">名称</th>
                                        <th class="text-center">尺寸</th>
                                        <th class="text-center">设备</th>
                                        <th class="text-center">展现类型</th>
                                        <th class="text-center">排序</th>
                                        <th class="text-center">状态</th>
                                        <th class="text-center text-nowrap">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $items)
                                        <tr>
                                            <td class="text-center">{{ $items->id }}</td>
                                            <td class="text-right">{{ $items->title }}</td>
                                            <td class="text-left">--</td>
                                            <td class="text-center">--</td>
                                            <td class="text-left">--</td>
                                            <td class="text-left">--</td>
                                            <td class="text-center">--</td>
                                            <td class="text-center">{{ $items->state }}</td>
                                            <td class="text-center text-nowrap">
                                                @policy('backend.size.edit')
                                                <a href="{{ $items->edit }}" data-toggle="tooltip" data-original-title="编辑">编辑</a>
                                                @endpolicy
                                                @policy('backend.size.destroy')
                                                <a href="{{ $items->destroy }}" rel-action="confirm" rel-certain="删除" rel-msg="确定执行删除操作" data-toggle="tooltip" data-original-title="删除">删除</a>
                                                @endpolicy
                                            </td>
                                        </tr>
                                        @foreach($items->size as $item)
                                            <tr>
                                                <td class="text-center">{{ $item->id }}</td>
                                                <td class="text-right">--</td>
                                                <td class="text-left">{{ $item->title }}</td>
                                                <td class="text-center">{{ $item->width }}x{{ $item->height }}</td>
                                                <td class="text-left">{{ $item->devices }}</td>
                                                <td class="text-left">{{ $item->types }}</td>
                                                <td class="text-center">{{ $item->sorting }}</td>
                                                <td class="text-center">{{ $item->state }}</td>
                                                <td class="text-center text-nowrap">
                                                    @policy('backend.size.edit')
                                                    <a href="{{ $item->edit }}" data-toggle="tooltip" data-original-title="编辑">编辑</a>
                                                    @endpolicy
                                                    @policy('backend.size.destroy')
                                                    <a href="{{ $item->destroy }}" rel-action="confirm" rel-certain="删除" rel-msg="确定执行删除操作" data-toggle="tooltip" data-original-title="删除">删除</a>
                                                    @endpolicy
                                                </td>
                                            </tr>
                                        @endforeach
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
                </div>
            </div>
        </div>
    </div>
@endsection
