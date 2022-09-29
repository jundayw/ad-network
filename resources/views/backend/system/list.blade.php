@extends('backend.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    搜索：{{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.system.list') }}" class="form-horizontal" method="get">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">名称</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="title" value="{{ $request->get('title') }}" placeholder="请输入名称" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">键名</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="key" value="{{ $request->get('key') }}" placeholder="请输入键名" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">键值</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="value" value="{{ $request->get('value') }}" placeholder="请输入键值" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">类型</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="type" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['type'] as $key => $type)
                                            <option value="{{ $key }}" @selected($key == $request->get('type'))>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="offset-md-1">
                                <button type="submit" class="btn btn-default btn-outline">查询</button>
                                <a class="btn btn-default btn-outline" href="{{ route('backend.system.list') }}">重置</a>
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
                            @policy('backend.system.create')
                            <a class="btn btn-default btn-outline" href="{{ route('backend.system.create') }}">
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
                                        <th class="text-center">键名</th>
                                        <th class="text-center">键值</th>
                                        <th class="text-center">类型</th>
                                        <th class="text-center text-nowrap">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody rel-action="viewer">
                                    @foreach($data as $items)
                                        <tr>
                                            <td class="text-center">{{ $items->id }}</td>
                                            <td class="text-center">{{ $items->title }}</td>
                                            <td class="text-center">{{ $items->getRawOriginal('key') }}</td>
                                            <td>
                                                @if($items->getRawOriginal('type') == 'FILE')
                                                    <a href="javascript:void(0);">
                                                        <img src="{{ $items->value }}" style="max-height:18px;">
                                                    </a>
                                                @elseif($items->getRawOriginal('type') == 'TEXTAREA')
                                                    {{ mb_substr($items->value, 0, 6).'...' }}
                                                @else
                                                    {{ $items->value }}
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $items->type }}</td>
                                            <td class="text-center text-nowrap">
                                                @if($items->getRawOriginal('modifiable') == 'NORMAL')
                                                    @policy('backend.system.edit')
                                                    <a href="{{ $items->edit }}" data-toggle="tooltip" data-original-title="编辑">编辑</a>
                                                    @endpolicy
                                                @endif
                                                @policy('backend.system.destroy')
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
