@extends('layouts.app')
@section('title', 'Report')
@section('content')
    @php
    @endphp
    <!-- Page content -->
    <div class="page-content">
        @if (session('success'))
            <div id="noty_success" data-message="{{ session('success') }}"></div>
        @endif

        @if (session('error'))
            <div id="noty_error" data-message="{{ session('error') }}"></div>
        @endif
        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">
                <div class="shadow page-header page-header-light">
                    <div class="page-header-content d-lg-flex border-top">
                        <div class="d-flex">
                            <div class="py-2 breadcrumb">
                                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="ph-house"></i></a>
                                {{-- <a href="#" class="breadcrumb-item">Home</a> --}}
                                <span class="breadcrumb-item active">Report</span>
                                <span class="breadcrumb-item active">By Employee</span>
                            </div>


                        </div>

                    </div>

                </div>
                <!-- Content area -->
                <div class="content">
                    <div class="row ">

                        <div class="col-md-12">
                            <form method="GET" action="{{ route('byEmployee.show') }}" class="p-3 bg-white rounded shadow">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-2">
                                        <label for="chartstart" class="font-weight-bold">From</label>
                                        <input type="date" id="chartstart" name="chartstart" value="{{ request('chartstart', $chartstart) }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-2">
                                        <label for="chartend" class="font-weight-bold">To</label>
                                        <input type="date" id="chartend" name="chartend" value="{{ request('chartend', $chartend) }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="chartemployee" class="font-weight-bold">Employee</label>
                                        <select name="chartemployee" class="form-control select">
                                            <option value="all">All</option>
                                            @foreach ($employees as $emp)
                                                <option value="{{ $emp->id }}"
                                                    {{ request('chartemployee') == $emp->id ? 'selected' : ''}}>
                                                    {{ $emp->first_name }} {{ $emp->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="chartbranch" class="font-weight-bold">Branch</label>
                                        <select name="chartbranch" class="form-control select">
                                            <option value="all">All</option>
                                            @foreach ($branchs as $branch)
                                                <option value="{{ $branch->id }}"
                                                    {{ request('chartbranch') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mt-3 col-md-2 text-md-left mt-md-0">
                                        <button id="get" class="btn btn-primary w-100" type="submit">
                                            <i class="fas fa-search"></i> Update Chart
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Total Income For Top Ten Employees</h5>
                                </div>

                                <div class="card-body">
                                    <div class="chart-container">
                                        <div class="chart has-fixed-height" id="columns_basic"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Total Transaction For Top Ten Employees</h5>
                                </div>

                                <div class="card-body">
                                    <div class="chart-container">
                                        <div class="chart has-fixed-height" id="pie_donut"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script src="{{ asset('/assets/js/vendor/visualization/echarts/echarts.min.js') }}"></script>
                        <script>
                            // document.addEventListener('DOMContentLoaded', function() {

                            var chartData = @json($chartData);
                            var _columnsBasicLightExample = function() {
                                if (typeof echarts == 'undefined') {
                                    console.warn('Warning - echarts.min.js is not loaded.');
                                    return;
                                }

                                var columns_basic_element = document.getElementById('columns_basic');

                                if (columns_basic_element) {
                                    var columns_basic = echarts.init(columns_basic_element, null, {
                                        renderer: 'svg'
                                    });

                                    // Extract names (categories) and values from Laravel data
                                    var categories = chartData.map(item => item.name);
                                    var values = chartData.map(item => item.value);

                                    columns_basic.setOption({
                                        color: ['#0c83ff'],
                                        textStyle: {
                                            fontFamily: 'var(--body-font-family)',
                                            color: 'var(--body-color)',
                                            fontSize: 14
                                        },

                                        animationDuration: 750,
                                        grid: {
                                            left: 0,
                                            right: 45,
                                            top: 35,
                                            bottom: 0,
                                            containLabel: true
                                        },
                                        legend: {
                                            data: ['Count'],
                                            itemHeight: 8,
                                            textStyle: {
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
                                            axisPointer: {
                                                type: 'shadow',
                                                shadowStyle: {
                                                    color: 'rgba(var(--body-color-rgb), 0.025)'
                                                }
                                            }
                                        },
                                        xAxis: [{
                                            type: 'category',
                                            data: categories,
                                            axisLabel: {
                                                color: 'rgba(var(--body-color-rgb), .65)'
                                            }
                                        }],
                                        yAxis: [{
                                            type: 'value',
                                            axisLabel: {
                                                color: 'rgba(var(--body-color-rgb), .65)'
                                            }
                                        }],
                                        series: [{
                                            name: 'Income',
                                            type: 'bar',
                                            data: values,
                                            itemStyle: {
                                                normal: {
                                                    barBorderRadius: [4, 4, 0, 0],
                                                    label: {
                                                        show: true,
                                                        position: 'top',
                                                        fontWeight: 500,
                                                        fontSize: 12,
                                                        color: 'var(--body-color)'
                                                    }
                                                }
                                            }
                                        }]
                                    });
                                }

                                // Resize function
                                var triggerChartResize = function() {
                                    columns_basic_element && columns_basic.resize();
                                };

                                window.addEventListener('resize', function() {
                                    clearTimeout(resizeCharts);
                                    resizeCharts = setTimeout(function() {
                                        triggerChartResize();
                                    }, 200);
                                });
                            };

                            document.addEventListener('DOMContentLoaded', function() {
                                _columnsBasicLightExample();
                            });

                            // });
                        </script>
                        <script>
                            var transactionCountData = @json($clientDataArray);
                            var _scatterPieDonutLightExample = function() {
                                if (typeof echarts == 'undefined') {
                                    console.warn('Warning - echarts.min.js is not loaded.');
                                    return;
                                }

                                var pie_donut_element = document.getElementById('pie_donut');

                                if (pie_donut_element) {
                                    var pie_donut = echarts.init(pie_donut_element, null, {
                                        renderer: 'svg'
                                    });

                                    // Convert PHP data to format ECharts understands
                                    var chartSeriesData = transactionCountData.map(item => ({
                                        name: item.name,
                                        value: item.value
                                    }));

                                    pie_donut.setOption({
                                        color: [
                                            '#2ec7c9', '#b6a2de', '#5ab1ef', '#ffb980', '#d87a80',
                                            '#8d98b3', '#e5cf0d', '#97b552', '#95706d', '#dc69aa'
                                        ],
                                        textStyle: {
                                            fontFamily: 'var(--body-font-family)',
                                            color: 'var(--body-color)',
                                            fontSize: 14
                                        },
                                       
                                        tooltip: {
                                            trigger: 'item',
                                            backgroundColor: 'var(--white)',
                                            borderColor: 'var(--gray-400)',
                                            padding: 15,
                                            textStyle: {
                                                color: '#000'
                                            },
                                            formatter: "{a} <br/>{b}: {c} ({d}%)"
                                        },
                                        legend: {
                                            orient: 'vertical',
                                            top: 'center',
                                            left: 0,
                                            data: chartSeriesData.map(item => item.name),
                                            textStyle: {
                                                color: 'var(--body-color)'
                                            }
                                        },
                                        series: [{
                                            name: 'Transactions',
                                            type: 'pie',
                                            radius: ['50%', '70%'],
                                            center: ['50%', '57.5%'],
                                            itemStyle: {
                                                borderColor: 'var(--card-bg)'
                                            },
                                            label: {
                                                color: 'var(--body-color)'
                                            },
                                            data: chartSeriesData
                                        }]
                                    });
                                }

                                // Resize function
                                var triggerChartResize = function() {
                                    pie_donut_element && pie_donut.resize();
                                };

                                window.addEventListener('resize', function() {
                                    clearTimeout(resizeCharts);
                                    resizeCharts = setTimeout(triggerChartResize, 200);
                                });
                            };

                            document.addEventListener('DOMContentLoaded', function() {
                                _scatterPieDonutLightExample();
                            });
                        </script>
                        <!-- Basic datatable -->
                        {{-- <div class="card"> --}}
                        <div class="mb-4 card-header page-header-light">
                            <div class="row ">
                                <div class="col-md-12">
                                    <form method="get" action="{{ route('byEmployee.show') }}"
                                        class="p-3 bg-white rounded shadow">
                                        @csrf
                                        <div class="row align-items-end">
                                            <div class="col-md-2">
                                                <label for="start" class="font-weight-bold">From</label>
                                                <input type="date" id="start" name="start"
                                                    value="{{ request('start', $start) }}" class="form-control">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="end" class="font-weight-bold">To</label>
                                                <input type="date" id="end" name="end"
                                                    value="{{ request('end', $end) }}" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="end" class="font-weight-bold">Employee</label>
                                                <select name="employee" class="form-control select">
                                                    <option value="all">All</option>
                                                    @foreach ($employees as $emp)
                                                        <option value="{{ $emp->id }}"
                                                            {{ request('employee') == $emp->id ? 'selected' : '' }}>
                                                            {{ $emp->first_name }} {{ $emp->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="branch" class="font-weight-bold">Branch</label>
                                                <select name="branch" class="form-control select">
                                                    <option value="all">All</option>
                                                    @foreach ($branchs as $branch)
                                                        <option value="{{ $branch->id }}"
                                                            {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                                            {{ $branch->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mt-3 col-md-2 text-md-left mt-md-0">
                                                <button id="get" class="btn btn-primary w-100" type="submit">
                                                    <i class="fas fa-search"></i> Get Report
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                {{-- </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <table class="table datatable-basic">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Employee</th>
                                                    <th>Total Customer</th>
                                                    <th>Total Transaction</th>
                                                    <th>Total Income</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $counter = 1;
                                                    $totalIncome = 0;
                                                @endphp

                                                @foreach ($employeeSummaries as $summary)
                                                    @php
                                                        $totalIncome += $summary['total_income'];
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $counter++ }}</td>
                                                        <td>{{ $summary['employee_firstname'] }}
                                                            {{ $summary['employee_lastname'] }}</td>
                                                        <td>{{ number_format($summary['total_customers']) }}</td>
                                                        <td>{{ number_format($summary['transaction_count']) }}</td>
                                                        <td>{{ number_format($summary['total_income']) }}</td>
                                                    </tr>
                                                @endforeach

                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td><strong>Total Income</strong></td>
                                                    <td><strong>{{ number_format($totalIncome) }}</strong></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        </div>

                        <!-- /page content -->
                        @push('js')
                            <!-- Theme JS files -->
                            <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
                            <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>

                            <script src="{{ asset('assets/demo/pages/datatables_basic.js') }}"></script>
                            <!-- /theme JS files -->
                            <!-- Theme JS files -->
                            <script src="{{ asset('assets/js/vendor/notifications/noty.min.js') }}"></script>
                            <script src="{{ asset('assets/demo/pages/extra_noty.js') }}"></script>

                            <script src="{{ asset('assets/js/vendor/forms/tags/tokenfield.min.js') }}"></script>
                            <script src="{{ asset('assets/demo/pages/form_tags.js') }}"></script>

                            <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
                            <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
                        @endpush
                    @endsection
