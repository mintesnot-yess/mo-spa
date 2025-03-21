@extends('layouts.app')
@section('title', 'Employee')
@push('css')
    <style>
        .add {
            display: flex;
            justify-content: flex-end;
        }

        .noty.error {
            background-color: #e74c3c !important;
            /* Custom red (danger) color */
            color: white !important;
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
                                <span class="breadcrumb-item active">Employee</span>
                            </div>


                        </div>

                    </div>

                </div>
                <!-- Content area -->
                <div class="content">


                    <!-- Basic datatable -->
                    <div class="card">
                        @can('add_employee')
                            <div class="add">
                                <a href="{{ route('employee.create') }}" class="btn btn-edit"><i class="ph-plus-circle"></i>
                                    Add Employee</a>
                            </div>
                        @endcan
                        <table class="table datatable-basic">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Service</th>
                                    <th>Full Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Sex</th>
                                    <th>DOB</th>
                                    <th>Join Date</th>
                                    <th>Created By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = $employees->firstItem();
                                @endphp
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $employee->service ? $employee->service->title : '' }}</td>
                                        <td>{{ $employee ? $employee->first_name : '' }}
                                            {{ $employee ? $employee->middle_name : '' }}
                                            {{ $employee ? $employee->last_name : '' }}</td>
                                        <td>{{ $employee ? $employee->phone : '' }}</td>
                                        <td>{{ $employee ? $employee->email : '' }}</td>
                                        <td>{{ $employee ? $employee->sex : '' }}</td>
                                        <td>{{ $employee ? $employee->dob : '' }}</td>
                                        <td>{{ $employee ? $employee->join_date : '' }}</td>
                                        <td>{{ $employee->user ? $employee->user->name : '' }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex">
                                                <div class="dropdown">
                                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                                        <i class="ph-list"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('edit_employee')
                                                            <a href="{{ route('employee.edit', $employee->id) }}"
                                                                class="dropdown-item">
                                                                <i class="ph-pencil-line me-2"></i>Edit
                                                            </a>
                                                        @endcan
                                                        @can('edit_employee')
                                                            <a href="#" class="dropdown-item employee-to-user-btn"
                                                                data-bs-toggle="offcanvas" data-bs-target="#toUser"
                                                                data-id="{{ $employee->id }}"
                                                                data-name="{{ $employee->first_name }}"
                                                                data-phone="{{ $employee->phone }}"
                                                                data-email="{{ $employee->email }}">
                                                                <i class="ph-bookmarks-simple me-2"></i>Copy To User
                                                            </a>
                                                        @endcan
                                                        @can('delete_employee')
                                                            <form action="{{ route('employee.delete', $employee->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item"
                                                                    onclick="return confirm('Are you sure you want to delete this employee?');">
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
                        @if ($employees->hasPages())
                            <style>
                                .datatable-footer {
                                    display: none;
                                    border-top: var(--border-width) solid var(--border-color);
                                }
                            </style>
                            {{ $employees->links('pagination::bootstrap-5') }}
                        @endif
                    </div>
                    <!-- /basic datatable -->

                </div>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="toUser">
                    <div class="py-0 offcanvas-header">
                        <h5 class="py-3 offcanvas-title">Add To Staff User</h5>
                        <button type="button" class="border-transparent btn btn-light btn-sm btn-icon rounded-pill"
                            data-bs-dismiss="offcanvas">
                            <i class="ph-x"></i>
                        </button>

                    </div>
                    <form action="{{ route('empToUser.store') }}" method="POST" id="myForm"
                        onsubmit="return validatePassword()">
                        @csrf
                        <div class="p-0 offcanvas-body">
                            <div class="p-3">
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="col-md-12">
                                        <input type="hidden" id="id" name="id" value="">
                                        <input type="hidden" name="role" value="Employee">
                                        <label class="form-label"> Name <span style="color: red">*</span> :</label>
                                        <input type="text" id="name" name="name" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="col-md-12">
                                        <label class="form-label"> Email <span style="color: red">*</span> :</label>
                                        <input type="text" id="email" name="email" class="form-control"
                                            value="">
                                    </div>
                                </div>
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="col-md-12">
                                        <label class="form-label"> Phone <span style="color: red">*</span> :</label>
                                        <input type="text" id="phone" name="phone" class="form-control"
                                            value="">
                                    </div>
                                </div>
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="col-md-12">
                                        <label class="form-label"> Password <span style="color: red">*</span> :</label>
                                        <input type="password" id="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="col-md-12">
                                        <label class="form-label"> Confirm Password <span style="color: red">*</span>
                                            :</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control">
                                        <small id="passwordError" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="mt-3 text-end">
                                    <button type="submit" class="btn btn-primary">Add To User
                                        <i class="ph-paper-plane-tilt ms-2"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
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
                    @if ($errors->any())
                        <script>
                            var message = "{{ implode(', ', $errors->all()) }}";
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: message,
                                timeout: 10000
                            }).show();
                        </script>
                    @endif
                    <script>
                        $(document).ready(function() {
                            $('.employee-to-user-btn').click(function() {
                                let empId = $(this).data('id');
                                let empName = $(this).data('name');
                                let empPhone = $(this).data('phone');
                                let empEmail = $(this).data('email');

                                $('#id').val(empId);
                                $('#name').val(empName).change();
                                $('#phone').val(empPhone).change();
                                $('#email').val(empEmail).change();
                            });
                        });
                    </script>
                    <script>
                        function validatePassword() {
                            let password = document.getElementById("password").value;
                            let confirmPassword = document.getElementById("password_confirmation").value;
                            let errorElement = document.getElementById("passwordError");

                            if (password !== confirmPassword) {
                                errorElement.textContent = "Passwords do not match!";
                                return false;
                            } else {
                                errorElement.textContent = "";
                                return true;
                            }
                        }
                    </script>
                @endpush
            @endsection
