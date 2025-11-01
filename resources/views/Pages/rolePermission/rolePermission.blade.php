@extends('layouts.app')
@section('title', 'Assign Permission')
@push('css')
    <style>
        .add {
            display: flex;
            justify-content: flex-end;
        }
    </style>
    <!-- Global stylesheets -->
    {{-- <link href="{{ asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css"> --}}
    <!-- /global stylesheets -->
@endpush
@section('content')
    @php
        // dd(Auth::user()->roles);
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
                                <span class="breadcrumb-item active">Role And Permissions</span>
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
                                    <th>Role Name</th>
                                    @can('show_give_permission')
                                        <th>Permission</th>
                                    @endcan
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $role->name }}</td>
                                        
                                        @can('show_give_permission')
                                            <td><a href="{{ route('assignPermission', $role->id) }}"
                                                    class="btn btn-outline-info btn-labeled btn-labeled-start {{ $role->name === 'Admin' ? 'disabled' : '' }}">
                                                    <span class="text-white btn-labeled-icon bg-info">
                                                        <i class="ph-address-book"></i>
                                                    </span>Assign
                                                </a></td>
                                        @endcan
                                        <td class="text-center">
                                            <div class="d-inline-flex">
                                                <div class="dropdown">
                                                    <a href="#" class="text-body {{ $role->name === 'Admin' || $role->name === 'Reception' || $role->name === 'Staff' || $role->name === 'Supervisor' || $role->name === 'Item Coordinator' ? 'disabled' : '' }}" data-bs-toggle="dropdown">
                                                        <i class="ph-list"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('edit_role')
                                                            <a href="{{ route('role.edit', $role->id) }}"
                                                                class="dropdown-item">
                                                                <i class="ph-pencil-line me-2"></i>
                                                                Edit
                                                            </a>
                                                        @endcan
                                                        @can('delete_role')
                                                            <form action="{{ route('role.delete', $role->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item"
                                                                    onclick="return confirm('Are you sure you want to delete this role?');">
                                                                    <i class="ph-trash me-2"></i>
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        
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
