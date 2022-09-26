@extends('render.layouts.render')

@section('content')
    <a href="{{ $unavailable['location'] }}" target="_blank">
        <img class="images" src="{{ $unavailable['image'] }}" callback="{{ $unavailable['callback'] }}">
    </a>
@endsection
