@extends('layouts.app')
@section('title', 'index')
@push('css')
    <style>
        th,
        .td {
            padding: 10px;
            text-align: left;
            font-size: small;
        }

        .submite {
            display: flex;
            justify-content: end;
            margin-top: 20px;
            /* align-items: flex-end; */
        }

        .form-check-input {
            --form-check-input-border: calc(var(--border-width) * 2) solid var(--gray-900);
        }
    </style>
@endpush
@section('content')

    <!-- Page content -->
    <div class="page-content">



        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Page header -->
                <div class="shadow page-header page-header-light">


                    <div class="page-header-content d-lg-flex border-top">
                        <div class="d-flex">
                            <div class="py-2 breadcrumb">
                                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="ph-house"></i></a>
                                {{-- <a href="#" class="breadcrumb-item">Home</a> --}}
                                <span class="breadcrumb-item active">Role And Permission</span>
                            </div>

                            <a href="#breadcrumb_elements"
                                class="p-0 border-transparent btn btn-light align-self-center collapsed d-lg-none rounded-pill ms-auto"
                                data-bs-toggle="collapse">
                                <i class="m-1 ph-caret-down collapsible-indicator ph-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    <!-- Basic layout -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Assign Permission For Role</h5>
                        </div>
                        {{-- </div> --}}


                        <div class="card-body border-top">
                            <form action="{{ route('assignRolePermission', $role->id) }}" method="POST">
                                @csrf
                                <table class="table datatable-basic">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Permission</th>
                                            <th>
                                                <input type="checkbox" class="form-check-input form-check-input-secondary"
                                                    id="checkAllShow">
                                                <span class="form-check-label">Show</span>
                                            </th>
                                            <th>
                                                <input type="checkbox" class="form-check-input form-check-input-success"
                                                    id="checkAllAdd">
                                                <span class="form-check-label">Add</span>
                                            </th>
                                            <th>
                                                <input type="checkbox" class="form-check-input form-check-input-warning"
                                                    id="checkAllEdit">
                                                <span class="form-check-label">Edit</span>
                                            </th>
                                            <th>
                                                <input type="checkbox" class="form-check-input form-check-input-danger"
                                                    id="checkAllDelete">
                                                <span class="form-check-label">Delete</span>
                                            </th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $counter = 1;
                                        @endphp
                                        @foreach ($permissions as $permission)
                                            @php
                                                $showPermission = $checkPermissions->contains(
                                                    'name',
                                                    'show_' . $permission->name,
                                                );
                                                $addPermission = $checkPermissions->contains(
                                                    'name',
                                                    'add_' . $permission->name,
                                                );
                                                $editPermission = $checkPermissions->contains(
                                                    'name',
                                                    'edit_' . $permission->name,
                                                );
                                                $deletePermission = $checkPermissions->contains(
                                                    'name',
                                                    'delete_' . $permission->name,
                                                );
                                                
                                                $haveshowPermission = $rolePermissions->contains(
                                                    // 'name',
                                                    'show_' . $permission->name,
                                                );
                                                $haveaddPermission = $rolePermissions->contains(
                                                    // 'name',
                                                    'add_' . $permission->name,
                                                );
                                                $haveeditPermission = $rolePermissions->contains(
                                                    // 'name',
                                                    'edit_' . $permission->name,
                                                );
                                                $havedeletePermission = $rolePermissions->contains(
                                                    // 'name',
                                                    'delete_' . $permission->name,
                                                );
                                               
                                            @endphp
                                            <tr>
                                                <th>{{ $counter++ }}</th>
                                                <th>{{ ucwords(str_replace('_', ' ', $permission->name)) }}</th>
                                                <td>
                                                    <label class="mb-2 form-check">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-input-secondary show-checkbox permission-checkbox"
                                                            name="show_{{ $permission->name }}"
                                                            @if ($haveshowPermission) checked @endif
                                                            @if (!$showPermission) disabled @endif>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="mb-2 form-check">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-input-success add-checkbox permission-checkbox"
                                                            name="add_{{ $permission->name }}"
                                                            @if ($haveaddPermission) checked @endif
                                                            @if (!$addPermission) disabled @endif>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="mb-2 form-check">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-input-warning edit-checkbox permission-checkbox"
                                                            name="edit_{{ $permission->name }}"
                                                            @if ($haveeditPermission) checked @endif
                                                            @if (!$editPermission) disabled @endif>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="mb-2 form-check">
                                                        <input type="checkbox"
                                                            class="form-check-input form-check-input-danger delete-checkbox permission-checkbox"
                                                            name="delete_{{ $permission->name }}"
                                                            @if ($havedeletePermission) checked @endif
                                                            @if (!$deletePermission) disabled @endif>
                                                    </label>
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- @can('edit_give_permission') --}}
                                <div class="submite">
                                    <button type="submit" class="btn btn-primary">Assign Permission <i
                                            class="ph-paper-plane-tilt ms-2"></i></button>
                                </div>
                                {{-- @endcan --}}
                            </form>
                        </div>

                    </div>
                    <!-- /basic layout -->

                    @push('js')
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Fetch the first role permissions and check the corresponding checkboxes
                                let rolePermissions = @json($rolePermissions);

                                rolePermissions.forEach(function(permissionName) {
                                    document.querySelectorAll(`input[value="${permissionName}"]`).forEach(function(checkbox) {
                                        checkbox.checked = true;
                                    });
                                });


                                // Handle role change event
                                document.getElementById('roleSelect').addEventListener('change', function() {
                                    let roleId = this.value;

                                    fetch(`/role/${roleId}/permissions`)
                                        .then(response => response.json())
                                        .then(data => {
                                            // Clear all checkboxes
                                            document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
                                                checkbox.checked = false;
                                            });

                                            // Check the checkboxes for the selected role's permissions
                                            data.permissions.forEach(function(permissionName) {
                                                document.querySelectorAll(`input[value="${permissionName}"]`)
                                                    .forEach(function(checkbox) {
                                                        checkbox.checked = true;
                                                    });
                                            });
                                        });
                                });
                            });
                        </script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                function toggleColumnCheckboxes(checkboxClass, isChecked) {
                                    document.querySelectorAll(checkboxClass).forEach(function(checkbox) {
                                        if (!checkbox.disabled) {
                                            checkbox.checked = isChecked;
                                        }
                                    });
                                }

                                // Toggle all "Show" checkboxes
                                document.getElementById('checkAllShow').addEventListener('change', function() {
                                    toggleColumnCheckboxes('.show-checkbox', this.checked);
                                });

                                // Toggle all "Add" checkboxes
                                document.getElementById('checkAllAdd').addEventListener('change', function() {
                                    toggleColumnCheckboxes('.add-checkbox', this.checked);
                                });

                                // Toggle all "Edit" checkboxes
                                document.getElementById('checkAllEdit').addEventListener('change', function() {
                                    toggleColumnCheckboxes('.edit-checkbox', this.checked);
                                });

                                // Toggle all "Delete" checkboxes
                                document.getElementById('checkAllDelete').addEventListener('change', function() {
                                    toggleColumnCheckboxes('.delete-checkbox', this.checked);
                                });
                               

                                // Function to check/uncheck header based on column checkboxes
                                function updateHeaderCheckbox(checkboxClass, headerCheckboxId) {
                                    const checkboxes = document.querySelectorAll(checkboxClass);
                                    const headerCheckbox = document.getElementById(headerCheckboxId);
                                    const enabledCheckboxes = Array.from(checkboxes).filter(checkbox => !checkbox.disabled);
                                    headerCheckbox.checked = enabledCheckboxes.every(checkbox => checkbox.checked);
                                }

                                // Event listeners for each column checkbox to update header
                                document.querySelectorAll('.show-checkbox').forEach(function(checkbox) {
                                    checkbox.addEventListener('change', function() {
                                        updateHeaderCheckbox('.show-checkbox', 'checkAllShow');
                                    });
                                });

                                document.querySelectorAll('.add-checkbox').forEach(function(checkbox) {
                                    checkbox.addEventListener('change', function() {
                                        updateHeaderCheckbox('.add-checkbox', 'checkAllAdd');
                                    });
                                });

                                document.querySelectorAll('.edit-checkbox').forEach(function(checkbox) {
                                    checkbox.addEventListener('change', function() {
                                        updateHeaderCheckbox('.edit-checkbox', 'checkAllEdit');
                                    });
                                });

                                document.querySelectorAll('.delete-checkbox').forEach(function(checkbox) {
                                    checkbox.addEventListener('change', function() {
                                        updateHeaderCheckbox('.delete-checkbox', 'checkAllDelete');
                                    });
                                });
                                

                                // Initialize header checkboxes state on page load
                                updateHeaderCheckbox('.show-checkbox', 'checkAllShow');
                                updateHeaderCheckbox('.add-checkbox', 'checkAllAdd');
                                updateHeaderCheckbox('.edit-checkbox', 'checkAllEdit');
                                updateHeaderCheckbox('.delete-checkbox', 'checkAllDelete');
                            });
                        </script>
                    @endpush

                @endsection
