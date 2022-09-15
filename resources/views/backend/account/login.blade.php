@extends('backend.layouts.application')

@section('main')
    <body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="login-register">
        <div class="login-box">
            <div class="white-box">
                <form action="{{ route('backend.verify') }}" class="form-horizontal form-material" method="post" rel-action="submit">
                    <h3 class="box-title m-b-20">{{ $share->get('action') }}</h3>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="username" value="founder" placeholder="请输入用户名" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" value="123456" placeholder="请输入密码" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <input class="form-control" type="text" name="captcha" value="6868" placeholder="请输入验证码" autocomplete="off">
                                <img class="model_img" src="{{ route('backend.captcha', ['login']) }}" alt="验证码" title="点击刷新" rel-action="captcha">
                            </div>
                        </div>
                    </div>
                    @csrf
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-block text-uppercase waves-effect waves-light" type="submit">
                                登录
                            </button>
                        </div>
                    </div>
                    @if($request->get('code'))
                        <div class="form-group m-b-0">
                            <div class="col-sm-12 text-center">
                                <p>{{ $message }}</p>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </section>
    </body>
@endsection
