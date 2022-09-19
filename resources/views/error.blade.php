@extends('backend.layouts.application')

@section('main')
    <body>
    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1>Error</h1>
                <h3 class="text-uppercase">
                    {{ $message }}
                </h3>
                <p class="text-muted m-t-30 m-b-30">
                    Please try after some time
                </p>
                <a href="javascript:history.back();" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">
                    返回
                </a>
            </div>
            <footer class="footer text-center">{{ date('Y') }} &copy; {{ config('app.name') }}</footer>
        </div>
    </section>
    </body>
@endsection
