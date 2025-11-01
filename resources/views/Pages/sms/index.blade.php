@extends('layouts.app')
@section('title', 'SMS')
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
                            <span class="breadcrumb-item active">SMS</span>
                        </div>


                    </div>

                </div>

            </div>
            <!-- Content area -->
            <div class="content">


                <!-- Basic datatable -->
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">SMS</h5>

                        <div class="add d-flex gap-2">


                            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="offcanvas"
                                data-bs-target="#sms-create">
                                <i class="ph-plus-circle me-2"></i>Add SNS
                            </a>


                        </div>
                    </div>






                    <table class="table datatable-basic">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>To</th>
                                <th>Body</th>
                                <th>Created At</th>
                                {{-- <th class="text-center">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $counter = 1;
                            @endphp
                            @foreach ($messages as $sms)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $sms['to'] ?? '' }}</td>
                                <td>{{ $sms['body'] ?? '' }}</td>
                                <td>{{ $sms['created_at'] ?? '' }}</td>
                                {{-- <td class="text-center">

                                </td> --}}
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
                <!-- /basic datatable -->

            </div>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="sms-create">
                <div class="py-0 offcanvas-header">
                    <h5 class="py-3 offcanvas-title"> Create SMS</h5>
                    <button type="button" class="border-transparent btn btn-light btn-sm btn-icon rounded-pill"
                        data-bs-dismiss="offcanvas">
                        <i class="ph-x"></i>
                    </button>

                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="p-0 offcanvas-body">
                        <div class="p-3">
                            <div class="mb-3 d-flex align-items-start">
                                <div class="col-md-12">
                                    <label class="form-label"> To <span style="color: red">*</span> :</label>
                                    <input type="text" name="to" value="" class="form-control"
                                        placeholder="+1234567890">
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-start">
                                <div class="col-md-12">
                                    <label class="form-label"> Body <span style="color: red">*</span> :</label>
                                    <input type="text" name="body" value="" class="form-control">
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn-primary">Create SMS
                                    <i class="ph-paper-plane-tilt ms-2"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="sms-update">
                <div class="py-0 offcanvas-header">
                    <h5 class="py-3 offcanvas-title"> Update SMS</h5>
                    <button type="button" class="border-transparent btn btn-light btn-sm btn-icon rounded-pill"
                        data-bs-dismiss="offcanvas">
                        <i class="ph-x"></i>
                    </button>

                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="p-0 offcanvas-body">
                        <div class="p-3">
                            <input type="hidden" id="id" name="id" value="">
                            <div class="mb-3 d-flex align-items-start">
                                <div class="col-md-12">
                                    <label class="form-label"> To <span style="color: red">*</span> :</label>
                                    <input type="text" id="to" name="to" value="" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-start">
                                <div class="col-md-12">
                                    <label class="form-label"> Body <span style="color: red">*</span> :</label>
                                    <input type="text" id="body" name="body" value="" class="form-control">
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn-primary">Update SMS
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
                        let smsId = $(this).data('id');
                        let smsTo = $(this).data('to');
                        let smsBody = $(this).data('body');

                        $('#id').val(smsId);
                        $('#to').val(smsTo).change();
                        $('#body').val(smsBody).change();
                    });
                });
            </script>
            @endpush
            @endsection