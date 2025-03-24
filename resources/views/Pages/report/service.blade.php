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


                    <!-- Basic datatable -->
                    {{-- <div class="card"> --}}
                    <div class="mb-4 card-header page-header-light">
                        <div class="row ">
                            <div class="col-md-8">
                                <form method="GET" action="{{ route('byService.show') }}"
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
                                            <label for="end" class="font-weight-bold">Service</label>
                                            <select name="client" id="client" class="form-control select">
                                                <option value="all">All</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}">{{ $service->first_name }}</option>
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
                                            <th>Service Category</th>
                                            <th>Service Code</th>
                                            <th>Service Title</th>
                                            <th>Total Customer</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 1; $totalSales = 0; @endphp
                                        @foreach ($transactions as $transaction)
                                        @php
                                            $customerCount = $transactions->pluck('client_id')->unique()->count();
                                            $totalPrice = $transactions->sum('price');
                                            $totalSales += $totalPrice;
                                        @endphp
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>{{ $transaction->service->category }}</td>
                                                <td>{{ $transaction->service->code }}</td>
                                                <td>{{ $transaction->service->title }}</td>
                                                <td>{{ $customerCount }}</td>
                                                <td>{{ $totalPrice }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total Sales</td>
                                            <td>{{ $totalSales }}</td>
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

                    <script>
                        $(document).ready(function() {
                            $('#get').click(function() {
                                var start = $("#start").val();
                                var end = $("#end").val();
                                var type = $("#type").val();

                                $.ajax({
                                    url: "{{ route('byService.show') }}",
                                    type: "GET",
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
