@extends('backend.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    搜索：{{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.deposit.list') }}" class="form-horizontal" method="get">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">交易流水号</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="deposit_number" value="{{ $request->get('deposit_number') }}" placeholder="请输入交易流水号" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">支付订单号</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="payment_number" value="{{ $request->get('payment_number') }}" placeholder="请输入支付订单号" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">交易摘要</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="remark" value="{{ $request->get('remark') }}" placeholder="请输入交易摘要" autocomplete="off">
                                </div>
                                <label class="col-md-1 control-label col-form-label">交易主体</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="title" value="{{ $request->get('title') }}" placeholder="请输入交易主体" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 control-label col-form-label">交易类型</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="depositer" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['depositer'] as $key => $depositer)
                                            <option value="{{ $key }}" @selected($key == $request->get('depositer'))>{{ $depositer }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 control-label col-form-label">交易类型</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="type" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['type'] as $key => $type)
                                            <option value="{{ $key }}" @selected($key == $request->get('type'))>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 control-label col-form-label">交易渠道</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="payment" rel-action="select">
                                        <option value="">不限</option>
                                        @foreach($filter['payment'] as $key => $payment)
                                            <option value="{{ $key }}" @selected($key == $request->get('payment'))>{{ $payment }}</option>
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
                                <a class="btn btn-default btn-outline" href="{{ route('backend.deposit.list') }}">重置</a>
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
                                        <th class="text-center">交易流水号</th>
                                        <th class="text-center" colspan="2">交易主体</th>
                                        <th class="text-center">总额</th>
                                        <th class="text-center">余额</th>
                                        <th class="text-center">冻结金额</th>
                                        <th class="text-center">支付订单号</th>
                                        <th class="text-center">交易类型</th>
                                        <th class="text-center">交易渠道</th>
                                        <th class="text-center">交易金额</th>
                                        <th class="text-center">交易时间</th>
                                        <th class="text-center">状态</th>
                                        <th class="text-center text-nowrap">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $items)
                                        <tr>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" data-toggle="tooltip" data-original-title="{{ $items->remark }}">
                                                    {{ $items->id }}
                                                </a>
                                            </td>
                                            <td class="text-center">{{ $items->deposit_number }}</td>
                                            <td>{{ $items->depositer }}</td>
                                            <td>{{ $items->deposit->name }}</td>
                                            <td class="text-right">{{ $items->deposit->total }}</td>
                                            <td class="text-right">{{ $items->deposit->balance }}</td>
                                            <td class="text-right">{{ $items->deposit->frozen }}</td>
                                            <td class="text-center">{{ $items->payment_number }}</td>
                                            <td class="text-center">{{ $items->type }}</td>
                                            <td class="text-center">{{ $items->payment }}</td>
                                            <td class="text-right">{{ $items->amount }}</td>
                                            <td class="text-center">{{ $items->update_time }}</td>
                                            <td class="text-center">{{ $items->state }}</td>
                                            <td class="text-right text-nowrap">
                                                @if($items->getOriginal('state') == 'wait')
                                                    @policy('backend.deposit.edit')
                                                    <a href="{{ $items->edit }}" rel-action="dialog" rel-width="760" rel-height="685" title="审核">审核</a>
                                                    @endpolicy
                                                @endif
                                                @policy('backend.deposit.destroy')
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
