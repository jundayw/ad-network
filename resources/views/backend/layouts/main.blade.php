@extends('backend.layouts.application')

@section('main')
    <body class="fix-sidebar fix-header">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Top Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <a class="navbar-toggle hidden-sm hidden-md hidden-lg" href="javascript:void(0);" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="ti-menu"></i>
                </a>
                <div class="top-left-part">
                    <a class="logo" href="{{ route('backend.index') }}">
                        <b><img src="{{ H('plugins/images/eliteadmin-logo.png') }}" alt="home"/></b>
                        <span class="hidden-xs"><strong>Laravel</strong>Backend</span>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li>
                        <a href="javascript:void(0);" class="open-close hidden-xs waves-effect waves-light">
                            <i class="icon-arrow-left-circle ti-menu"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li class="dropdown">
                        <a class="waves-effect waves-light" href="{{ route('backend.clear') }}" rel-action="confirm" rel-certain="清除缓存" rel-msg="确定清除缓存">
                            <i class="icon-refresh"></i>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="javascript:void(0);">
                            <img src="{{ H('plugins/images/users/varun.jpg') }}" alt="user-img" width="36" class="img-circle">
                            <b class="hidden-xs">{{ $request->user()?->usernick }}</b>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <a href="{{ route('backend.profile.password') }}">
                                    <i class="fa fa-lock"></i>
                                    修改密码
                                </a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{ route('backend.logout') }}" rel-action="confirm" rel-certain="安全退出" rel-msg="确定退出系统">
                                    <i class="fa fa-power-off"></i>
                                    退出
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="right-side-toggle">
                        <a class="waves-effect waves-light" href="javascript:void(0);">
                            <i class="ti-settings"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End Top Navigation -->
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    @foreach($navigations as $navigation)
                        <li class="{{ $navigation->active ? 'active' : '' }}">
                            <a href="javascript:void(0);" class="waves-effect">
                                <i data-icon="{{ $navigation->getAttribute('id') }}" class="{{ $navigation->getAttribute('icon') }} fa-fw"></i>
                                <span class="hide-menu">{{ $navigation->getAttribute('title') }}<span class="fa arrow"></span></span>
                            </a>
                            <ul class="nav nav-second-level">
                                @foreach($navigation->policies as $policy)
                                    <li><a href="{{ route($policy->getAttribute('url')) }}" class="{{ $policy->active ? 'active' : '' }}">{{ $policy->getAttribute('title') }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ route('backend.logout') }}" class="waves-effect">
                            <i class="icon-logout fa-fw"></i>
                            <span class="hide-menu">退出系统</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">{{ $share->get('action') }}</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="javascript:void(0);">{{ $share->get('module') }}</a></li>
                            <li class="active">{{ $share->get('controller') }}</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                @if($share->get('desc'))
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ $share->get('desc') }}
                    </div>
                @endif
                @yield('content')
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title">
                            设置
                            <span><i class="ti-close right-side-toggle"></i></span>
                        </div>
                        <div class="r-panel-body">
                            <ul id="themecolors">
                                <li><b>浅色主题</b></li>
                                <li><a href="javascript:void(0);" theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0);" theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0);" theme="gray" class="yellow-theme">3</a></li>
                                <li><a href="javascript:void(0);" theme="blue" class="blue-theme">4</a></li>
                                <li><a href="javascript:void(0);" theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0);" theme="megna" class="megna-theme">6</a></li>
                                <li><b>深色主题</b></li>
                                <br/>
                                <li><a href="javascript:void(0);" theme="default-dark" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0);" theme="green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0);" theme="gray-dark" class="yellow-dark-theme">9</a></li>
                                <li><a href="javascript:void(0);" theme="blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0);" theme="purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0);" theme="megna-dark" class="megna-dark-theme">12</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.right-sidebar -->
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> {{ date('Y') }} &copy; {{ config('app.name') }}</footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
@endsection
