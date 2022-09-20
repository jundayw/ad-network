@extends('advertisement.layouts.main')

@section('content')
    @if($data->advertisement->audit == 'init')
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            请尽快补充相关资料
        </div>
    @endif
    @if($data->advertisement->audit == 'wait')
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            资料已提交，等待审核！
        </div>
    @endif
    @if($data->advertisement->audit == 'success')
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            审核成功
        </div>
    @endif
    @if($data->advertisement->audit == 'failure')
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            审核失败
        </div>
    @endif
    @if($data->advertisement->audit == 'stop')
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            终止合作
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-{{ match($data->advertisement->audit){'init'=>'warning','wait'=>'info','success'=>'success','failure','stop'=>'danger'} }}">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('advertisement.profile.info') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <!--div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">总额</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->advertisement->total }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">余额</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->advertisement->balance }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">冻结金额</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->advertisement->frozen }}</p>
                                </div>
                            </div-->
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">{{ $data->advertisement->type == 'company' ? '公司名称' : '真实姓名' }}</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="name" value="{{ $data->advertisement->name }}" placeholder="请输入{{ $data->advertisement->type == 'company' ? '公司名称' : '真实姓名' }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">{{ $data->advertisement->type == 'company' ? '营业执照编号' : '身份证编号' }}</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="licence" value="{{ $data->advertisement->licence }}" placeholder="请输入{{ $data->advertisement->type == 'company' ? '营业执照编号' : '身份证编号' }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row" rel-vacant="default">
                                <label class="col-md-2 control-label col-form-label">{{ $data->advertisement->type == 'company' ? '营业执照附件' : '身份证附件' }}</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="licence_image" value="{{ $data->advertisement->licence_image }}" placeholder="请上传图片" autocomplete="off">
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
                                    <input class="form-control" type="text" name="corporation" value="{{ $data->advertisement->corporation }}" placeholder="请输入联系人" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">联系电话</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="mobile" value="{{ $data->advertisement->mobile }}" placeholder="请输入联系电话" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="offset-md-2">
                                <button type="submit" class="btn btn-default btn-outline">认证</button>
                                <button type="reset" class="btn btn-default btn-outline">重置</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
