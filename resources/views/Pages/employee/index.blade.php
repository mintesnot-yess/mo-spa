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
                                    <th>Code</th>
                                    <th>Service</th>
                                    <th>Branch</th>
                                    <th>Full Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Sex</th>
                                    <th>Status</th>
                                    <th>DOB</th>
                                    <th>Join Date</th>
                                    <th>Created By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($employees as $employee)
                                @php
                                    $hasUser = App\Models\User::where('emp_id',$employee->id)->first();
                                @endphp
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $employee ? $employee->code : '' }}</td>
                                        <td>{{ $employee ? $employee->service_group : '' }}</td>
                                        <td>{{ $employee->branch ? $employee->branch->name : '' }}</td>
                                        <td>{{ $employee ? $employee->first_name : '' }}
                                            {{ $employee ? $employee->middle_name : '' }}
                                            {{ $employee ? $employee->last_name : '' }}</td>
                                        <td>{{ $employee ? $employee->phone : '' }}</td>
                                        <td>{{ $employee ? $employee->email : '' }}</td>
                                        <td>{{ $employee ? $employee->sex : '' }}</td>
                                        <td>
                                            <label class="form-switch form-check-reverse">
                                                <input type="checkbox" class="form-check-input service-status-toggle"
                                                    data-id="{{ $employee->id }}"
                                                    {{ $employee->status == 1 ? 'checked' : '' }}>
                                            </label>
                                        </td>
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
                                                        @if(!$hasUser)
                                                            <a href="#" class="dropdown-item employee-to-user-btn"
                                                                data-bs-toggle="offcanvas" data-bs-target="#toUser"
                                                                data-id="{{ $employee->id }}"
                                                                data-name="{{ $employee->first_name . ' ' . $employee->middle_name }}"
                                                                data-phone="{{ $employee->phone }}"
                                                                data-email="{{ $employee->email }}">
                                                                <i class="ph-bookmarks-simple me-2"></i>Copy To User
                                                            </a>
                                                        @endif
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
                        <div class="p-0 offcanvas-body">
                            <div class="p-3">
                    <form action="{{ route('empToUser.store') }}" method="POST" id="myForm"
                        onsubmit="return validateForm()" enctype="multipart/form-data">
                        @csrf
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="col-md-12">
                                        <input type="hidden" id="emp_id" name="emp_id" value="">
                                        <label class="form-label"> Name <span style="color: red">*</span> :</label>
                                        <input type="text" id="name" name="name" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="col-md-12">
                                        <label class="form-label"> Email <span style="color: red">*</span> :</label>
                                        <input type="text" id="email" name="email" class="form-control"
                                            value="" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="col-md-12">
                                        <label class="form-label"> Phone <span style="color: red">*</span> :</label>
                                        <input type="text" id="phone" name="phone" class="form-control"
                                            value="" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="col-md-12">
                                        <label class="form-label"> Role <span style="color: red">*</span> :</label>
                                        <select name="role" id="role" class="form-control select">
                                                <option value="">Select a role...</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ old('role') == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small id="roleError" class="text-danger"></small>
                                    </div>
                                </div>
                                 <div class="mb-3 d-flex align-items-start">
                                    <div class="col-md-12">
                                        <label class="form-label"> Image :</label>
                                        <input type="file" id="image" name="image" class="form-control">
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
                    </form>
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
                    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
                    <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
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

                                $('#emp_id').val(empId);
                                $('#name').val(empName).change();
                                $('#phone').val(empPhone).change();
                                $('#email').val(empEmail).change();
                            });
                        });
                    </script>
                    <script>
    
    function validateForm() {
        let password = document.getElementById("password").value;
        let confirmPassword = document.getElementById("password_confirmation").value;
        let role = document.getElementById("role").value;
        let passwordErrorElement = document.getElementById("passwordError");
        let roleErrorElement = document.getElementById("roleError");

        // Clear previous errors
        passwordErrorElement.textContent = "";
        roleErrorElement.textContent = "";

        // Validate Role field (make sure it is selected)
        if (role === "") {
            roleErrorElement.textContent = "Role is required!";
            return false;  // Stop form submission
        }

        // Validate password and confirm password match
        if (password === "" || confirmPassword === "") {
            passwordErrorElement.textContent = "Password fields cannot be empty!";
            return false;  // Stop form submission
        }

        if (password !== confirmPassword) {
            passwordErrorElement.textContent = "Passwords do not match!";
            return false;  // Stop form submission
        }

        return true; // All validations passed, form can be submitted
    }
</script>

</script>

                    <script>
                        $(document).ready(function() {
                            $('.service-status-toggle').change(function() {
                                let serviceId = $(this).data('id');
                                let newStatus = $(this).is(':checked') ? 1 : 0;
                    
                                $.ajax({
                                    url: "{{ route('employee.updateStatus') }}",
                                    type: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        id: serviceId,
                                        status: newStatus
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            alert('Employee status updated successfully!');
                                        } else {
                                            alert('Failed to update employee status.');
                                        }
                                    },
                                    error: function() {
                                        alert('Something went wrong!');
                                    }
                                });
                            });
                        });
                    </script>
                @endpush
            @endsection
