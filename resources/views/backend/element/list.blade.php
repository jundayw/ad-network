@extends('backend.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    搜索：{{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.element.list') }}" class="form-horizontal" method="get">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">广告主</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="advertisement" value="{{ $request->get('advertisement') }}" placeholder="请输入广告主" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">广告计划</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="program" value="{{ $request->get('program') }}" placeholder="请输入广告计划" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">广告单元</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="title" value="{{ $request->get('title') }}" placeholder="请输入广告单元" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">投放日期</label>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="release_begin" value="{{ $request->get('release_begin') }}" placeholder="请选择日期" autocomplete="off" rel-action="datepicker">
                                        <span class="input-group-addon">
                                            <span class="icon-calender"></span>
                                        </span>
                                        <input class="form-control" type="text" name="release_finish" value="{{ $request->get('release_finish') }}" placeholder="请选择日期" autocomplete="off" rel-action="datepicker">
                                    </div>
                                </div>
                                <label class="col-md-1 control-label col-form-label">投放时段</label>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="period_begin" value="{{ $request->get('period_begin') }}" placeholder="请选择时段" autocomplete="off" rel-action="timepicker">
                                        <span class="input-group-addon">
                                            <span class="icon-calender"></span>
                                        </span>
                                        <input class="form-control" type="text" name="period_finish" value="{{ $request->get('period_finish') }}" placeholder="请选择时段" autocomplete="off" rel-action="timepicker">
                                    </div>
                                </div>
                                <label class="col-md-1 control-label col-form-label">出价方式</label>
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
                                <a class="btn btn-default btn-outline" href="{{ route('backend.element.list') }}">重置</a>
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
                                        <th class="text-center">广告主</th>
                                        <th class="text-center">广告计划</th>
                                        <th class="text-center">投放设备</th>
                                        <th class="text-center">广告单元</th>
                                        <th class="text-center" colspan="2">投放日期</th>
                                        <th class="text-center" colspan="2">投放时段</th>
                                        <th class="text-center">出价方式</th>
                                        <th class="text-center">出价</th>
                                        <th class="text-center">状态</th>
                                        <th class="text-center text-nowrap">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $items)
                                        <tr>
                                            <td class="text-center">{{ $items->id }}</td>
                                            <td>{{ $items->advertisements->name }}</td>
                                            <td>{{ $items->program->title }}</td>
                                            <td class="text-center">{{ $items->program->getDevice($items->program->device) }}</td>
                                            <td>{{ $items->title }}</td>
                                            <td class="text-center">{{ $items->release_begin }}</td>
                                            <td class="text-center">{{ $items->release_finish }}</td>
                                            <td class="text-center">{{ $items->period_begin }}</td>
                                            <td class="text-center">{{ $items->period_finish }}</td>
                                            <td class="text-center">{{ $items->type }}</td>
                                            <td class="text-center">{{ $items->rate }}</td>
                                            <td class="text-center">{{ $items->state }}</td>
                                            <td class="text-center text-nowrap">
                                                @policy('backend.element.edit')
                                                <a href="{{ $items->edit }}" data-toggle="tooltip" data-original-title="编辑">编辑</a>
                                                @endpolicy
                                                @policy('backend.element.destroy')
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
