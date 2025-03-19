@extends('layouts.app')
@section('title', 'Create Employee')
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
                                <a href="{{ route('employee') }}" class="breadcrumb-item">Employee</a>
                                <span class="breadcrumb-item active">Edit</span>
                            </div>


                        </div>

                    </div>

                </div>
                <!-- Content area -->
                <div class="content">
                    <!-- Basic layout -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"> Update Employee Information </h5>
                            </div>


                            <div class="card-body border-top">
                                <form action="{{ route('employee.update', $employee->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label"> First Name <span style="color: red">*</span>
                                                :</label>
                                            <input type="text" class="form-control" name="first_name"
                                                value="{{ old('first_name',$employee->first_name) }}">
                                            @error('first_name')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="form-label"> Middle Name <span style="color: red">*</span>
                                                :</label>
                                            <input type="text" class="form-control" name="middle_name"
                                                value="{{ old('middle_name',$employee->middle_name) }}">
                                            @error('middle_name')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>                                       
                                       
                                    </div>
                                    <div class="row">
                                       
                                        <div class="col-md-6">
                                            <label class="form-label"> Last Name <span style="color: red">*</span> :</label>
                                            <input type="text" class="form-control" name="last_name"
                                                value="{{ old('last_name',$employee->last_name) }}">
                                            @error('last_name')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"> Phone <span style="color: red">*</span> :</label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{ old('phone',$employee->phone) }}">
                                            @error('phone')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                         
                                        <div class="col-md-6">
                                            <label class="form-label"> Sex <span style="color: red">*</span> :</label>
                                            <select name="sex" class="form-control select">
                                                <option value="" disabled selected>Select Sex</option>
                                                <option value="Male" @if (old('sex',$employee->sex) == 'Male') selected @endif>
                                                    Male</option>
                                                <option value="Female" @if (old('sex',$employee->sex) == 'Female') selected @endif>
                                                    Female</option>
                                            </select>
                                            @error('sex')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"> Email <span style="color: red">*</span> :</label>
                                            <input type="text" class="form-control" name="email"
                                                value="{{ old('email',$employee->email) }}">
                                            @error('email')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label"> Birth Date <span style="color: red">*</span>
                                                :</label>
                                            <input type="date" class="form-control" name="dob"
                                                value="{{ old('dob',$employee->dob) }}">
                                            @error('dob')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"> Service Group: <span style="color: red">*</span>
                                                :</label>
                                            <select name="service_id" class="form-control select">
                                                <option value="" disabled selected>Select service</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}"
                                                        @if (old('service_id',$employee->service_id) == $service->id) selected @endif>
                                                        {{ $service->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('service_id')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label"> Joind Date <span style="color: red">*</span>
                                                :</label>
                                            <input type="date" class="form-control" name="joind_date"
                                                value="{{ old('joind_date',$employee->join_date) }}">
                                            @error('joind_date')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-primary">Update Employee
                                            <i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @push('js')
                        <script src="{{ asset('assets/js/vendor/forms/tags/tokenfield.min.js') }}"></script>
                        <script src="{{ asset('assets/demo/pages/form_tags.js') }}"></script>
                        <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
                        <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
                        <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
                    @endpush

                @endsection
