@extends('layouts.app')
@section('title', 'Items')
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
                                <span class="breadcrumb-item active">Items</span>
                            </div>


                        </div>

                    </div>

                </div>
                <!-- Content area -->
                <div class="content">


                    <!-- Basic datatable -->
                    <div class="card">
                        @can('add_item')
                            <div class="add">
                                <a href="#"
                                class="navbar-nav-link navbar-nav-link-icon rounded-pill client-status-btn"
                                data-bs-toggle="offcanvas" data-bs-target="#branch-create"><i class="ph-plus-circle"></i>
                                    Add Item</a>
                            </div>
                        @endcan
                        <table class="table datatable-basic">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Created By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $item ? $item->name : '' }}</td>
                                        <td>{{ $item->user ? $item->user->name : '' }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex">
                                                <div class="dropdown">
                                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                                        <i class="ph-list"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('edit_item')
                                                            <a href="#"
                                                            data-bs-toggle="offcanvas" data-bs-target="#branch-update"
                                                            data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                                class="dropdown-item client-status-btn">
                                                                <i class="ph-pencil-line me-2"></i>Edit
                                                            </a>
                                                        @endcan
                                                        @can('delete_item')
                                                            <form action="{{ route('item.delete', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item"
                                                                    onclick="return confirm('Are you sure you want to delete this branch?');">
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
                <div class="offcanvas offcanvas-end" tabindex="-1" id="branch-create">
                    <div class="py-0 offcanvas-header">
                        <h5 class="py-3 offcanvas-title"> Create Item</h5>
                        <button type="button" class="border-transparent btn btn-light btn-sm btn-icon rounded-pill"
                            data-bs-dismiss="offcanvas">
                            <i class="ph-x"></i>
                        </button>

                    </div>
                    <form action="{{route('item.store')}}" method="POST">
                        @csrf
                        <div class="p-0 offcanvas-body">
                            <div class="p-3">
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="col-md-12">
                                        <input type="hidden" id="id-select" name="id" value="">
                                        <label class="form-label"> Name <span style="color: red">*</span> :</label>
                                        <input type="text" name="name" vlaue="" class="form-control">
                                    </div>
                                </div>
                                <div class="mt-3 text-end">
                                    <button type="submit" class="btn btn-primary">Create Item
                                        <i class="ph-paper-plane-tilt ms-2"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="branch-update">
                    <div class="py-0 offcanvas-header">
                        <h5 class="py-3 offcanvas-title"> Update Item</h5>
                        <button type="button" class="border-transparent btn btn-light btn-sm btn-icon rounded-pill"
                            data-bs-dismiss="offcanvas">
                            <i class="ph-x"></i>
                        </button>

                    </div>
                    <form action="{{route('item.update')}}" method="POST">
                        @csrf
                        <div class="p-0 offcanvas-body">
                            <div class="p-3">
                                <div class="mb-3 d-flex align-items-start">
                                    <div class="col-md-12">
                                        <input type="hidden" id="id" name="id" value="">
                                        <label class="form-label"> Name <span style="color: red">*</span> :</label>
                                        <input type="text" id="name" name="name" vlaue="" class="form-control">
                                    </div>
                                </div>
                                <div class="mt-3 text-end">
                                    <button type="submit" class="btn btn-primary">Update Item
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
                    <script>
                        $(document).ready(function() {
                            $('.client-status-btn').click(function() {
                                let itemId = $(this).data('id');
                                let itemName = $(this).data('name');
                                
                                $('#id').val(itemId);
                                $('#name').val(itemName).change();
                            });
                        });
                    </script>
                @endpush
            @endsection
