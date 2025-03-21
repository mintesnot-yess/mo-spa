@extends('layouts.app')
@section('title', $hero.'Transactions')
@push('css')
    <style>
        .add {
            display: flex;
            justify-content: flex-end;
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
                        {{-- @can('add_staff_user')
                            <div class="add">
                                <a href="{{ route('staff.create') }}" class="btn btn-edit"><i class="ph-plus-circle"></i> Add System User</a>
                            </div>
                        @endcan --}}
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
                                    $counter = $transactions->firstItem();
                                @endphp
                                @foreach ($transactions as $transactions)                              
                                    
                                    <tr>
                                        
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $transactions->client->name }}</td>
                                
                                        <td>{{ $transactions->sesx }}</td>
                                        <td>{{ $transactions->phone }}</td>
                                        <td>{{ $transactions->clinet->type ?? '' }} </td>
                                        <td>{{ $transactions->service->title ?? '' }} </td>
                                        <td>{{ \Carbon\Carbon::parse($transactions->created_at)->format('M-d-Y') }}</td>
                                        
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @if ($transactions->hasPages())
                            <style>
                                .datatable-footer {
                                    display: none;
                                    border-top: var(--border-width) solid var(--border-color);
                                }
                            </style>
                            {{ $transactions->links('pagination::bootstrap-5') }}
                        @endif
                    </div>
                    <!-- /basic datatable -->

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
                    <!-- /theme JS files -->
                    
                @endpush
            @endsection
