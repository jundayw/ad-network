@extends('backend.layouts.main')

@push('plugins')
    <script>
        $(function () {
            $('[rel-action=all]').click(function () {
                $($(this).attr('rel-target')).each(function () {
                    $(this).prop('checked', true);
                });
            });
            $('[rel-action=cancel]').click(function () {
                $($(this).attr('rel-target')).each(function () {
                    $(this).prop('checked', false);
                });
            });
            $('[rel-action=reverse]').click(function () {
                $($(this).attr('rel-target')).each(function () {
                    $(this).prop('checked', !$(this).prop('checked'));
                });
            });
        });
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
                    <form action="{{ route('backend.role.update') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">名称</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="title" value="{{ $data->title }}" placeholder="请输入地址" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">描述</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="description" rows="5" placeholder="请输入描述">{{ $data->description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">策略</label>
                                <div class="col-md-10">
                                    <div class="table-responsive">
                                        <table class="table">
                                            @forelse($data->module->policies as $policies)
                                                <tr>
                                                    <td colspan="4" class="text-left">
                                                        <div class="checkbox">
                                                            <input id="policy-{{ $policies->id }}" policy-{{ $policies->id }} type="checkbox" name="policies[]" value="{{ $policies->id }}" @checked(in_array($policies->id, $data->policies))>
                                                            <label for="policy-{{ $policies->id }}">
                                                                {{ $policies->title }}
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td colspan="4" class="text-right">
                                                        <a href="javascript:void(0);" rel-action="all" rel-target="[policy-{{ $policies->id }}]">全选</a>
                                                        <a href="javascript:void(0);" rel-action="cancel" rel-target="[policy-{{ $policies->id }}]">取消</a>
                                                        <a href="javascript:void(0);" rel-action="reverse" rel-target="[policy-{{ $policies->id }}]">反选</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    @foreach($policies->policies as $policy)
                                                        <td @if($loop->last && fmod($loop->count,8))colspan="{{ 9-fmod($loop->count,8) }}"@endif>
                                                            <div class="checkbox">
                                                                <input id="policy-{{ $policy->id }}" policy-{{ $policies->id }} type="checkbox" name="policies[]" value="{{ $policy->id }}" @checked(in_array($policy->id, $data->policies))>
                                                                <label for="policy-{{ $policy->id }}">
                                                                    {{ $policy->title }}
                                                                </label>
                                                            </div>
                                                        </td>
                                                        {!! fmod($loop->iteration,8) ? '' : '</tr><tr>' !!}
                                                    @endforeach
                                                </tr>
                                            @empty
                                                <thead>
                                                <tr>
                                                    <th>暂无策略</th>
                                                </tr>
                                                </thead>
                                            @endforelse
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">排序</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="sorting" value="{{ $data->sorting }}" placeholder="请输入排序，数字越大越靠前" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">状态</label>
                                <div class="col-md-10">
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
                        </div>
                        <input type="hidden" name="id" value="{{ $data->id }}"/>
                        <div class="panel-footer">
                            <div class="offset-md-2">
                                <button type="submit" class="btn btn-default btn-outline">保存</button>
                                <button type="reset" class="btn btn-default btn-outline">重置</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
