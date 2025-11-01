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
                                <span class="breadcrumb-item active">By Customer</span>
                            </div>


                        </div>

                    </div>

                </div>
                <!-- Content area -->
                <div class="content">


                    <!-- Basic datatable -->
                    {{-- <div class="card"> --}}
                    <div class="mb-4 card-header page-header-light">
                        <div class="row ">
                            <div class="col-md-12">
                                <form method="GET" action="{{ route('report.show') }}"
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
                                            <label for="customer" class="font-weight-bold">Customer</label>
                                            <select name="customer" id="customer" class="form-control select">
                                                <option value="all">All</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        {{ request('customer') == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="service" class="font-weight-bold">Service</label>
                                            <select name="service" class="form-control select">
                                                <option value="all">All</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}"
                                                        {{ request('service') == $service->id ? 'selected' : '' }}>
                                                        {{ $service->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="employee" class="font-weight-bold">Employee</label>
                                            <select name="employee" class="form-control select">
                                                <option value="all">All</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        {{ request('employee') == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->first_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="status" class="font-weight-bold">Status</label>
                                            <select name="status" class="form-control select">
                                                <option value="all">All</option>
                                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                                    Completed</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="customer_type" class="font-weight-bold">Customer Type</label>
                                            <select name="customer_type" id="customer_type" class="form-control select">
                                                <option value="all">All</option>
                                                <option value="Special"
                                                    {{ request('customer_type') == 'Special' ? 'selected' : '' }}>VIP
                                                </option>
                                                <option value="Normal"
                                                    {{ request('customer_type') == 'Normal' ? 'selected' : '' }}>Regular
                                                </option>
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

                        </div>
                    <!--</div>-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <table class="table datatable-basic">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer</th> 
                                            <th>Branch</th> 
                                            <th>Customer Type</th>
                                            <th>Service</th>
                                            <th>Employee</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th>Is New</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 1; @endphp
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>{{ $transaction->client ? $transaction->client->name : '' }}</td>
                                                <td>{{ $transaction->branch ? $transaction->branch->name : '' }}</td>
                                                <td>{{ $transaction->client && $transaction->client->category === 'Special' ? 'VIP' : 'Regular' }}</td>
                                                <td>{{ $transaction->service ? $transaction->service->title : '' }}</td>
                                                <td>{{ $transaction->employee ? $transaction->employee->first_name : '' }}
                                                </td>
                                                <td>{{ $transaction->created_at }}</td>
                                                <td>
                                                    @if ($transaction->status == 0)
                                                        <span class="badge bg-success">Completed</span>
                                                    @else
                                                        <span class="badge bg-yellow text-dark">Pending</span>
                                                    @endif
                                                </td>                                                
                                                <td>{{ $transaction->is_new == 1 ? 'Yes' : 'No' }}</td>
                                            </tr>
                                        @endforeach
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

                    <script>
                        // $(document).ready(function() {
                        //     $('#get').click(function() {
                        //         var start = $("#start").val();
                        //         var end = $("#end").val();
                        //         var type = $("#type").val();

                        //         $.ajax({
                        //             url: "{{ route('report.show') }}",
                        //             type: "GET",
                        //             data: {
                        //                 start: start,
                        //                 end: end,
                        //                 service: service_id,
                        //                 _token: '{{ csrf_token() }}'
                        //             },
                        //             success: function(data) {


                        //             }

                        //         });
                        //     });
                        // });
                    </script>
                @endpush
            @endsection
