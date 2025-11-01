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
                                <span class="breadcrumb-item active">By Service</span>
                            </div>


                        </div>

                    </div>

                </div>
                <!-- Content area -->
                <div class="content">
                    <div class="row ">
                        
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('byService.show') }}" class="p-3 bg-white rounded shadow">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-2">
                                        <label for="start" class="font-weight-bold">From</label>
                                        <input type="date" id="start" name="start" value="{{ request('start', $start) }}" 
                                            class="form-control">
                                    </div>

                                    <div class="col-md-2">
                                        <label for="end" class="font-weight-bold">To</label>
                                        <input type="date" id="end" name="end" value="{{ request('end', $end) }}" 
                                            class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="branch" class="font-weight-bold">Branch</label>
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
                    {{-- </div> --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div id="pie_donut" style="height: 400px;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div id="incomepie_donut" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                    <script src="{{ asset('/assets/js/vendor/visualization/echarts/echarts.min.js') }}"></script>
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
                                    title: {
                                        text: 'Total Transaction By Service',
                                        left: 'center',
                                        textStyle: {
                                            fontSize: 18,
                                            fontWeight: 500,
                                            color: 'var(--body-color)'
                                        },
                                        subtextStyle: {
                                            fontSize: 12,
                                            color: 'rgba(var(--body-color-rgb), 0.5)'
                                        }
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
                                        name: 'Service',
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
                    <script>
                        var serviceRevenueData = @json($serviceRevenueArray);
                        var _scatterIncomePieDonutLightExample = function() {
                            if (typeof echarts == 'undefined') {
                                console.warn('Warning - echarts.min.js is not loaded.');
                                return;
                            }

                            var pie_transaction_donut_element = document.getElementById('incomepie_donut');

                            if (pie_transaction_donut_element) {
                                var pie_transaction_donut = echarts.init(pie_transaction_donut_element, null, {
                                    renderer: 'svg'
                                });

                                // Convert PHP data to format ECharts understands
                                var chartSeriesData = serviceRevenueData.map(item => ({
                                    name: item.name,
                                    value: item.value
                                }));

                                pie_transaction_donut.setOption({
                                    color: [
                                        '#2ec7c9', '#b6a2de', '#5ab1ef', '#ffb980', '#d87a80',
                                        '#8d98b3', '#e5cf0d', '#97b552', '#95706d', '#dc69aa'
                                    ],
                                    textStyle: {
                                        fontFamily: 'var(--body-font-family)',
                                        color: 'var(--body-color)',
                                        fontSize: 14
                                    },
                                    title: {
                                        text: 'Total Income By Service',
                                        left: 'center',
                                        textStyle: {
                                            fontSize: 18,
                                            fontWeight: 500,
                                            color: 'var(--body-color)'
                                        },
                                        subtextStyle: {
                                            fontSize: 12,
                                            color: 'rgba(var(--body-color-rgb), 0.5)'
                                        }
                                    },
                                    tooltip: {
                                        trigger: 'item',
                                        backgroundColor: 'var(--white)',
                                        borderColor: 'var(--gray-400)',
                                        padding: 15,
                                        textStyle: {
                                            color: '#000'
                                        },
                                        formatter: function(params) {
                                            return `${params.name}\n${Number(params.value).toLocaleString()}`;
                                        },
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
                                        name: 'Service',
                                        type: 'pie',
                                        radius: ['50%', '70%'],
                                        center: ['50%', '57.5%'],
                                        itemStyle: {
                                            borderColor: 'var(--card-bg)'
                                        },
                                        label: {
                                            formatter: function(params) {
                                                return `${params.name}\n${Number(params.value).toLocaleString()}`;
                                            },
                                            color: 'var(--body-color)'
                                        },
                                        data: chartSeriesData
                                    }]
                                });
                            }

                            // Resize function
                            var triggerChartResize = function() {
                                pie_transaction_donut_element && pie_transaction_donut.resize();
                            };

                            window.addEventListener('resize', function() {
                                clearTimeout(resizeCharts);
                                resizeCharts = setTimeout(triggerChartResize, 200);
                            });
                        };

                        document.addEventListener('DOMContentLoaded', function() {
                            _scatterIncomePieDonutLightExample();
                        });
                    </script>
                    <!-- Basic datatable -->
                    {{-- <div class="card"> --}}
                    <div class="mb-4 card-header page-header-light">
                        

                        <!--</div>-->
                        {{-- </div> --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <table class="table datatable-basic">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Service Title</th>
                                                <th>Total Customer</th>
                                                <th>Total Price</th>
                                                <th>Total Transaction</th>
                                                <th>Service Category</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $counter = 1; $totalSales = 0; @endphp

                                            @foreach ($serviceSummaries as $summary)
                                                @php $totalSales += $summary['total_price']; @endphp
                                                <tr>
                                                    <td>{{ $counter++ }}</td>
                                                    <td>{{ $summary['service_title'] }}</td>
                                                    <td>{{ $summary['total_customers'] }}</td>
                                                    <td>{{ number_format($summary['total_price']) }}</td>
                                                    <td>{{ number_format($summary['transaction_count']) }}</td>
                                                    <td>{{ $summary['category_title'] }}</td>
                                                </tr>
                                            @endforeach
                                            
                                            <tr>
                                                <td colspan="2"></td>
                                                <td><strong>Total Income</strong></td>
                                                <td><strong>{{ number_format($totalSales) }}</strong></td>
                                                <td colspan="2"></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>

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
