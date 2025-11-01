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
    <div class="page-content">
        @if (session('success'))
            <div id="noty_success" data-message="{{ session('success') }}"></div>
        @endif

        @if (session('error'))
            <div id="noty_error" data-message="{{ session('error') }}"></div>
        @endif

        <div class="content-wrapper">
            <div class="content-inner">
                <div class="shadow page-header page-header-light">
                    <div class="page-header-content d-lg-flex border-top">
                        <div class="d-flex">
                            <div class="py-2 breadcrumb">
                                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="ph-house"></i></a>
                                <span class="breadcrumb-item active">Customer</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content">
                    <div class="card">
                        <div class="card p-3 mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Status</label>
                                    <select id="filter-status" class="form-control">
                                        <option value="">All</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label>Branch</label>
                                    <select id="filter-branch" class="form-control">
                                        <option value="">All</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 d-flex align-items-end">
                                    <button id="filter-btn" class="btn btn-primary w-100">Apply Filters</button>
                                </div>

                                <div class="col-md-3">
                                    @can('add_customer')
                                        <div class="add">
                                            <a href="{{ route('client.create') }}" class="btn btn-edit">
                                                <i class="ph-plus-circle"></i> Add Customer
                                            </a>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>

                        <table class="table datatable-basic" id="clients-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Sex</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Branch</th>
                                    <th>Created By</th>
                                    <th>Remark</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                {{-- Offcanvas for status --}}
                <div class="offcanvas offcanvas-end" tabindex="-1" id="statuses">
                    <div class="py-0 offcanvas-header">
                        <h5 class="py-3 offcanvas-title">Customer Status</h5>
                        <button type="button" class="border-transparent btn btn-light btn-sm btn-icon rounded-pill" data-bs-dismiss="offcanvas">
                            <i class="ph-x"></i>
                        </button>
                    </div>
                    <div class="p-0 offcanvas-body">
                        <div class="p-3">
                            <form action="{{ route('client.updateStatus') }}" method="POST">
                                @csrf
                                <input type="hidden" id="id-select" name="id" value="">

                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span>:</label>
                                    <select name="status" id="status-select" class="form-control select">
                                        <option value="" disabled selected>Select status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Assign Employee <span class="text-danger">*</span>:</label>
                                    <select name="employee_id[]" id="employee-select" class="form-control multiselect" multiple>
                                    <!--<option value="" disabled>Select employee</option>-->
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}" data-service-group="{{ $employee->service_group }}">
                                                {{ $employee->first_name . ' ' . ($employee->middle_name ?? $employee->last_name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        Update Status <i class="ph-paper-plane-tilt ms-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->

    @push('js')
        <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
        <!-- <script src="{{ asset('assets/demo/pages/datatables_basic.js') }}"></script> -->

        <script src="{{ asset('assets/js/vendor/notifications/noty.min.js') }}"></script>
        <!-- <script src="{{ asset('assets/demo/pages/extra_noty.js') }}"></script> -->

        <script src="{{ asset('assets/js/vendor/forms/selects/bootstrap_multiselect.js') }}"></script>
        <!-- <script src="{{ asset('assets/demo/pages/form_multiselect.js') }}"></script> -->

        <script>

            $(document).ready(function () {

                // ===============================
                // ✅ DATATABLE INITIALIZATION
                // ===============================
                $(function () {
                    let table = $('#clients-table').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: {
                            url: "{{ route('client.data') }}",
                            data: function (d) {
                                d.status = $('#filter-status').val();
                                d.branch_id = $('#filter-branch').val();
                                d.employee_id = $('#filter-employee').val();
                            }
                        },
                        columns: [
                            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                            { data: 'image', name: 'image', orderable: false, searchable: false },
                            { data: 'code', name: 'code' },
                            { data: 'name', name: 'name' },
                            { data: 'phone', name: 'phone' },
                            { data: 'sex', name: 'sex' },
                            { data: 'category', 
                                name: 'category',
                                render: function (data, type, row) {
                                    if (data === 'Normal') {
                                        return 'Regular';
                                    } else {
                                        return 'VIP';
                                    }
                                }
                            },
                            // { data: 'category', name: 'category' },
                            { data: 'status', name: 'status', orderable: false, searchable: false },
                            { data: 'branch.name', name: 'branch.name' },
                            { data: 'user.name', name: 'user.name' },
                            { data: 'remark', name: 'remark' },
                            { data: 'action', name: 'action', orderable: false, searchable: false }
                        ]
                    });

                    // 🔹 Apply filters
                    $('#filter-btn').on('click', function () {
                        table.ajax.reload();
                    });
                });

                // =====================================
                // ✅ MULTISELECT INITIALIZATION
                // =====================================
                $('#employee-select').multiselect({
                    includeSelectAllOption: false,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering: true,
                    buttonWidth: '100%',
                    nonSelectedText: 'Select employee',
                    onChange: function(option, checked) {
                        handleEmployeeGroupLogic();
                    }
                });

                // =====================================
                // ✅ FUNCTION: Handle Employee Group Logic
                // =====================================
                function handleEmployeeGroupLogic() {
                    const selectedOptions = $('#employee-select option:selected');
                    const selectedGroups = selectedOptions.map(function() {
                        return $(this).data('service-group');
                    }).get();

                    $('#employee-select option').each(function() {
                        const group = $(this).data('service-group');
                        const isSelected = $(this).is(':selected');

                        if (!isSelected && selectedGroups.includes(group)) {
                            $(this).prop('disabled', true);
                        } else {
                            $(this).prop('disabled', false);
                        }
                    });

                    $('#employee-select').multiselect('rebuild');
                }

                // =====================================
                // ✅ CLIENT STATUS (On Offcanvas Open)
                // =====================================
                $(document).on('click', '.client-status-btn', function () {
                    let clientId = $(this).data('id');
                    let clientStatus = $(this).data('status');
                    let clientEmployee = $(this).data('employee');
                    let employeeIds = [];

                    try {
                        employeeIds = Array.isArray(clientEmployee)
                            ? clientEmployee
                            : (typeof clientEmployee === 'string' ? JSON.parse(clientEmployee) : [clientEmployee]);
                    } catch (e) {
                        console.error("Failed to parse employee data", clientEmployee);
                    }

                    // Set values
                    $('#id-select').val(clientId);
                    $('#status-select').val(clientStatus).change();

                    // Reset and set employee selections
                    $('#employee-select').multiselect('deselectAll', false).multiselect('refresh');
                    $('#employee-select').multiselect('select', employeeIds);

                    // ✅ Trigger group disabling logic manually
                    handleEmployeeGroupLogic();
                });

        });
        </script>
    @endpush
@endsection
