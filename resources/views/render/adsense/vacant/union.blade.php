@extends('render.layouts.render')

@push('scripts')
    <script type="text/javascript">
        $(function () {
            // 解决联盟广告点击问题
            $("body:not(.logo-container)").click(function () {
                let location = $('[location]').attr('location');
                $.get(location, function (data) {
                    console.log(location)
                });
            });
        });
    </script>
@endpush

@section('content')
    <img style="display: none;" src="{{ $union['callback'] }}" location="{{ $union['location'] }}">
    {!! $union['code'] !!}
@endsection
