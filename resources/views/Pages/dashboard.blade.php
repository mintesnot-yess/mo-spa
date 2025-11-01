@extends('layouts.app')
@section('title', 'Dashboard')
@push('css')
    <link href="{{ asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush
@section('content')

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Inner content -->
        <div class="content-inner">

            <!-- Page header -->
            <div class="shadow page-header page-header-light">

                <div class="page-header-content d-lg-flex border-top">
                    <div class="d-flex">
                        <div class="py-2 breadcrumb">
                            <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="ph-house"></i></a>
                            {{-- <a href="#" class="breadcrumb-item">Home</a> --}}
                            <span class="breadcrumb-item active">{{ 'Dashboard' }}</span>
                        </div>

                        <a href="#breadcrumb_elements"
                            class="p-0 border-transparent btn btn-light align-self-center collapsed d-lg-none rounded-pill ms-auto"
                            data-bs-toggle="collapse">
                            <i class="m-1 ph-caret-down collapsible-indicator ph-sm"></i>
                        </a>
                    </div>

                </div>
            </div>
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph-user-focus ph-2x text-success me-3"></i>

                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($customer) }}</h4>
                                    <span class="text-muted">Customers</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph ph-users-three ph-2x me-3"></i>
                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($employee) }}</h4>
                                    <span class="text-muted">Employees</span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph ph-stack ph-2x text-primary me-3"></i>
                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($service) }}</h4>
                                    <span class="text-muted">Services</span>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph-text-indent ph-2x text-danger me-3"></i>
                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($totalCategories) }}</h4>
                                    <span class="text-muted"> Total Categories </span>
                                </div>

                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph-user-gear ph-2x me-3"></i>

                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($user) }}</h4>
                                    <span class="text-muted"> System User </span>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph-currency-dollar-simple text-warning ph-2x me-3"></i>

                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($totalTransaction) }}</h4>
                                    <span class="text-muted"> Total Transactions </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph-shield-warning text-yellow ph-2x me-3"></i>

                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($pendingTransaction) }}</h4>
                                    <span class="text-muted"> Pending Transactions </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph-shield-check text-success ph-2x me-3"></i>

                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($complatedTransaction) }}</h4>
                                    <span class="text-muted"> Complated Transactions </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="row">
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <div class="chart has-fixed-height" id="line_multiple" style="height: 440px;"></div>
                                </div>
                            </div>

                            <!-- /line multiples -->

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="row">
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <div class="chart has-fixed-height" id="transaction" style="height: 440px;"></div>
                                </div>
                            </div>

                            <!-- /line multiples -->

                        </div>
                    </div>
                </div>

            </div>
            <!-- /content area -->
            <!-- Theme JS files -->

            <script src="{{ asset('assets/js/vendor/visualization/echarts/echarts.min.js') }}"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Check if echarts is loaded
                    if (typeof echarts === 'undefined') {
                        console.warn('ECharts is not loaded.');
                        return;
                    }

                    var chartEl = document.getElementById('transaction');

                    if (!chartEl) {
                        console.error('Chart container not found');
                        return;
                    }

                    // Init the chart
                    var chart = echarts.init(chartEl, null, {
                        renderer: 'svg'
                    });

                    // Set chart options
                    chart.setOption({
                        color: ['#f17a52', '#03A9F4', '#8E44AD', '#16A085', '#E67E22', '#2C3E50'],
                        textStyle: {
                            fontFamily: 'var(--body-font-family)',
                            color: 'var(--body-color)',
                            fontSize: 14,
                            lineHeight: 22,
                            textBorderColor: 'transparent'
                        },
                        animationDuration: 750,
                        grid: {
                            left: 10,
                            right: 20,
                            top: 40,
                            bottom: 40,
                            containLabel: true
                        },
                        title: {
                            left: 'center',
                            text: 'Total Transaction by Branchs',
                            textStyle: {
                                fontSize: 15,
                                fontWeight: 500,
                                color: 'var(--body-color)'
                            }
                        },
                        tooltip: {
                            trigger: 'axis',
                            backgroundColor: 'var(--white)',
                            borderColor: 'var(--gray-400)',
                            padding: 15,
                            textStyle: {
                                color: '#000'
                            },
                            formatter: function(params) {
                                let html = `<strong>${params[0].axisValueLabel}</strong><br/>`;
                                params.forEach(item => {
                                    html += `
                            <div class='d-flex align-items-center'>
                                <span class="p-1 rounded-pill me-2" style="background-color: ${item.color}"></span>
                                ${item.seriesName}: ${Number(item.value).toLocaleString()}
                            </div>
                        `;
                                });
                                return html;
                            }
                        },
                        xAxis: {
                            type: 'category',
                            boundaryGap: false,
                            data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                            ]
                        },
                        yAxis: {
                            type: 'value'
                        },
                        series: @json($transactionSeries)
                    });

                    // Resize chart on sidebar toggle or window resize
                    var resizeChart = function() {
                        if (chart) {
                            chart.resize();
                        }
                    };

                    // Sidebar toggle support
                    document.querySelectorAll('.sidebar-control').forEach(toggler => {
                        toggler.addEventListener('click', resizeChart);
                    });

                    // Window resize debounce
                    let resizeTimer;
                    window.addEventListener('resize', function() {
                        clearTimeout(resizeTimer);
                        resizeTimer = setTimeout(resizeChart, 200);
                    });
                });
            </script>


            <script>
                var EchartsLinesMultipleLight = function() {
                    var _linesMultipleLightExample = function() {
                        if (typeof echarts == 'undefined') {
                            console.warn('Warning - echarts.min.js is not loaded.');
                            return;
                        }
                        var line_multiple_element = document.getElementById('line_multiple');

                        if (line_multiple_element) {
                            var line_multiple = echarts.init(line_multiple_element, null, {
                                renderer: 'svg'
                            });

                            line_multiple.setOption({
                                color: ['#f17a52', '#03A9F4', '#8E44AD', '#16A085', '#E67E22', '#2C3E50'],
                                textStyle: {
                                    fontFamily: 'var(--body-font-family)',
                                    color: 'var(--body-color)',
                                    fontSize: 14,
                                    lineHeight: 22,
                                    textBorderColor: 'transparent'
                                },

                                animationDuration: 750,

                                grid: {
                                    left: 10,
                                    right: 20,
                                    top: 40,
                                    bottom: 40,
                                    containLabel: true
                                },

                                title: {
                                    left: 'center',
                                    text: 'Total Income by Branchs',
                                    textStyle: {
                                        fontSize: 15,
                                        fontWeight: 500,
                                        color: 'var(--body-color)'
                                    }
                                },

                                tooltip: {
                                    trigger: 'axis',
                                    className: 'shadow-sm rounded',
                                    backgroundColor: 'var(--white)',
                                    borderColor: 'var(--gray-400)',
                                    padding: 15,
                                    textStyle: {
                                        color: '#000'
                                    },
                                    formatter: function(params) {
                                        let tooltipHtml = `<strong>${params[0].axisValueLabel}</strong><br/>`;

                                        params.forEach(item => {
                                            tooltipHtml += `
<div class='d-flex align-items-center'>
    <span class="p-1 rounded-pill me-2" style="background-color: ${item.color}"></span>
    ${item.seriesName}: ${Number(item.value).toLocaleString()}
</div>
`;
                                        });

                                        return tooltipHtml;
                                    }


                                },

                                xAxis: {
                                    type: 'category',
                                    boundaryGap: false,
                                    data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                                        'Nov', 'Dec'
                                    ]
                                },

                                yAxis: {
                                    type: 'value'
                                },

                                series: @json($chartSeries)

                            });
                        }

                        var triggerChartResize = function() {
                            line_multiple_element && line_multiple.resize();
                        };

                        var sidebarToggle = document.querySelectorAll('.sidebar-control');
                        if (sidebarToggle) {
                            sidebarToggle.forEach(function(toggler) {
                                toggler.addEventListener('click', triggerChartResize);
                            });
                        }

                        window.addEventListener('resize', function() {
                            clearTimeout(resizeCharts);
                            resizeCharts = setTimeout(function() {
                                triggerChartResize();
                            }, 200);
                        });
                    };

                    return {
                        init: function() {
                            _linesMultipleLightExample();
                        }
                    }
                }();

                document.addEventListener('DOMContentLoaded', function() {
                    EchartsLinesMultipleLight.init();
                });
            </script>

            <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
            <script>
                $(document).ready(function() {
                    $('#get').click(function() {
                        var year = $("#year").val();

                        $.ajax({
                            url: "{{ route('dashboard') }}",
                            type: "GET",
                            data: {
                                year: year,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {


                            }

                        });
                    });
                });
            </script>

            <script src="{{ asset('assets/js/vendor/visualization/echarts/echarts.min.js') }}"></script>

            {{-- <script src="{{ asset('assets/demo/charts/echarts/lines/lines_multiple.js')}}"></script> --}}
            <!-- /theme JS files -->
        @endsection
