@extends('backend.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('backend.publishment.update') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">类型</label>
                                <div class="col-md-10">
                                    <div class="radio-list">
                                        @foreach($filter['type'] as $key => $item)
                                            <label class="radio-inline">
                                                <input type="radio" name="type" value="{{ $key }}" @checked($data->type == $key)>
                                                {{ $item }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">公司名称/真实姓名</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="name" value="{{ $data->name }}" placeholder="请输入公司名称/真实姓名" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">营业执照编号/身份证编号</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="licence" value="{{ $data->licence }}" placeholder="请输入营业执照编号/身份证编号" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row" rel-action="viewer" rel-origin="[name=licence_image]">
                                <label class="col-md-2 control-label col-form-label">图片预览</label>
                                <div class="col-md-10">
                                    <a href="javascript:void(0);">
                                        <img src="{{ $data->licence_image }}" style="max-height:200px;" class="img-responsive thumbnail m-b-0">
                                    </a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">营业执照附件/身份证附件</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="licence_image" value="{{ $data->licence_image }}" rel-action="preview" rel-src="[rel-origin='[name=licence_image]']" placeholder="请上传图片地址" autocomplete="off">
                                        <label for="licence_image" class="input-group-addon">上传</label>
                                        <input
                                                id="licence_image"
                                                type="file"
                                                rel-action="file"
                                                rel-target="[name=licence_image]"
                                                rel-url="{{ route('utils.upload.images') }}"
                                                class="hidden">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">联系人</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="corporation" value="{{ $data->corporation }}" placeholder="请输入联系人" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">联系电话</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="mobile" value="{{ $data->mobile }}" placeholder="请输入联系电话" autocomplete="off">
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
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">审核状态</label>
                                <div class="col-md-10">
                                    <div class="radio-list">
                                        @foreach($filter['audit'] as $key => $item)
                                            <label class="radio-inline">
                                                <input type="radio" name="audit" value="{{ $key }}" @checked($data->audit == $key)>
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
