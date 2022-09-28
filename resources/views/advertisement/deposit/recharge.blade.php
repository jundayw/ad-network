@extends('advertisement.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('advertisement.deposit.store') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">金额</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="amount" value="" placeholder="请输入金额" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">交易渠道</label>
                                <div class="col-md-10">
                                    <div class="radio-list">
                                        @foreach($filter['payment'] as $key => $item)
                                            <label class="radio-inline">
                                                <input type="radio" name="payment" value="{{ $key }}" @checked($loop->first)>
                                                {{ $item }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">交易摘要</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="remark" value="" placeholder="请输入交易摘要" autocomplete="off">
                                    <span class="help-block">
                                        若线下转账，请注明转账备注信息
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="offset-md-2">
                                <button type="submit" class="btn btn-default btn-outline">充值</button>
                                <button type="reset" class="btn btn-default btn-outline">重置</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
