@extends('layouts.app')
@section('title', 'Services')
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
                                <span class="breadcrumb-item active">Services</span>
                            </div>


                        </div>

                    </div>

                </div>
                <!-- Content area -->
                <div class="content">


                    <!-- Basic datatable -->
                    <div class="card">
                        @can('add_service')
                            <div class="add">
                                <a href="{{ route('service.create') }}" class="btn btn-edit"><i class="ph-plus-circle"></i>
                                    Add Service</a>
                            </div>
                        @endcan
                        <table class="table datatable-basic">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Code</th>
                                    <th>Category</th>
                                    <th>Service Type</th>
                                    <th>Price</th>
                                    <th>Items</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Update By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($services as $service)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $service ? $service->title : '' }}</td>
                                        <td>{{ $service ? $service->code : '' }}</td>
                                        <td>{{ $service->categories ? $service->categories->title : '' }}</td>
                                        <td>{{ $service ? $service->type : '' }}</td>
                                        <td>{{ $service ? $service->price : '' }}</td>
                                        <td>
                                         @php
    $displayed = [];
    $itemNames = [];

    foreach ($service->itemServices as $itemService) {
        if ($itemService->item && !in_array($itemService->item->id, $displayed)) {
            $itemNames[] = $itemService->item->name;
            $displayed[] = $itemService->item->id;
        }
    }
@endphp

{{ implode(', ', $itemNames) }}

                                            </td>
                                        <td>
                                            <label class="form-switch form-check-reverse">
                                                <input type="checkbox" class="form-check-input service-status-toggle"
                                                    data-id="{{ $service->id }}"
                                                    {{ $service->status == 1 ? 'checked' : '' }}>
                                            </label>
                                        </td>
                                        <td>{{ $service->user ? $service->user->name : '' }}</td>
                                        <td>{{ $service->updatesUser ? $service->updatedUser->name : '-' }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex">
                                                <div class="dropdown">
                                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                                        <i class="ph-list"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('edit_service')
                                                            <a href="{{ route('service.edit', $service->id) }}"
                                                                class="dropdown-item">
                                                                <i class="ph-pencil-line me-2"></i>Edit
                                                            </a>
                                                        @endcan
                                                        @can('delete_service')
                                                            <form action="{{ route('service.delete', $service->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item"
                                                                    onclick="return confirm('Are you sure you want to delete this service?');">
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
                            $('.service-status-toggle').change(function() {
                                let serviceId = $(this).data('id');
                                let newStatus = $(this).is(':checked') ? 1 : 0;
                    
                                $.ajax({
                                    url: "{{ route('service.updateStatus') }}",
                                    type: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        id: serviceId,
                                        status: newStatus
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            alert('Service status updated successfully!');
                                        } else {
                                            alert('Failed to update service status.');
                                        }
                                    },
                                    error: function() {
                                        alert('Service status updated successfully!');
                                    }
                                });
                            });
                        });
                    </script>
                @endpush
            @endsection
