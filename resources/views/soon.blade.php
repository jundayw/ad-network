<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title ?? '' }}</title>
    <meta name="keywords" content="{{ $keywords ?? '' }}"/>
    <meta name="description" content="{{ $description ?? '' }}"/>
    <!-- Required CSS files -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="{{ H('assets/css/owl.carousel.css', true) }}">
    <link rel="stylesheet" href="{{ H('assets/css/barfiller.css', true) }}">
    <link rel="stylesheet" href="{{ H('assets/css/animate.css', true) }}">
    <link rel="stylesheet" href="{{ H('assets/css/font-awesome.min.css', true) }}">
    <link rel="stylesheet" href="{{ H('assets/css/bootstrap.min.css', true) }}">
    <link rel="stylesheet" href="{{ H('assets/css/slicknav.css', true) }}">
    <link rel="stylesheet" href="{{ H('assets/css/main.css', true) }}">
</head>

<body>
<div class="preloader">
    <span class="preloader-spin"></span>
</div>
<div class="site">
    <div class="coming-soon window-height" style="background: url({{ H($background ?? '', true) }}) center bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="coming-soon-logo">
                        <img src="{{ H($logo ?? '', true) }}" alt="{{ $name ?? '' }}">
                    </div>
                    <div class="coming-soon-box bg1">
                        <h2>{{ $activist ?? 'activist' }}</h2>
                        <p>{{ $moment ?? 'moment' }}</p>
                        <div class="counter-box clearfix" data-date="{{ $date ?? get_time() }}" data-location="{{ isset($location) ? route($location) : '' }}">
                            <div class="single-counter">
                                <div class="inner">
                                    <span class="counter-days">00</span>
                                    <span class="text">天</span>
                                </div>
                            </div>
                            <div class="single-counter">
                                <div class="inner">
                                    <span class="counter-hours">00</span>
                                    <span class="text">小时</span>
                                </div>
                            </div>
                            <div class="single-counter">
                                <div class="inner">
                                    <span class="counter-minutes">00</span>
                                    <span class="text">分钟</span>
                                </div>
                            </div>
                            <div class="single-counter">
                                <div class="inner">
                                    <span class="counter-seconds">00</span>
                                    <span class="text">秒</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Required JS files-->
<script src="{{ H('assets/js/jquery-2.2.4.min.js', true) }}"></script>
<script src="{{ H('assets/js/vendor/popper.min.js', true) }}"></script>
<script src="{{ H('assets/js/vendor/bootstrap.min.js', true) }}"></script>
<script src="{{ H('assets/js/vendor/owl.carousel.min.js', true) }}"></script>
<script src="{{ H('assets/js/vendor/isotope.pkgd.min.js', true) }}"></script>
<script src="{{ H('assets/js/vendor/jquery.barfiller.js', true) }}"></script>
<script src="{{ H('assets/js/vendor/loopcounter.js', true) }}"></script>
<script src="{{ H('assets/js/vendor/slicknav.min.js', true) }}"></script>
<script src="{{ H('assets/js/active.js', true) }}"></script>
</body>
</html>
