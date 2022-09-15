@extends('backend.layouts.main')

@push('plugins')
    <script>
        $(function () {
            $('[name=province_id],[name=city_id],[name=country_id],[name=town_id]').districts({
                data: window.district4,
                callback: function (element, data) {
                    $($(element).attr('rel-name')).val(data.text)
                },
                map: {
                    id: 'id',
                    text: 'text',
                    children: 'children'
                }
            });
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
                    <form action="{{ route('DummyViewRouteClass.store') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">名称</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="title" value="" placeholder="请输入名称" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">状态</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="state" rel-action="select">
                                        @foreach($filter['state'] as $key => $state)
                                            <option value="{{ $key }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">日期时间</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="datetimepicker" value="" placeholder="请选择日期时间" readonly autocomplete="off" rel-action="datetimepicker">
                                        <span class="input-group-addon">
                                            <span class="icon-speedometer"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">日期</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="datepicker" value="" placeholder="请选择日期" readonly autocomplete="off" rel-action="datepicker">
                                        <span class="input-group-addon">
                                            <span class="icon-calender"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">时间</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="timepicker" value="" placeholder="请选择时间" readonly autocomplete="off" rel-action="timepicker">
                                        <span class="input-group-addon">
                                            <span class="icon-clock"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">日期</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="datepicker" value="" placeholder="请选择日期" readonly autocomplete="off" rel-action="datepicker">
                                        <span class="input-group-addon">
                                            <span class="icon-calender"></span>
                                        </span>
                                        <input class="form-control" type="text" name="datepicker" value="" placeholder="请选择日期" readonly autocomplete="off" rel-action="datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">地区</label>
                                <div class="col-md-2">
                                    <select class="form-control" rel-action="select" name="province_id" rel-target="[name=city_id]" rel-name="[name=province]" rel-option="500000" data-placeholder="请选择省/直辖市"></select>
                                    <span class="help-block">请准确填写,附近服务依该地址为准</span>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" rel-action="select" name="city_id" rel-target="[name=county_id]" rel-name="[name=city]" rel-option="500100" data-placeholder="请选择市/区"></select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" rel-action="select" name="county_id" rel-target="[name=town_id]" rel-name="[name=county]" rel-option="500113" data-placeholder="请选择县/区"></select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" rel-action="select" name="town_id" rel-name="[name=town]" rel-option="500113005" data-placeholder="请选择镇/乡/街道"></select>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="detail" value="" placeholder="请输入详细地址" autocomplete="off">
                                </div>
                                <input type="hidden" name="province" value=""/>
                                <input type="hidden" name="city" value=""/>
                                <input type="hidden" name="county" value=""/>
                                <input type="hidden" name="town" value=""/>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">图片地址</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="image" value="" placeholder="请上传图片地址" autocomplete="off">
                                        <label for="image" class="input-group-addon">上传</label>
                                        <input
                                                id="image"
                                                type="file"
                                                rel-action="file"
                                                rel-target="[name=image]"
                                                rel-url="{{ route('utils.upload.images') }}"
                                                class="hidden">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">注册资本</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="capital" value="" placeholder="请输入注册资本" autocomplete="off">
                                        <span class="input-group-addon">万元</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">描述</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="description" rows="5" placeholder="请输入描述"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">排序</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="sorting" value="1" placeholder="请输入排序，数字越大越靠前" autocomplete="off">
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
