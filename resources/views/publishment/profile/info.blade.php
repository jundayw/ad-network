@extends('publishment.layouts.main')

@push('plugins')
    <script>
        $(function () {
            $('[preview]').each(function () {
                $(this).find('img').attr('src') ? $(this).removeClass('hidden') : $(this).addClass('hidden');
            });
            $('[name=licence_image]').bind('file:upload.success', function (event, data, files) {
                console.log(files)
                $($(this).data('target')).removeClass('hidden').find('img').attr('src', files.shift());
            })
        });
    </script>
@endpush

@section('content')
    @if($data->publishment->audit == 'init')
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            请尽快补充相关资料
        </div>
    @endif
    @if($data->publishment->audit == 'wait')
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            资料已提交，等待审核！
        </div>
    @endif
    @if($data->publishment->audit == 'success')
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            审核成功
        </div>
    @endif
    @if($data->publishment->audit == 'failure')
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            审核失败
        </div>
    @endif
    @if($data->publishment->audit == 'stop')
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            终止合作
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-{{ match($data->publishment->audit){'init'=>'warning','wait'=>'info','success'=>'success','failure','stop'=>'danger'} }}">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('publishment.profile.info') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <!--div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">总额</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->publishment->total }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">余额</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->publishment->balance }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">冻结金额</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->publishment->frozen }}</p>
                                </div>
                            </div-->
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">{{ $data->publishment->type == 'company' ? '公司名称' : '真实姓名' }}</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="name" value="{{ $data->publishment->name }}" placeholder="请输入{{ $data->publishment->type == 'company' ? '公司名称' : '真实姓名' }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">{{ $data->publishment->type == 'company' ? '营业执照编号' : '身份证编号' }}</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="licence" value="{{ $data->publishment->licence }}" placeholder="请输入{{ $data->publishment->type == 'company' ? '营业执照编号' : '身份证编号' }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row" rel-action="viewer" preview>
                                <label class="col-md-2 control-label col-form-label">图片预览</label>
                                <div class="col-md-10">
                                    <a href="javascript:void(0);">
                                        <img src="{{ $data->publishment->licence_image }}" style="max-height:200px;" class="img-responsive thumbnail m-b-0">
                                    </a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">{{ $data->publishment->type == 'company' ? '营业执照附件' : '身份证附件' }}</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="licence_image" value="{{ $data->publishment->licence_image }}" data-target="[preview]" placeholder="请上传图片" autocomplete="off">
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
                                    <input class="form-control" type="text" name="corporation" value="{{ $data->publishment->corporation }}" placeholder="请输入联系人" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">联系电话</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="mobile" value="{{ $data->publishment->mobile }}" placeholder="请输入联系电话" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">钱包类型</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="wallet" rel-action="select">
                                        @foreach($data->publishment->getWallet() as $key => $wallet)
                                            <option value="{{ $key }}" @selected($key == $data->publishment->wallet)>{{ $wallet }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">钱包地址</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="acount" value="{{ $data->publishment->acount }}" placeholder="请输入钱包地址" autocomplete="off">
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
