@extends('layouts.app')
@section('title', 'Attendance Records')

@section('content')
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
                            <span class="breadcrumb-item active">Attendance Records</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content area -->
            <div class="content">
                <!-- Basic datatable -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Attendance Records</h5>

                        <div class="add d-flex gap-2"> <a href="#" class="btn btn-primary btn-sm"
                                data-bs-toggle="offcanvas" data-bs-target="#import-attendance">
                                <i class="ph-file-arrow-down me-2"></i>Import Excel
                            </a>
                            <a href="{{ asset('templates/attendance_template.xlsx') }}"
                                class="btn btn-outline-secondary btn-sm" download>
                                <i class="ph-file-text me-2"></i>Download Template
                            </a>

                        </div>
                    </div>

                    <div class="card-body ">
                        <table class="table datatable-basic">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Person ID</th>
                                    <th>Date</th>
                                    <th>Check-In</th>
                                    <th>Check-out</th>
                                    <th>Late</th>
                                    <th>Early Leave</th>
                                    <th>Attended</th>
                                    <th>Absent</th>
                                    <th>Worked</th>
                                    <th>Break</th>
                                    <th>Leave Type</th>
                                    <th>Leave</th>
                                    <th>OT1</th>
                                    <th>OT2</th>
                                    <th>OT3</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 1; @endphp
                                @foreach ($attendances as $attendance)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>{{ $attendance->person_id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d-m-y') }}</td>
                                    <td>{{ $attendance->check_in }}</td>
                                    <td>{{ $attendance->check_out }}</td>
                                    <td>{{ $attendance->late }}</td>
                                    <td>{{ $attendance->early_leave }}</td>
                                    <td>{{ $attendance->attended }}</td>
                                    <td>{{ $attendance->absent }}</td>
                                    <td>{{ $attendance->worked }}</td>
                                    <td>{{ $attendance->break }}</td>
                                    <td>{{ $attendance->leave_type }}</td>
                                    <td>{{ $attendance->leave }}</td>
                                    <td>{{ $attendance->ot1 }}</td>
                                    <td>{{ $attendance->ot2 }}</td>
                                    <td>{{ $attendance->ot3 }}</td>
                                </tr>
                                @endforeach

                                @if($attendances->count() == 0)
                                <tr>
                                    <td colspan="16" class="text-center">No attendance records found.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <!-- Import Attendance Offcanvas -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="import-attendance">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Import Attendance Records</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <form action="{{ route('attendance.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select Excel File</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                            <div class="form-text">
                                Supported formats: .xlsx, .xls, .csv
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ph-file-arrow-down me-2"></i>Import Records
                            </button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>


            @push('js')
            <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
            <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>

            <script>
                $(document).ready(function() {
        $('.datatable-basic').DataTable({
            scrollX: true,
            pageLength: 25,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }
        });

      
    });
            </script>
            @endpush
            @endsection