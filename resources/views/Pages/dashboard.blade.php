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
                                <i class="ph ph-users-three ph-2x text-danger me-3"></i>
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
                                <i class="ph ph-stack ph-2x text-warning me-3"></i>
                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($service) }}</h4>
                                    <span class="text-muted">Services</span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph-text-indent ph-2x text-primary me-3"></i>
                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($totalCategories) }}</h4>
                                    <span class="text-muted"> Total Categories </span>
                                </div>

                            </div>
                        </div>
                    </div>                   
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph-user-gear ph-2x me-3"></i>

                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($user) }}</h4>
                                    <span class="text-muted"> System User </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph-currency-dollar-simple ph-2x me-3"></i>

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
                                <i class="ph-shield-warning ph-2x me-3"></i>

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
                                <i class="ph-shield-check ph-2x me-3"></i>

                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($complatedTransaction) }}</h4>
                                    <span class="text-muted"> Complated Transactions </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph-trend-up ph-2x me-3"></i>

                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($yearlySumPayment, 2) }}</h4>
                                    <span class="text-muted"> This Year Income </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph-currency-circle-dollar ph-2x text-danger me-3"></i>
                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($yearlySumExpense, 2) }}</h4>
                                    <span class="text-muted"> This Year Expense </span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph-wallet ph-2x text-primary me-3"></i>
                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($monthlySumPayment, 2) }}</h4>
                                    <span class="text-muted">This Month Income</span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card card-body">
                            <div class="d-flex align-items-center">
                                <i class="ph-receipt ph-2x text-danger me-3"></i>
                                <div class="flex-fill text-end">
                                    <h4 class="mb-0">{{ number_format($monthlySumExpense, 2) }}</h4>
                                    <span class="text-muted">This Month Expense</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- Quick stats boxes -->

                <!-- /main charts -->




                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-9">

                                </div>
                                {{-- <div class="col-md-3">
                                    <form method="GET" action="{{ route('dashboard') }}">
                                        @csrf
                                        <div class="row align-items-end">
                                            <div class="col-md-6">
                                                <label for="year" class="font-weight-bold"></label>
                                                <input type="number" id="year" name="year"
                                                    value="{{ $yearr }}" class="form-control" min="2000"
                                                    max="2099" step="1">
                                            </div>

                                            <div class="mt-3 col-md-4 text-md-left mt-md-0">
                                                <button id="getYearReport" class="btn btn-primary w-100" type="submit">
                                                    <i class="fas fa-search"></i> Get
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div> --}}
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

            </div>
            <!-- /content area -->
            <!-- Theme JS files -->

            <script src="{{ asset('assets/js/vendor/visualization/echarts/echarts.min.js') }}"></script>
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
                                color: ['#f17a52', '#03A9F4'],
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
                                    text: 'Income Vs Expense',
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
                                    formatter: function(a) {
                                        return (
                                            a[0]['axisValueLabel'] +
                                            "<div class='d-flex align-items-center'>" +
                                            '<span class="p-1 rounded-pill me-2" style="background-color: ' +
                                            a[0]['color'] + '"></span>' +
                                            a[0]['seriesName'] + ': ' + Number(a[0]['value'])
                                            .toLocaleString() + // Ensure number format
                                            "</div>" +
                                            "<div class='d-flex align-items-center'>" +
                                            '<span class="p-1 rounded-pill me-2" style="background-color: ' +
                                            a[1]['color'] + '"></span>' +
                                            a[1]['seriesName'] + ': ' + Number(a[1]['value'])
                                            .toLocaleString() + // Ensure number format
                                            "</div>"
                                        );
                                    }

                                },

                                xAxis: {
                                    type: 'category',
                                    boundaryGap: false,
                                    data: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar',
                                        'Apr', 'May'
                                    ]
                                },

                                yAxis: {
                                    type: 'value'
                                },

                                series: [{
                                        name: 'Income',
                                        type: 'line',
                                        smooth: true,
                                        symbol: 'circle',
                                        symbolSize: 8,
                                        data: @json($subscriberData)
                                    },
                                    {
                                        name: 'Expense',
                                        type: 'line',
                                        smooth: true,
                                        symbol: 'circle',
                                        symbolSize: 8,
                                        data: @json($contactData)
                                    }
                                ]
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


            {{-- <script>
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
                                color: ['#03A9F4'], // Only one color since we have one dataset
            
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
                                    text: 'Payment Collection',
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
                                    formatter: function(a) {
                                        return (
                                            a[0]['axisValueLabel'] +
                                            "<div class='d-flex align-items-center'>" +
                                            '<span class="p-1 rounded-pill me-2" style="background-color: ' +
                                            a[0]['color'] + '"></span>' +
                                            a[0]['seriesName'] + ': ' + a[0]['value'] +
                                            "</div>"
                                        );
                                    }
                                },
            
                                xAxis: {
                                    type: 'category',
                                    boundaryGap: false,
                                    data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                                },
            
                                yAxis: {
                                    type: 'value'
                                },
            
                                series: [
                                    {
                                        name: 'Collected Payment',
                                        type: 'line',
                                        smooth: true,
                                        symbol: 'circle',
                                        symbolSize: 8,
                                        data: @json($subscriberData) // Only using Payment Collection data
                                    }
                                ]
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
            </script> --}}

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
