@extends('publishment.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats">
                    <i class="ti-wallet bg-success"></i>
                    <div class="bodystate">
                        <h4>{{ $request->user()->publishment->getAttribute('total') }}</h4>
                        <span class="text-muted">账户总额</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats">
                    <i class="ti-wallet bg-info"></i>
                    <div class="bodystate">
                        <h4>{{ $request->user()->publishment->getAttribute('balance') }}</h4>
                        <span class="text-muted">账户余额</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats">
                    <i class="ti-wallet bg-danger"></i>
                    <div class="bodystate">
                        <h4>{{ $request->user()->publishment->getAttribute('frozen') }}</h4>
                        <span class="text-muted">账户冻结金额</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats">
                    <i class="ti-shield bg-inverse"></i>
                    <div class="bodystate">
                        <h4>{{ $request->user()->publishment->getAttribute('weight') }}</h4>
                        <span class="text-muted">账户权重</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Blank Starter page</h3>
            </div>
        </div>
    </div>
@endsection
