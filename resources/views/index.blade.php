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
    <header>
        <div class="container">
            <div class="row">
                <div class="col-6 col-sm-3 logo-column">
                    <a href="{{ isset($url) ? route($url) : '' }}" title="{{ $name ?? '' }}" class="logo">
                        <img src="{{ H($logo ?? '', true) }}" alt="{{ $name ?? '' }}">
                    </a>
                </div>
                @if($navigation = $navigation ?? [])
                    <div class="col-6 col-sm-9 nav-column clearfix">
                        <nav id="menu" class="d-none d-lg-block">
                            <ul>
                                @foreach($navigation as $item)
                                    <li><a href="{{ is_array($item['url']) ? route($item['url'][0]) . $item['url'][1] : route($item['url']) }}" target="_blank">{{ $item['title'] }}</a></li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </header>
    @if($sliders = $sliders ?? [])
        <div class="hero-slider">
            @foreach($sliders as $slider)
                <div class="single-slide" style="background: url({{ H($slider['background'], true) }}) center bottom;">
                    <div class="inner">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="slide-content">
                                        <h2>{{ $slider['title'] }}</h2>
                                        @foreach($slider['content'] as $content)
                                            <p>{{ $content }}</p>
                                        @endforeach
                                        <div class="slide-btn">
                                            <a href="{{ route($slider['url']) }}" target="_blank" class="button">{{ $slider['name'] }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @foreach($sliders as $slider)
                <div class="single-slide" style="background: url({{ H($slider['background'], true) }}) center bottom;">
                    <div class="inner">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 text-center">
                                    <div class="slide-content">
                                        <h2>{{ $slider['title'] }}</h2>
                                        @foreach($slider['content'] as $content)
                                            <p>{{ $content }}</p>
                                        @endforeach
                                        <div class="slide-btn">
                                            <a href="{{ route($slider['url']) }}" class="button">{{ $slider['name'] }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    @if($advertisement = $advertisement ?? [])
        <div class="about-area sp">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="about-content">
                            <h3>{{ $advertisement['title'] }}</h3>
                            @foreach($advertisement['content'] as $content)
                                <p>{{ $loop->iteration }}、{{ $content }}</p>
                            @endforeach
                            <a href="{{ route($advertisement['url']) }}" target="_blank" class="button">{{ $advertisement['name'] }}</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="about-img">
                            <img src="{{ H($advertisement['image'], true) }}" alt="{{ $advertisement['name'] }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="service-area bg1 sp">
            <div class="container">
                <div class="section-title white">
                    <h2>{{ $advertisement['service']['title'] }}</h2>
                    <p>{{ $advertisement['service']['desc'] }}</p>
                </div>
                <div class="row">
                    @foreach($advertisement['service']['list'] as $list)
                        <div class="col-lg-4 col-md-6 single-service-3">
                            <div class="inner">
                                <div class="title">
                                    <div class="icon">
                                        <i class="{{ $list['icon'] }}"></i>
                                    </div>
                                    <h4>{{ $list['title'] }}</h4>
                                </div>
                                <div class="content">
                                    @foreach($list['content'] as $content)
                                        <p>{{ $content }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if($publishment = $publishment ?? [])
        <div class="about-area sp">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="about-content">
                            <h3>{{ $publishment['title'] }}</h3>
                            @foreach($publishment['content'] as $content)
                                <p>{{ $loop->iteration }}、{{ $content }}</p>
                            @endforeach
                            <a href="{{ route($publishment['url']) }}" target="_blank" class="button">{{ $publishment['name'] }}</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="about-img">
                            <img src="{{ H($publishment['image'], true) }}" alt="{{ $publishment['name'] }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="service-area bg1 sp">
            <div class="container">
                <div class="section-title white">
                    <h2>{{ $publishment['service']['title'] }}</h2>
                    <p>{{ $publishment['service']['desc'] }}</p>
                </div>
                <div class="row">
                    @foreach($publishment['service']['list'] as $list)
                        <div class="col-lg-4 col-md-6 single-service-3">
                            <div class="inner">
                                <div class="title">
                                    <div class="icon">
                                        <i class="{{ $list['icon'] }}"></i>
                                    </div>
                                    <h4>{{ $list['title'] }}</h4>
                                </div>
                                <div class="content">
                                    @foreach($list['content'] as $content)
                                        <p>{{ $content }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if($faq = $faq ?? [])
        <div class="faq-area sp bg2">
            <div class="container">
                <div class="section-title">
                    <h2>{{ $faq['title'] }}</h2>
                    <p>{{ $faq['desc'] }}</p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="faq">
                            @foreach($faq['list'] as $list)
                                <div class="single-item">
                                    <h4>{{ $list['title'] }}</h4>
                                    <div class="content">{{ $list['content'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="faq-img text-center">
                            <img src="{{ H('assets/img/fag-img.png', true) }}" alt="faq">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <footer>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="copyright-txt">
                            Copyright &copy; 2020 {{ $name ?? '' }} All rights reserved.
                        </div>
                    </div>
                    <div class="col-lg-6 text-right">
                        <div class="footer-nav">
                            @foreach($navigation as $item)
                                <a href="{{ is_array($item['url']) ? route($item['url'][0]) . $item['url'][1] : route($item['url']) }}" target="_blank">{{ $item['title'] }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
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
