@extends('backend.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('publishment.site.verification') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">验证方式</label>
                                <div class="col-md-10">
                                    <div class="radio-list">
                                        @foreach($filter['type'] as $key => $item)
                                            <label class="radio-inline">
                                                <input type="radio" name="type" value="{{ $key }}" @checked($loop->first)>
                                                {{ $item }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">验证网站</label>
                                <div class="col-md-10">
                                    <div class="white-box p-0">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="nav-item" aria-expanded="false">
                                                <a href="#home" class="nav-link active" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                                                    <span class="visible-xs">
                                                        <i class="ti-home"></i>
                                                    </span>
                                                    <span class="hidden-xs">文件验证</span>
                                                </a>
                                            </li>
                                            <li role="presentation" class="nav-item">
                                                <a href="#profile" class="nav-link" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">
                                                    <span class="visible-xs"><i class="ti-user"></i></span>
                                                    <span class="hidden-xs">HTML标签验证</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="home" aria-expanded="true">
                                                <ul class="list-icons">
                                                    <li>
                                                        <i class="ti-angle-right"></i>
                                                        请点击 <a href="{{ route('publishment.site.download', ['verification' => $data['verification'], 'verify' => $data['verify']]) }}" target="_blank">下载验证文件</a> 获取验证文件
                                                    </li>
                                                    <li>
                                                        <i class="ti-angle-right"></i>
                                                        将验证文件放置于您所配置域名的根目录下
                                                    </li>
                                                    <li>
                                                        <i class="ti-angle-right"></i>
                                                        <a href="{{ $data['txt'] }}" target="_blank">点击这里</a> 确认验证文件可以正常访问
                                                    </li>
                                                    <li>
                                                        <i class="ti-angle-right"></i>
                                                        完成操作后请点击“保存”按钮。
                                                    </li>
                                                    <li class="text-danger">
                                                        <i class="fa fa-chevron-right text-danger"></i>
                                                        为保持验证通过的状态,成功验证后请不要删除文件
                                                    </li>
                                                </ul>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="profile" aria-expanded="false">
                                                <ul class="list-icons">
                                                    <li>
                                                        <i class="ti-angle-right"></i>
                                                        将以下代码添加到您的网站首页 HTML 代码的 <code>&lt;head&gt;</code> 标签与 <code>&lt;/head&gt;</code> 标签之间
                                                    </li>
                                                    <li>
                                                        <i class="ti-angle-right"></i>
                                                        <code>&lt;meta name="{{ $data['verification'] }}" content="{{ $data['verify'] }}" /&gt;</code>
                                                    </li>
                                                    <li>
                                                        <i class="ti-angle-right"></i>
                                                        完成操作后请点击“保存”按钮。
                                                    </li>
                                                    <li class="text-danger">
                                                        <i class="fa fa-chevron-right text-danger"></i>
                                                        为保持验证通过的状态,成功验证后请不要删除该标签
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="verify" value="{{ $request->get('verify') }}"/>
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
