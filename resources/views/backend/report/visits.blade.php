@extends('backend.layouts.main')

@push('plugins')
    <link href="{{ H('plugins/components/footable/css/footable.core.css') }}" rel="stylesheet">
    <script src="{{ H('plugins/components/footable/js/footable.all.min.js') }}"></script>
    <script>
        $(function () {
            $('table').footable();
        });
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    搜索：{{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.report.visits') }}" class="form-horizontal" method="get">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">广告计划</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="program" value="{{ $request->get('program') }}" placeholder="请输入广告计划" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">广告单元</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="element" value="{{ $request->get('element') }}" placeholder="请输入广告单元" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">广告创意</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="creative" value="{{ $request->get('creative') }}" placeholder="请输入广告创意" autocomplete="off">
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
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">站点</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="site" value="{{ $request->get('site') }}" placeholder="请输入站点" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">频道</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="channel" value="{{ $request->get('channel') }}" placeholder="请输入频道" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">广告位</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="adsense" value="{{ $request->get('adsense') }}" placeholder="请输入广告位" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">时间</label>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="begin" value="{{ $request->get('begin') }}" placeholder="请选择日期" autocomplete="off" rel-action="datepicker">
                                        <span class="input-group-addon">
                                            <span class="icon-calender"></span>
                                        </span>
                                        <input class="form-control" type="text" name="finish" value="{{ $request->get('finish') }}" placeholder="请选择日期" autocomplete="off" rel-action="datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">全局用户标识</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="guid" value="{{ $request->get('guid') }}" placeholder="请输入全局用户标识" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">独立用户标识</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="uuid" value="{{ $request->get('uuid') }}" placeholder="请输入独立用户标识" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">请求标识</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="ruid" value="{{ $request->get('ruid') }}" placeholder="请输入请求标识" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="offset-md-1">
                                <button type="submit" class="btn btn-default btn-outline">查询</button>
                                <a class="btn btn-default btn-outline" href="{{ route('backend.report.visits') }}">重置</a>
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
                            <table class="table toggle-arrow-tiny table-hover table-bordered table-striped" data-paging="true">
                                @if($data->isEmpty()===false)
                                    <thead>
                                    <tr>
                                        <th class="text-center" data-toggle="true">编号</th>
                                        <th class="text-center" colspan="3">广告主</th>
                                        <th class="text-center" colspan="3">网站主</th>
                                        <th class="text-center" colspan="3">广告尺寸</th>
                                        <th class="text-center">类型</th>
                                        <th class="text-center">时间</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" data-toggle="true">编号</th>
                                        <th class="text-center">广告计划</th>
                                        <th class="text-center">广告单元</th>
                                        <th class="text-center">广告创意</th>
                                        <th class="text-center">站点</th>
                                        <th class="text-center">频道</th>
                                        <th class="text-center">广告位</th>
                                        <th class="text-center">名称</th>
                                        <th class="text-center">尺寸</th>
                                        <th class="text-center">物料</th>
                                        <th class="text-center">类型</th>
                                        <th class="text-center">时间</th>
                                        <th data-hide="all">全局用户标识</th>
                                        <th data-hide="all">独立用户标识</th>
                                        <th data-hide="all">请求标识</th>
                                        <th data-hide="all">语言</th>
                                        <th data-hide="all">操作系统</th>
                                        <th data-hide="all">设备</th>
                                        <th data-hide="all">分辨率</th>
                                        <th data-hide="all">User-Agent</th>
                                        <th data-hide="all">IP</th>
                                        <th data-hide="all">来源网址</th>
                                        <th data-hide="all">网站标题</th>
                                        <th data-hide="all">网站网址</th>
                                        <th data-hide="all">网站编号</th>
                                        <th data-hide="all">广告位编号</th>
                                    </tr>
                                    </thead>
                                    <tbody rel-action="viewer">
                                    @foreach($data as $items)
                                        <tr>
                                            <td class="text-center"></td>
                                            <td>{{ $items->program->title ?? '--' }}</td>
                                            <td>{{ $items->element->title ?? '--' }}</td>
                                            <td>{{ $items->creative->title ?? '--' }}</td>
                                            <td>{{ $items->site->title }}</td>
                                            <td>{{ $items->channel->title }}</td>
                                            <td>{{ $items->adsense->title }}</td>
                                            <td>{{ $items->size->title }}</td>
                                            <td>
                                                {{ $items->size->width }}x{{ $items->size->height }}
                                            </td>
                                            <td width="120">
                                                @if($items->creative->image)
                                                    <a href="javascript:void(0);">
                                                        <img src="{{ $items->creative->image }}" style="max-height: 18px;">
                                                    </a>
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $items->type }}</td>
                                            <td class="text-center">{{ $items->request_time }}</td>
                                            <td>{{ $items?->visitor?->guid ?? '--' }}</td>
                                            <td>{{ $items?->visitor?->uuid ?? '--' }}</td>
                                            <td>{{ $items->ruid ?? '--' }}</td>
                                            <td>{{ $items?->visitor?->language ?? '--' }}</td>
                                            <td>{{ $items?->visitor?->platform ?? '--' }}</td>
                                            <td>{{ $items?->visitor?->getDevice($items?->visitor?->device) ?? '--' }}</td>
                                            <td>
                                                {{ $items?->visitor?->screen_width }}x{{ $items?->visitor?->screen_height }}
                                            </td>
                                            <td>{{ $items?->visitor?->user_agent ?? '--' }}</td>
                                            <td>{{ $items->ip }}</td>
                                            <td>{{ $items?->document_referrer ?? '--' }}</td>
                                            <td>{{ $items?->document_title ?? '--' }}</td>
                                            <td>{{ $items?->document_url ?? '--' }}</td>
                                            <td>{{ $items->site_id ? password($items->site_id, $items->site_id) : '--' }}</td>
                                            <td>{{ $items->adsense_id ? password($items->adsense_id, $items->adsense_id) : '--' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot style="display: none;">
                                    <tr>
                                        <td class="pagination"></td>
                                    </tr>
                                    </tfoot>
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
