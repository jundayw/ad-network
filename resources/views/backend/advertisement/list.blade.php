@extends('backend.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    搜索：{{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.advertisement.list') }}" class="form-horizontal" method="get">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">名称</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="name" value="{{ $request->get('name') }}" placeholder="请输入名称" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">证件号码</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="licence" value="{{ $request->get('licence') }}" placeholder="请输入证件号码" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">联系人</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="corporation" value="{{ $request->get('corporation') }}" placeholder="请输入联系人" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">电话</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="mobile" value="{{ $request->get('mobile') }}" placeholder="请输入电话" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">邮箱</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="mail" value="{{ $request->get('mail') }}" placeholder="请输入邮箱" autocomplete="off">
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
                                <label class="col-md-1 control-label col-form-label">状态</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="state" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['state'] as $key => $state)
                                            <option value="{{ $key }}" @selected($key == $request->get('state'))>{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 control-label col-form-label">审核状态</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="audit" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['audit'] as $key => $audit)
                                            <option value="{{ $key }}" @selected($key == $request->get('audit'))>{{ $audit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="offset-md-1">
                                <button type="submit" class="btn btn-default btn-outline">查询</button>
                                <a class="btn btn-default btn-outline" href="{{ route('backend.advertisement.list') }}">重置</a>
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
                                        <th class="text-center">类型</th>
                                        <th class="text-center" colspan="2">资质</th>
                                        <th class="text-center" colspan="3">联系人</th>
                                        <th class="text-center">总额</th>
                                        <th class="text-center">余额</th>
                                        <th class="text-center">冻结金额</th>
                                        <th class="text-center">新增时间</th>
                                        <th class="text-center">修改时间</th>
                                        <th class="text-center">状态</th>
                                        <th class="text-center">审核状态</th>
                                        <th class="text-center text-nowrap">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $items)
                                        <tr>
                                            <td class="text-center">{{ $items->id }}</td>
                                            <td class="text-center">{{ $items->type }}</td>
                                            <td>{{ $items->name ?? '--' }}</td>
                                            <td>{{ $items->licence ?? '--' }}</td>
                                            <td>{{ $items->corporation ?? '--' }}</td>
                                            <td>{{ $items->mobile ?? '--' }}</td>
                                            <td>{{ $items->mail ?? '--' }}</td>
                                            <td class="text-center">{{ $items->total }}</td>
                                            <td class="text-center">{{ $items->balance }}</td>
                                            <td class="text-center">{{ $items->frozen }}</td>
                                            <td class="text-center">{{ $items->create_time ?? '--' }}</td>
                                            <td class="text-center">{{ $items->update_time ?? '--' }}</td>
                                            <td class="text-center">{{ $items->state }}</td>
                                            <td class="text-center">{{ $items->audit }}</td>
                                            <td class="text-center text-nowrap">
                                                @policy('backend.advertisement.edit')
                                                <a href="{{ $items->edit }}" data-toggle="tooltip" data-original-title="编辑">编辑</a>
                                                @endpolicy
                                                @policy('backend.advertisement.destroy')
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
