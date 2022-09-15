<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="https://github.com/jundayw">
    <title>{{ config('app.name') }} | {{ $share->get('action') }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ H('plugins/images/favicon.png') }}">
@stack('metas')
    <!-- Bootstrap Core CSS -->
    <link href="{{ H('dist/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ H('plugins/components/bootstrap-extension/css/bootstrap-extension.css') }}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ H('dist/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ H('dist/css/style.css') }}" rel="stylesheet">
    <link href="{{ H('dist/style/style.css', true) }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ H('dist/css/colors/default.css') }}" id="theme" default="{{ H('dist/css/colors/default.css') }}" rel="stylesheet">
@stack('styles')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->
    <script src="{{ H('plugins/components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ H('dist/bootstrap/dist/js/tether.min.js') }}"></script>
    <script src="{{ H('dist/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ H('plugins/components/bootstrap-extension/js/bootstrap-extension.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ H('plugins/components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ H('dist/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ H('dist/js/waves.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ H('dist/js/custom.min.js') }}"></script>
    <!--Style Switcher -->
    <script src="{{ H('dist/js/jquery.style.switcher.js', true) }}"></script>
    <!--layer -->
    <script src="{{ H('plugins/components/layer/layer.js') }}"></script>
    <!-- select2 -->
    <link href="{{ H('plugins/components/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <script src="{{ H('plugins/components/select2/dist/js/select2.min.js') }}"></script>
    <!-- datetimepicker  -->
    <link href="{{ H('plugins/components/datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <script src="{{ H('plugins/components/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ H('plugins/components/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js') }}"></script>
    <script src="{{ H('plugins/components/district/district.js') }}"></script>
{{--<script src="{{ H('plugins/components/district/district4.js') }}"></script>--}}
@stack('scripts')
    <script src="{{ H('dist/js/utils.js', true) }}"></script>
    <script src="{{ H('dist/js/common.js', true) }}"></script>
    <script src="{{ H('dist/js/main.js', true) }}"></script>
@stack('plugins')
</head>
@yield('main')
</html>
