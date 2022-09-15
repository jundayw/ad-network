@extends('backend.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    搜索：{{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.manager.list') }}" class="form-horizontal" method="get">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">角色</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="role" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['roles'] as $key => $role)
                                            <option value="{{ $role->getKey() }}" @selected($role->getKey() == $request->get('role'))>
                                                {{ $role->module->title }} / {{ $role->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 control-label col-form-label">用户名</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="username" value="{{ $request->get('username') }}" placeholder="请输入用户名" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">昵称</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="usernick" value="{{ $request->get('usernick') }}" placeholder="请输入昵称" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">状态</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="state" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['states'] as $key => $state)
                                            <option value="{{ $key }}" @selected($key == $request->get('state'))>{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="offset-md-1">
                                <button type="submit" class="btn btn-default btn-outline">查询</button>
                                <a class="btn btn-default btn-outline" href="{{ route('backend.manager.list') }}">重置</a>
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
                            @policy('backend.manager.create')
                            <a class="btn btn-default btn-outline" href="{{ route('backend.manager.create') }}">
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
                                        <th class="text-center">角色</th>
                                        <th class="text-center">用户名</th>
                                        <th class="text-center">昵称</th>
                                        <th class="text-center">登录地址</th>
                                        <th class="text-center">登录时间</th>
                                        <th class="text-center">注册地址</th>
                                        <th class="text-center">注册时间</th>
                                        <th class="text-center">状态</th>
                                        <th class="text-center text-nowrap">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $items)
                                        <tr>
                                            <td class="text-center">{{ $items->id }}</td>
                                            <td>{{ $items->role_title }}</td>
                                            <td>{{ $items->username }}</td>
                                            <td>{{ $items->usernick }}</td>
                                            <td class="text-center">{{ $items->last_ip ?? '--' }}</td>
                                            <td class="text-center">{{ $items->last_time ?? '--' }}</td>
                                            <td class="text-center">{{ $items->register_ip ?? '--' }}</td>
                                            <td class="text-center">{{ $items->register_time ?? '--' }}</td>
                                            <td class="text-center">{{ $items->state }}</td>
                                            <td class="text-center text-nowrap">
                                                @policy('backend.manager.password')
                                                <a href="{{ $items->password }}" data-toggle="tooltip" data-original-title="重置密码">重置密码</a>
                                                @endpolicy
                                                @policy('backend.manager.edit')
                                                <a href="{{ $items->edit }}" data-toggle="tooltip" data-original-title="编辑">编辑</a>
                                                @endpolicy
                                                @policy('backend.manager.destroy')
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
