@extends('render.layouts.render')

@section('content')
    <a href="{{ $exchange['location'] }}" target="_blank">
        <img class="images" src="{{ $exchange['image'] }}" callback="{{ $exchange['callback'] }}">
    </a>
@endsection
