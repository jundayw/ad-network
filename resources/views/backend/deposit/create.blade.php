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
            <div class="panel panel-success">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.deposit.store') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group">
                                <label>交易金额</label>
                                <input class="form-control" type="text" name="amount" value="" placeholder="请输入名称" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>交易类型</label>
                                <div class="radio-list">
                                    @foreach($filter['type'] as $key => $item)
                                        <label class="radio-inline">
                                            <input type="radio" name="type" value="{{ $key }}" @checked($loop->first)>
                                            {{ $item }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label>交易摘要</label>
                                <input class="form-control" type="text" name="remark" value="" placeholder="请输入交易摘要" autocomplete="off">
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{ $request->get('id') }}"/>
                        <input type="hidden" name="deposit" value="{{ $request->get('type') }}"/>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-default btn-outline">保存</button>
                            <button type="reset" class="btn btn-default btn-outline">重置</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
