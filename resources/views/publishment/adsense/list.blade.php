@extends('publishment.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    搜索：{{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('publishment.adsense.list') }}" class="form-horizontal" method="get">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">名称</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="title" value="{{ $request->get('title') }}" placeholder="请输入名称" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">站点</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="site" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['site'] as $key => $site)
                                            <option value="{{ $site->id }}" @selected($site->id == $request->get('site'))>{{ $site->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 control-label col-form-label">频道</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="channel" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['site'] as $key => $site)
                                            <optgroup label="{{ $site->title }}">
                                                @foreach($site['channel'] as $key => $channel)
                                                    <option value="{{ $channel->id }}" @selected($channel->id == $request->get('channel'))>{{ $channel->title }}</option>
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
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">类型</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="origin" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['origin'] as $key => $origin)
                                            <option value="{{ $key }}" @selected($key == $request->get('origin'))>{{ $origin }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 control-label col-form-label">设备</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="device" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['device'] as $key => $device)
                                            <option value="{{ $key }}" @selected($key == $request->get('device'))>{{ $device }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 control-label col-form-label">展现类型</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="type" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['type'] as $key => $type)
                                            <option value="{{ $key }}" @selected($key == $request->get('type'))>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 control-label col-form-label">空闲设置</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="vacant" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['vacant'] as $key => $vacant)
                                            <option value="{{ $key }}" @selected($key == $request->get('vacant'))>{{ $vacant }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">计费方式</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="charging" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['charging'] as $key => $charging)
                                            <option value="{{ $key }}" @selected($key == $request->get('charging'))>{{ $charging }}</option>
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
                                <a class="btn btn-default btn-outline" href="{{ route('publishment.adsense.list') }}">重置</a>
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
                            @policy('publishment.adsense.create')
                            <a class="btn btn-default btn-outline" href="{{ route('publishment.adsense.create') }}">
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
                                        <th class="text-center">站点</th>
                                        <th class="text-center">频道</th>
                                        <th class="text-center" colspan="2">广告尺寸</th>
                                        <th class="text-center">类型</th>
                                        <th class="text-center">设备</th>
                                        <th class="text-center">计费方式</th>
                                        <th class="text-center">展现类型</th>
                                        <th class="text-center">空闲设置</th>
                                        <th class="text-center">状态</th>
                                        <th class="text-center text-nowrap" colspan="2">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $items)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $items->title }}</td>
                                            <td>{{ $items->site->title }}</td>
                                            <td>{{ $items->channel->title }}</td>
                                            <td class="text-center">{{ $items->size->width }}x{{ $items->size->height }}</td>
                                            <td>{{ $items->size->title }}</td>
                                            <td class="text-center">{{ $items->origin }}</td>
                                            <td class="text-center">{{ $items->device }}</td>
                                            <td class="text-center">{{ $items->type }}</td>
                                            <td class="text-center">{{ $items->charging }}</td>
                                            <td class="text-center">{{ $items->vacant }}</td>
                                            <td class="text-center">{{ $items->state }}</td>
                                            <td class="text-center">
                                                <a href="{{ $items->code }}" rel-action="dialog" rel-width="860" rel-height="656" title="获取代码">获取代码</a>
                                            </td>
                                            <td class="text-center text-nowrap">
                                                @policy('publishment.adsense.edit')
                                                <a href="{{ $items->edit }}" data-toggle="tooltip" data-original-title="编辑">编辑</a>
                                                @endpolicy
                                                @policy('publishment.adsense.destroy')
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
                        {{ $data->appends($request->query())->links('publishment.layouts.page') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
