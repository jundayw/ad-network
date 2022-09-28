@extends('publishment.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('publishment.deposit.update') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">余额</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->balance }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">冻结金额</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->frozen }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">交易渠道</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">线下人工确认</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">钱包类型</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->getWallet($data->wallet) }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">钱包地址</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->acount }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">金额</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="amount" value="" placeholder="请输入金额" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">交易备注</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="remark" value="" placeholder="请输入交易备注" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="offset-md-2">
                                <button type="submit" class="btn btn-default btn-outline">提现</button>
                                <button type="reset" class="btn btn-default btn-outline">重置</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
