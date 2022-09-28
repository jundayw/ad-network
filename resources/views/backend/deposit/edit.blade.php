@extends('backend.layouts.dialog')

@push('plugins')
    <script>
        function dialogClose() {
            parent.layer.close(parent.layer.getFrameIndex(window.name));
        }
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.deposit.update') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group">
                                <label>交易主体</label>
                                <input class="form-control" type="text" readonly value="{{ $data->deposit->name }}" placeholder="请输入交易主体" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>账户总额</label>
                                <input class="form-control" type="text" readonly value="{{ $data->deposit->total }}" placeholder="请输入账户总额" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>账户余额</label>
                                <input class="form-control" type="text" readonly value="{{ $data->deposit->balance }}" placeholder="请输入账户余额" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>账户冻结金额</label>
                                <input class="form-control" type="text" readonly value="{{ $data->deposit->frozen }}" placeholder="请输入账户冻结金额" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>钱包类型</label>
                                <input class="form-control" type="text" readonly value="{{ $data->deposit->getWallet($data->deposit->wallet) }}" placeholder="请输入钱包类型" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>钱包地址</label>
                                <input class="form-control" type="text" readonly value="{{ $data->deposit->acount }}" placeholder="请输入钱包地址" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>交易金额</label>
                                <input class="form-control" type="text" readonly value="{{ $data->amount }}" placeholder="请输入交易金额" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>交易类型</label>
                                <div class="radio-list">
                                    @foreach($filter['state'] as $key => $item)
                                        <label class="radio-inline">
                                            <input type="radio" name="state" value="{{ $key }}" @checked($data->state == $key)>
                                            {{ $item }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{ $data->id }}"/>
                        <div class="panel-footer">
                            <div class="offset-md-2">
                                <button type="submit" class="btn btn-default btn-outline">保存</button>
                                <button type="reset" class="btn btn-default btn-outline" rel-action="dialog-close">关闭</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
