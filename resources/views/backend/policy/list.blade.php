@extends('backend.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    搜索：{{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.policy.list') }}" class="form-horizontal" method="get">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">模块</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="module_id" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['modules'] as $key => $module)
                                            <option value="{{ $module->getKey() }}" @selected($module->getKey() == $request->get('module_id'))>{{ $module->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="offset-md-1">
                                <button type="submit" class="btn btn-default btn-outline">查询</button>
                                <a class="btn btn-default btn-outline" href="{{ route('backend.policy.list') }}">重置</a>
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
                            @policy('backend.policy.create')
                            <a class="btn btn-default btn-outline" href="{{ route('backend.policy.create') }}">
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
                                        <th class="text-center">模块</th>
                                        <th class="text-center">类型</th>
                                        <th class="text-center">策略</th>
                                        <th class="text-center">排序</th>
                                        <th class="text-center">状态</th>
                                        <th class="text-center text-nowrap">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $items)
                                        <tr>
                                            <td class="text-center">{{ $items->id }}</td>
                                            <td class="text-center">{{ $items->module->title }}</td>
                                            <td class="text-center">{{ $items->type }}</td>
                                            <td class="text-left">{{ $items->title }}</td>
                                            <td class="text-center">{{ $items->sorting }}</td>
                                            <td class="text-center">{{ $items->state }}</td>
                                            <td class="text-center text-nowrap">
                                                @policy('backend.policy.edit')
                                                <a href="{{ $items->edit }}" data-toggle="tooltip" data-original-title="编辑">编辑</a>
                                                @endpolicy
                                                @policy('backend.policy.destroy')
                                                <a href="{{ $items->destroy }}" rel-action="confirm" rel-certain="删除" rel-msg="确定执行删除操作" data-toggle="tooltip" data-original-title="删除">删除</a>
                                                @endpolicy
                                            </td>
                                        </tr>
                                        @foreach($items->policies as $item)
                                            <tr>
                                                <td class="text-center">{{ $item->id }}</td>
                                                <td class="text-center">{{ $items->module->title }}</td>
                                                <td class="text-center">{{ $item->type }}</td>
                                                <td class="text-left">{{ $items->title }}>{{ $item->title }}</td>
                                                <td class="text-center">{{ $item->sorting }}</td>
                                                <td class="text-center">{{ $item->state }}</td>
                                                <td class="text-center text-nowrap">
                                                    @policy('backend.policy.edit')
                                                    <a href="{{ $item->edit }}" data-toggle="tooltip" data-original-title="编辑">编辑</a>
                                                    @endpolicy
                                                    @policy('backend.policy.destroy')
                                                    <a href="{{ $item->destroy }}" rel-action="confirm" rel-certain="删除" rel-msg="确定执行删除操作" data-toggle="tooltip" data-original-title="删除">删除</a>
                                                    @endpolicy
                                                </td>
                                            </tr>
                                            @foreach($item->policies as $policy)
                                                <tr>
                                                    <td class="text-center">{{ $policy->id }}</td>
                                                    <td class="text-center">{{ $items->module->title }}</td>
                                                    <td class="text-center">{{ $policy->type }}</td>
                                                    <td class="text-left">{{ $items->title }}>{{ $item->title }}>{{ $policy->title }}</td>
                                                    <td class="text-center">{{ $policy->sorting }}</td>
                                                    <td class="text-center">{{ $policy->state }}</td>
                                                    <td class="text-center text-nowrap">
                                                        @policy('backend.policy.edit')
                                                        <a href="{{ $policy->edit }}" data-toggle="tooltip" data-original-title="编辑">编辑</a>
                                                        @endpolicy
                                                        @policy('backend.policy.destroy')
                                                        <a href="{{ $policy->destroy }}" rel-action="confirm" rel-certain="删除" rel-msg="确定执行删除操作" data-toggle="tooltip" data-original-title="删除">删除</a>
                                                        @endpolicy
                                                    </td>
                                                </tr>
                                            @endforeach
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
                    <div class="panel-footer clearfix">
                        {{ $data->appends($request->query())->links('backend.layouts.page') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
