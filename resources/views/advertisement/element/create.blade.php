@extends('advertisement.layouts.main')

@push('plugins')
    <script>
        $(function () {
            $('[name=type]').change(function () {
                var target = '元';
                switch ($(this).val()) {
                    case 'cpm':
                        target = '元/千次';
                        break;
                    default:
                        target = '元/次';
                }
                $('[target-type]').html(target);
            }).trigger('change');
        });
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
                    <form action="{{ route('advertisement.element.store') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">名称</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="title" value="" placeholder="请输入名称" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">所属广告计划</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="program" rel-action="select">
                                        @foreach($filter['program'] as $key => $program)
                                            <option value="{{ $program->id }}">{{ $program->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">投放日期</label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-addon">开始时间</span>
                                        <input class="form-control" type="text" name="release_begin" value="{{ get_time('Y-m-d 00:00:00') }}" placeholder="请选择投放开始时间" autocomplete="off" rel-action="datetimepicker">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-addon">截止时间</span>
                                        <input class="form-control" type="text" name="release_finish" value="" placeholder="请选择投放截止时间" autocomplete="off" rel-action="datetimepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">投放时段</label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-addon">开始时段</span>
                                        <input class="form-control" type="text" name="period_begin" value="00:00:00" placeholder="请选择投放开始时段" autocomplete="off" rel-action="timepicker">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-addon">截止时段</span>
                                        <input class="form-control" type="text" name="period_finish" value="23:59:59" placeholder="请选择投放截止时段" autocomplete="off" rel-action="timepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">出价方式</label>
                                <div class="col-md-10">
                                    @foreach($filter['type'] as $key => $type)
                                        <div class="form-check">
                                            <label class="radio-inline">
                                                <input type="radio" name="type" value="{{ $key }}" @checked($loop->first)>
                                                {{ $type }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">出价</label>
                                <div class="col-md-5">
                                    <dic class="input-group">
                                        <input class="form-control" type="text" name="rate" value="" placeholder="请输入出价" autocomplete="off">
                                        <span class="input-group-addon" target-type>元</span>
                                    </dic>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">状态</label>
                                <div class="col-md-10">
                                    <div class="radio-list">
                                        @foreach($filter['state'] as $key => $item)
                                            <label class="radio-inline">
                                                <input type="radio" name="state" value="{{ $key }}" @checked($loop->first)>
                                                {{ $item }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
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
