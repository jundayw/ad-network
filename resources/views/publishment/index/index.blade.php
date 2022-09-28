@extends('publishment.layouts.main')

@push('plugins')
    <script type="text/javascript" src="{{ H('plugins/components/echarts/echarts.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            var dom = document.getElementById("container");
            var myChart = echarts.init(dom);
            option = {
                grid: {
                    left: 60,
                    right: 50
                },
                title: {
                    x: 'center',
                    text: '广告创意与广告位尺寸分布',
                    subtext: '报告生成时间：{{ $filter['time'] }}'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    x: 'center',
                    y: 'bottom',
                    data: ['平台广告物料尺寸', '您的广告位尺寸']
                },
                toolbox: {
                    show: true,
                    feature: {
                        mark: {show: true},
                        magicType: {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                calculable: true,
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: [{!! $data['size']['xAxis'] !!}]
                },
                yAxis: [
                    {
                        type: 'value',
                        axisLabel: {
                            formatter: '{value} %'
                        }
                    }
                ],
                series: [
                    {
                        name: '平台广告物料尺寸',
                        type: 'bar',
                        data: [{!! $data['size']['creative'] !!}],
                        markPoint: {
                            data: [
                                {type: 'max', name: '最大值'},
                            ]
                        }
                    },
                    {
                        name: '您的广告位尺寸',
                        type: 'bar',
                        data: [{!! $data['size']['adsense'] !!}],
                        markPoint: {
                            data: [
                                {type: 'max', name: '最大值'},
                            ]
                        }
                    }
                ]
            };
            myChart.setOption(option);
        });
    </script>
@endpush

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
                <h3 class="box-title">广告创意与广告位尺寸分布</h3>
                <div id="container" style="height:320px;"></div>
            </div>
        </div>
    </div>
@endsection
