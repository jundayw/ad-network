@extends('advertisement.layouts.main')

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
                    trigger: 'axis',
                    valueFormatter: (value) => '$' + value.toFixed(2)
                },
                legend: {
                    x: 'center',
                    y: 'bottom',
                    data: ['您的广告物料尺寸', '平台广告位尺寸']
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
                        name: '您的广告物料尺寸',
                        type: 'line',
                        smooth: true,
                        itemStyle: {
                            normal: {
                                areaStyle: {
                                    type: 'default'
                                }
                            }
                        },
                        data: [{!! $data['size']['creative'] !!}],
                        markPoint: {
                            data: [
                                {type: 'max', name: '最大值'},
                            ]
                        }
                    },
                    {
                        name: '平台广告位尺寸',
                        type: 'line',
                        smooth: true,
                        itemStyle: {
                            normal: {
                                areaStyle: {
                                    type: 'default'
                                }
                            }
                        },
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
        $(function () {
            var dom = document.getElementById("vacation");
            var myChart = echarts.init(dom);
            option = {
                grid: {
                    left: 60,
                    right: 50
                },
                title: {
                    x: 'center',
                    text: '近七日广告支出分布',
                    subtext: '报告生成时间：{{ $filter['time'] }}'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    x: 'center',
                    y: 'bottom',
                    data: [{!! $data['vacation']['type'] !!}]
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
                    data: [{!! $data['vacation']['times'] !!}]
                },
                yAxis: [
                    {
                        type: 'value',
                        axisLabel: {
                            formatter: '{value}'
                        }
                    }
                ],
                series: [
                        @foreach($data['vacation']['data'] as $key => $type)
                    {
                        name: '{{ $key }}',
                        type: 'line',
                        smooth: true,
                        itemStyle: {
                            normal: {
                                areaStyle: {
                                    type: 'default'
                                }
                            }
                        },
                        data: [{!! $type !!}],
                        markPoint: {
                            data: [
                                {type: 'max', name: '最大值'},
                            ]
                        }
                    },
                    @endforeach
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
                        <h4>{{ $data['advertisement']->getAttribute('total') }}</h4>
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
                        <h4>{{ $data['advertisement']->getAttribute('balance') }}</h4>
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
                        <h4>{{ $data['advertisement']->getAttribute('frozen') }}</h4>
                        <span class="text-muted">账户冻结金额</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats">
                    <i class="ti-gallery bg-inverse"></i>
                    <div class="bodystate">
                        <h4>{{ $data['advertisement']->getAttribute('frozen') }}</h4>
                        <span class="text-muted">广告创意</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">近七日广告支出分布</h3>
                <div id="vacation" style="height:320px;"></div>
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
