@extends('layouts.app')
@section('title', 'Customer')
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
                                {{-- <a href="#" class="breadcrumb-item">Home</a> --}}
                                <span class="breadcrumb-item active">Customer</span>
                            </div>


                        </div>

                    </div>

                </div>
                <!-- Content area -->
                <div class="content">


                    <!-- Basic datatable -->
                    <div class="card">
                        @can('add_customer')
                            <div class="add">
                                <a href="{{ route('client.create') }}" class="btn btn-edit"><i class="ph-plus-circle"></i>
                                    Add Customer</a>
                            </div>
                        @endcan
                        <table class="table datatable-basic">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Sex</th>
                                    <th>Type</th>
                                    <th>Staus</th>
                                    <th>Created By</th>
                                    <th>Assigned To</th>
                                    <th>Remark</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = $clients->firstItem();
                                @endphp
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $client ? $client->code : '' }}</td>
                                        <td>{{ $client ? $client->name : '' }}</td>
                                        <td>{{ $client ? $client->phone : '' }}</td>
                                        <td>{{ $client ? $client->sex : '' }}</td>
                                        <td>{{ $client ? $client->category : '' }}</td>
                                        <td>
                                            <a href="#"
                                                class="navbar-nav-link navbar-nav-link-icon rounded-pill client-status-btn"
                                                data-bs-toggle="offcanvas" data-bs-target="#notifications"
                                                data-id="{{ $client->id }}" data-status="{{ $client->status }}"
                                                data-employee="{{ $client->employee_id }}">
                                                <span
                                                    class="badge {{ $client->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $client->status == 1 ? 'Active' : 'Inactive' }}
                                                </span>
                                            </a>
                                        </td>


                                        <td>{{ $client->user ? $client->user->name : '' }}</td>
                                        <td>
                                            {{ $client->employee ? $client->employee->first_name . ' ' . ($client->employee->middle_name ?? $client->employee->last_name) : '' }}
                                        </td>
                                        <td>{{ $client ? Illuminate\Support\Str::limit($client->remark, 20, '...') : '' }}
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex">
                                                <div class="dropdown">
                                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                                        <i class="ph-list"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('edit_customer')
                                                            <a href="{{ route('client.edit', $client->id) }}"
                                                                class="dropdown-item">
                                                                <i class="ph-pencil-line me-2"></i>Edit
                                                            </a>
                                                        @endcan
                                                        @can('delete_customer')
                                                            <form action="{{ route('client.delete', $client->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item"
                                                                    onclick="return confirm('Are you sure you want to delete this Client?');">
                                                                    <i class="ph-trash me-2"></i>Delete
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
                        @if ($clients->hasPages())
                            <style>
                                .datatable-footer {
                                    display: none;
                                    border-top: var(--border-width) solid var(--border-color);
                                }
                            </style>
                            {{ $clients->links('pagination::bootstrap-5') }}
                        @endif
                    </div>
                    <!-- /basic datatable -->

                </div>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="notifications">
                    <div class="py-0 offcanvas-header">
                        <h5 class="py-3 offcanvas-title">Customer Status</h5>
                        <button type="button" class="border-transparent btn btn-light btn-sm btn-icon rounded-pill"
                            data-bs-dismiss="offcanvas">
                            <i class="ph-x"></i>
                        </button>

                    </div>
                    <form action="{{route('client.updateStatus')}}" method="POST">
                        @csrf
                        <div class="p-0 offcanvas-body">
                            <div class="p-3">
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="col-md-12">
                                        <input type="hidden" id="id-select" name="id" value="">
                                        <label class="form-label"> Status <span style="color: red">*</span> :</label>
                                        <select name="status" id="status-select" class="form-control select">
                                            <option value="" disabled selected>Select status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="col-md-12">
                                        <label class="form-label"> Assign Employee: <span style="color: red">*</span>
                                            :</label>
                                        <select name="employee_id" id="employee-select" class="form-control select">
                                            <option value="" disabled selected>Select employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">
                                                    {{ $employee ? $employee->first_name . ' ' . ($employee->middle_name ?? $employee->last_name) : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-3 text-end">
                                    <button type="submit" class="btn btn-primary">Update Status
                                        <i class="ph-paper-plane-tilt ms-2"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>

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
                        <script>
                            $(document).ready(function() {
                                $('.client-status-btn').click(function() {
                                    let clientId = $(this).data('id');
                                    let clientStatus = $(this).data('status');
                                    let clientEmployee = $(this).data('employee');
                                    
                                    $('#id-select').val(clientId);
                                    $('#status-select').val(clientStatus).change();
                                    $('#employee-select').val(clientEmployee).change();
                                });
                            });
                        </script>
                    @endpush
                @endsection
