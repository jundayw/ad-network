@extends('advertisement.layouts.application')

@push('plugins')
    <script>
        $(function () {
            $('[email=code]').click(function () {
                var url = $(this).data('url');
                $.ajax({
                    url: url,
                    data: {
                        email: $('[name=email]').val(),
                        captcha: $('[name=captcha]').val(),
                        action: 'signup'
                    },
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function (XMLHttpRequest) {
                    },
                    success: function (data, textStatus) {
                        data = $.correct(data);
                        layer.msg(data.message, {
                            shift: data.state ? 2 : 6
                        });
                        if (data.state === false || data.state === undefined) {
                            return false;
                        }
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg(XMLHttpRequest.statusText, {
                            shift: 2
                        });
                    }
                });
                return false;
            });
        });
    </script>
@endpush

@section('main')
    <body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="login-register">
        <div class="login-box login-sidebar">
            <div class="white-box">
                <form action="{{ route('advertisement.register') }}" class="form-horizontal" method="post" rel-action="submit">
                    <a href="javascript:void(0)" class="text-center db">
                        <img src="{{ H('plugins/images/eliteadmin-logo-dark.png') }}" alt="Home"><br>
                        <img src="{{ H('plugins/images/eliteadmin-text-dark.png') }}" alt="Home">
                    </a>
                    <h3 class="box-title m-t-40 m-b-0">{{ $share->get('action') }}</h3>
                    <small>Create your account and enjoy</small>
                    <div class="form-group m-t-20">
                        <label class="col-md-12">类型</label>
                        <div class="col-md-12">
                            <div class="radio-list">
                                @foreach($filter['type'] as $key => $type)
                                    <label class="radio-inline">
                                        <input type="radio" name="type" value="{{ $key }}" @checked($loop->first)>
                                        {{ $type }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">用户名</label>
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="username" value="" placeholder="请输入用户名" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">密码</label>
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" value="" placeholder="请输入密码" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">邮件</label>
                        <div class="col-md-12">
                            <input type="email" name="email" class="form-control" value="" placeholder="请输入邮件" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">验证码</label>
                        <div class="col-xs-12">
                            <div class="input-group">
                                <input class="form-control" type="text" name="captcha" value="" placeholder="请输入验证码" autocomplete="off">
                                <img class="model_img" src="{{ route('utils.captcha', ['signup', 'height' => 38]) }}" alt="验证码" title="点击刷新" rel-action="captcha">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">邮箱验证码</label>
                        <div class="col-xs-12">
                            <div class="input-group">
                                <input class="form-control" type="text" name="code" value="" placeholder="请输入邮箱验证码" autocomplete="off">
                                <div class="input-group-btn">
                                    <button class="btn btn-info" email="code" data-url="{{ route('advertisement.mail') }}" type="button">获取邮箱验证码</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @csrf
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-block text-uppercase waves-effect waves-light" type="submit">
                                注册
                            </button>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-md-12">
                            <a href="{{ route('advertisement.login') }}" class="text-dark">
                                已有账号
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    </body>
@endsection
