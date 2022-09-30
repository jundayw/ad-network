@extends('render.layouts.render')

@push('styles')
    <style>
        .swiper-container, .swiper-wrapper {
            height: 100% !important;
        }
    </style>
@endpush

@push('scripts')
    <link href="{{ H('plugins/components/swiper/css/swiper.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ H('plugins/components/swiper/js/swiper.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $(function () {
            new Swiper('.swiper-container', {
                grabCursor: true,
                effect: 'fade',
                loop: true,
                autoplay: {
                    delay: 1500 * (1 + Math.random()),
                    disableOnInteraction: false,
                },
            });
        });
    </script>
@endpush

@section('content')
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach($multigraph as $creative)
                <div class="swiper-slide">
                    <a href="{{ $creative['location'] }}" target="_blank">
                        <img class="images" src="{{ $creative['image'] }}" callback="{{ $creative['callback'] }}">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
