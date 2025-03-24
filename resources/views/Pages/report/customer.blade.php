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
                            <div class="col-md-8">
                                <form method="POST" action="{{ route('byService.show') }}"
                                    class="p-3 bg-white rounded shadow">
                                    @csrf
                                    <div class="row align-items-end">
                                        <div class="col-md-3">
                                            <label for="start" class="font-weight-bold">From</label>
                                            <input type="month" id="start" name="start" value="{{ $start }}"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-3">
                                            <label for="end" class="font-weight-bold">To</label>
                                            <input type="month" id="end" name="end" value="{{ $end }}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="end" class="font-weight-bold">Customer</label>
                                            <select name="customer" id="customer" class="form-control select">
                                                <option value="all">All</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-3 col-md-3 text-md-left mt-md-0">
                                            <button id="get" class="btn btn-primary w-100" type="submit">
                                                <i class="fas fa-search"></i> Get Report
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <table class="table datatable-basic">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer</th>
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
                                                <td>{{ $transaction->clinet->name }}</td>
                                                <td>{{ $transaction->clinet->category }}</td>
                                                <td>{{ $transaction->service->title }}</td>
                                                <td>{{ $transaction->employee->first_name }}</td>
                                                <td>{{ $transaction->crated_at }}</td>
                                                <td>{{ $transaction->status }}</td>
                                                <td>{{ $transaction->is_new }}</td>
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
                        $(document).ready(function() {
                            $('#get').click(function() {
                                var start = $("#start").val();
                                var end = $("#end").val();
                                var type = $("#type").val();

                                $.ajax({
                                    url: "{{ route('byService.show') }}",
                                    type: "POST",
                                    data: {
                                        start: start,
                                        end: end,
                                        service: service_id,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(data) {


                                    }

                                });
                            });
                        });
                    </script>
                @endpush
            @endsection
