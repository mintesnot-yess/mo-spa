@extends('layouts.app')
@section('title', 'Create System User')
@push('css')
    <style>
        .uper {
            padding-top: 2%;
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
                <div class="shadow page-header page-header-light">


                    <div class="page-header-content d-lg-flex border-top">
                        <div class="d-flex">
                            <div class="py-2 breadcrumb">
                                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="ph-house"></i></a>
                                <a href="{{ route('staff.index') }}" class="breadcrumb-item"> System User</a>
                                <span class="breadcrumb-item active">Create</span>
                            </div>


                        </div>

                    </div>

                </div>
                <!-- Content area -->
                <div class="content">
                    <!-- Basic layout -->
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Fill System User Information </h5>
                            </div>

                            <div class="card-body border-top">
                                <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">                                        
                                        <div class="col-md-6">
                                            <label class="form-label"> Employee <span style="color: red">*</span>
                                                :</label>
                                            <select name="employee" class="form-control select">
                                                <option value="">Select a employee...</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        {{ old('employee') == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('employee')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Role <span style="color: red">*</span> :</label>
                                            <select name="role" class="form-control select">
                                                <option value="">Select a role...</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ old('role') == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Password <span style="color: red">*</span> :</label>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="********">
                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"> Confirm Password <span style="color: red">*</span>
                                                :</label>
                                            <input type="password" class="form-control" name="password_confirmation"
                                                placeholder="********">
                                            @error('password_confirmation')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                     <div class="row">

                                        <div class="col-md-6">
                                            <label class="form-label">Profile Image :</label>
                                            <input type="file" class="form-control" name="image">
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                    </div>

                                    </div>
                                    <div class="text-end uper">
                                        <button type="submit" data-animation="lightSpeedIn" class="btn btn-primary"> Add
                                            User <i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>

                            {{-- </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div> --}}
                    </div>
                    <!-- /basic layout -->


                </div>
                @push('js')
                    <script src="{{ asset('assets/js/vendor/forms/tags/tokenfield.min.js') }}"></script>
                    <script src="{{ asset('assets/demo/pages/form_tags.js') }}"></script>
                    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
                    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
                    <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
                @endpush

            @endsection
