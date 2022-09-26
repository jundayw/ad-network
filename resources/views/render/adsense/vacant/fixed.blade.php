@extends('render.layouts.render')

@section('content')
    <a href="{{ $material['location'] }}" target="_blank">
        <img class="images" src="{{ $material['image'] }}" callback="{{ $material['callback'] }}">
    </a>
@endsection
