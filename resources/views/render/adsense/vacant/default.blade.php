@extends('render.layouts.render')

@section('content')
    <a href="{{ $local['location'] }}" target="_blank">
        <img class="images" src="{{ $local['image'] }}" callback="{{ $local['callback'] }}">
    </a>
@endsection
