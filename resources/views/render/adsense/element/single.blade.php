@extends('render.layouts.render')

@section('content')
    <a href="{{ $creative['location'] }}" target="_blank">
        <img class="images" src="{{ $creative['image'] }}" callback="{{ $creative['callback'] }}">
    </a>
@endsection
