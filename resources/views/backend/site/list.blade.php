@extends('backend.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    搜索：{{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.site.list') }}" class="form-horizontal" method="get">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">流量主</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="publishment" value="{{ $request->get('publishment') }}" placeholder="请输入流量主" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">站点名称</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="title" value="{{ $request->get('title') }}" placeholder="请输入站点名称" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">域名</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="domain" value="{{ $request->get('domain') }}" placeholder="请输入域名" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">行业</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="industry" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['industry'] as $key => $industry)
                                            <option value="{{ $industry->id }}" @selected($industry->id == $request->get('industry'))>{{ $industry->title }}</option>
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
                                <a class="btn btn-default btn-outline" href="{{ route('backend.site.list') }}">重置</a>
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
                </div>
                <div class="panel-wrapper">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped">
                                @if($data->isEmpty()===false)
                                    <thead>
                                    <tr>
                                        <th class="text-center">编号</th>
                                        <th class="text-center">流量主</th>
                                        <th class="text-center">行业</th>
                                        <th class="text-center">名称</th>
                                        <th class="text-center">域名</th>
                                        <th class="text-center">新增时间</th>
                                        <th class="text-center">修改时间</th>
                                        <th class="text-center">状态</th>
                                        <th class="text-center text-nowrap">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $items)
                                        <tr>
                                            <td class="text-center">{{ $items->id }}</td>
                                            <td>{{ $items->publishments->name }}</td>
                                            <td class="text-center">{{ $items->industry->title }}</td>
                                            <td>{{ $items->title }}</td>
                                            <td>
                                                <a href="{{ $items->protocol }}{{ $items->domain }}" target="_blank">
                                                    {{ $items->protocol }}{{ $items->domain }}
                                                </a>
                                            </td>
                                            <td class="text-center">{{ $items->create_time }}</td>
                                            <td class="text-center">{{ $items->update_time }}</td>
                                            <td class="text-center">{{ $items->state }}</td>
                                            <td class="text-center text-nowrap">
                                                @policy('backend.site.edit')
                                                <a href="{{ $items->edit }}" data-toggle="tooltip" data-original-title="编辑">编辑</a>
                                                @endpolicy
                                                @policy('backend.site.destroy')
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
