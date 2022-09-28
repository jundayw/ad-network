@extends('backend.layouts.application')

@section('main')
    <body class="fix-sidebar fix-header">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Page Content -->
        <div style="background: #edf1f5">
            <div class="container-fluid p-t-20">
                @if($share->get('desc'))
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ $share->get('desc') }}
                    </div>
                @endif
                @yield('content')
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
@endsection
