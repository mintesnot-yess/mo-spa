@extends('layouts.app')
@section('title', 'System Users')
@push('css')
    <style>
        .add {
            display: flex;
            justify-content: flex-end;
        }
    </style>
@endpush
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
                                {{-- <a href="#" class="breadcrumb-item">Home</a> --}}
                                <span class="breadcrumb-item active">System User</span>
                            </div>


                        </div>

                    </div>

                </div>
                <!-- Content area -->
                <div class="content">


                    <!-- Basic datatable -->
                    <div class="card">
                        @can('add_staff_user')
                            <div class="add">
                                <a href="{{ route('staff.create') }}" class="btn btn-edit"><i class="ph-plus-circle"></i> Add System User</a>
                            </div>
                        @endcan
                        <table class="table datatable-basic">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>User Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Role</th>
                                    <th>Registerd In</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($users as $user)                              
                                    
                                    <tr>
                                        
                                        <td>{{ $counter++ }}</td>
                                        <td><img src="{{asset('file/' . $user->image)}}" alt="" style="width: 70px; height: 50px;"></td>
                                        <td>{{ $user->name }}</td>
                                
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <label class="form-switch form-check-reverse">
                                                <input type="checkbox" class="form-check-input service-status-toggle"
                                                    data-id="{{ $user->id }}"
                                                    {{ $user->status == 1 ? 'checked' : '' }}>
                                            </label>
                                        </td>
                                        <td>
                                            {{ optional($user->roles->first())->name ?? 'No Role Assigned' }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($user->created_at)->format('M-d-Y') }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex">
                                                <div class="dropdown">
                                                    <a href="#" class="text-body  {{ $user->name === 'Admin' ? 'disabled' : '' }}" data-bs-toggle="dropdown">
                                                        <i class="ph-list"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('edit_staff_user')
                                                            <a href="{{ route('staff.edit', $user->id) }}"
                                                                class="dropdown-item">
                                                                <i class="ph-pencil-line me-2"></i>
                                                                Edit </a>
                                                        @endcan
                                                        @can('delete_staff_user')
                                                            <form action="{{ route('staff.delete', $user->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item"
                                                                    onclick="return confirm('Are you sure you want to delete this User?');">
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
                    
                    <script>
                        $(document).ready(function() {
                            // Attach event using delegation
                            $(document).on('change', '.service-status-toggle', function() {
                                let serviceId = $(this).data('id');
                                let newStatus = $(this).is(':checked') ? 1 : 0;
                    
                                
                                $.ajax({
                                    url: "{{ route('user.updateStatus') }}",
                                    type: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        id: serviceId,
                                        status: newStatus
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            alert('User status updated successfully!');
                                        } else {
                                            alert('Failed to update user status.');
                                        }
                                    },
                                    error: function() {
                                        alert('Something went wrong!');
                                    }
                                });
                            });
                        });
                    </script>

                    <!--<script>-->
                    <!--    $(document).ready(function() {-->
                    <!--        $('.service-status-toggle').change(function() {-->
                                
                                
                    <!--        alert("newStatus");-->
                                
                    <!--            let serviceId = $(this).data('id');-->
                    <!--            let newStatus = $(this).is(':checked') ? 1 : 0;-->
                                
                    <!--            alert(newStatus);-->
                    <!--            $.ajax({-->
                    <!--                url: "{{ route('user.updateStatus') }}",-->
                    <!--                type: "POST",-->
                    <!--                data: {-->
                    <!--                    _token: "{{ csrf_token() }}",-->
                    <!--                    id: serviceId,-->
                    <!--                    status: newStatus-->
                    <!--                },-->
                    <!--                success: function(response) {-->
                    <!--                    if (response.success) {-->
                    <!--                        alert('User status updated successfully!');-->
                    <!--                    } else {-->
                    <!--                        alert('Failed to update user status.');-->
                    <!--                    }-->
                    <!--                },-->
                    <!--                error: function() {-->
                    <!--                    alert('Something went wrong!');-->
                    <!--                }-->
                    <!--            });-->
                    <!--        });-->
                    <!--    });-->
                    <!--</script>-->
                    
                @endpush
            @endsection
