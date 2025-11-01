@extends('layouts.app')
@section('title', $hero.'Transactions')
@push('css')
    <style>
        .add {
            display: flex;
            justify-content: flex-end;
        }
        .wide-offcanvas {
            width: 30vw !important;
            /* Adjust width as needed */
            max-width: 90vw;
            /* Optional: Prevent excessive width */
        }
    </style>
@endpush
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
                                <span class="breadcrumb-item active">Transactions</span>
                                <span class="breadcrumb-item active">{{$hero}}</span>
                            </div>


                        </div>

                    </div>

                </div>
                <!-- Content area -->
                <div class="content">


                    <!-- Basic datatable -->
                    <div class="card">
                        <table class="table datatable-basic">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Sex</th>
                                    <th>Phone</th>
                                    <th>Customer Type</th>
                                    <th>Taking Service</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach($transactions as $group)
                                    @php 
                                        $firstTransaction = $group->first(); // Get first transaction in the group
                                        $customer = $firstTransaction->client;
                                        $serviceCount = $group->count(); // Count services
                                    @endphp
                                    <tr>
                                        <td>{{$counter++}}</td>
                                        <td>{{ $customer->name ?? 'N/A' }}</td>
                                        <td>{{ $customer->sex ?? 'N/A' }}</td>
                                        <td>...{{ substr($customer->phone ?? '', -6) }}</td>
                                        <td>{{ $customer->category === 'Special' ? 'VIP' : 'Regular' }}</td>
                                        <td>
                                            <a href="#" onclick="loadServiceDetails({{ $group }})" 
                                               data-bs-toggle="offcanvas" 
                                               data-bs-target="#show-service">
                                                {{ $serviceCount }} Services
                                            </a>
                                        </td>
                                        <td>{{ $firstTransaction->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                       
                    </div>
                    <!-- /basic datatable -->

                </div>
                <!-- /page content -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="show-service">
                    <div class="py-0 offcanvas-header">
                        <h5 class="py-3 offcanvas-title">Service Taking</h5>
                        <button type="button" class="border-transparent btn btn-light btn-sm btn-icon rounded-pill"
                            data-bs-dismiss="offcanvas">
                            <i class="ph-x"></i>
                        </button>
                    </div>
                    <div class="p-0 offcanvas-body">
                        <div class="p-3">
                            <div class="mb-3 d-flex align-items-start">
                                <table class="table datatable" id="service-details">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Employee</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dynamic data will be inserted here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @push('js')
                    <!-- Theme JS files -->
                    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
                    <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>

                    <script src="{{ asset('assets/demo/pages/datatables_basic.js') }}"></script>
                    <!-- /theme JS files -->
                    <!-- Theme JS files -->
                    <script src="{{ asset('assets/js/vendor/notifications/noty.min.js') }}"></script>
                    <script src="{{ asset('assets/demo/pages/extra_noty.js') }}"></script>
                    <!-- /theme JS files -->
                    <script>
                        function loadServiceDetails(transactions) {
                            let serviceTableBody = document.querySelector("#service-details tbody");
                            serviceTableBody.innerHTML = ""; // Clear previous content
                    
                            transactions.forEach(transaction => {
                                let row = `
                                    <tr>
                                        <td>${transaction.service.title ?? 'Unknown'}</td>
                                        <td>${transaction.employee.first_name ?? 'N/A'}</td>
                                    </tr>
                                `;
                                serviceTableBody.innerHTML += row;
                            });
                        }
                    </script>
                @endpush
            @endsection
