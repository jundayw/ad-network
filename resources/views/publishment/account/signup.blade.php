@extends('publishment.layouts.application')

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
                <form action="{{ route('publishment.register') }}" class="form-horizontal" method="post" rel-action="submit">
                    <a href="javascript:void(0)" class="text-center db">
                        <img src="{{ H('plugins/images/eliteadmin-logo-dark.png') }}" alt="Home"><br>
                        <img src="{{ H('plugins/images/eliteadmin-text-dark.png') }}" alt="Home">
                    </a>
                    <h3 class="box-title m-t-40 m-b-0">{{ $share->get('action') }}</h3>
                    <small>Create your account and enjoy</small>
                    <div class="form-group m-t-20">
                        <label class="col-md-12">??????</label>
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
                        <label class="col-md-12">?????????</label>
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="username" value="" placeholder="??????????????????" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">??????</label>
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" value="" placeholder="???????????????" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">??????</label>
                        <div class="col-md-12">
                            <input type="email" name="email" class="form-control" value="" placeholder="???????????????" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">?????????</label>
                        <div class="col-xs-12">
                            <div class="input-group">
                                <input class="form-control" type="text" name="captcha" value="" placeholder="??????????????????" autocomplete="off">
                                <img class="model_img" src="{{ route('utils.captcha', ['signup', 'height' => 38]) }}" alt="?????????" title="????????????" rel-action="captcha">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">???????????????</label>
                        <div class="col-xs-12">
                            <div class="input-group">
                                <input class="form-control" type="text" name="code" value="" placeholder="????????????????????????" autocomplete="off">
                                <div class="input-group-btn">
                                    <button class="btn btn-info" email="code" data-url="{{ route('publishment.mail') }}" type="button">?????????????????????</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @csrf
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-block text-uppercase waves-effect waves-light" type="submit">
                                ??????
                            </button>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-md-12">
                            <a href="{{ route('publishment.login') }}" class="text-dark">
                                ????????????
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    </body>
@endsection
