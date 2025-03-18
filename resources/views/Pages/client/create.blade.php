@extends('layouts.app')
@section('title', 'Create Customer')
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
                                <a href="{{ route('client') }}" class="breadcrumb-item">Customer</a>
                                <span class="breadcrumb-item active">Create</span>
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
                                <h5 class="mb-0"> Fill Customer Information </h5>
                            </div>


                            <div class="card-body border-top">
                                <form action="{{ route('client.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label"> Name <span style="color: red">*</span> :</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}">
                                            @error('name')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>                                        
                                        <div class="col-md-6">
                                            <label class="form-label"> Qr Code <span style="color: red">*</span> :</label>
                                            <input type="text" class="form-control" name="code"
                                                value="{{ old('code') }}">
                                            @error('code')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label"> Phone <span style="color: red">*</span> :</label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{ old('phone') }}">
                                            @error('phone')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>                                        
                                        <div class="col-md-6">
                                            <label class="form-label"> Sex <span style="color: red">*</span> :</label>
                                            <select name="sex" class="form-control select">
                                                <option value="" disabled selected>Select Sex</option>
                                                <option value="Male" @if (old('sex') == 'Male') selected @endif>
                                                    Male</option>
                                                <option value="Female" @if (old('sex') == 'Female') selected @endif>
                                                    Female</option>
                                                <option value="Other" @if (old('sex') == 'Other') selected @endif>
                                                    Other</option>
                                            </select>
                                            @error('sex')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>                                        
                                    </div>
                                    <div class="row">
                                                                              
                                        <div class="col-md-6">
                                            <label class="form-label"> Customer Category <span style="color: red">*</span> :</label>
                                            <select name="category" class="form-control select">
                                                <option value="" disabled selected>Select category</option>
                                                <option value="Special" @if (old('category') == 'Special') selected @endif>
                                                    Special</option>
                                                <option value="Normal" @if (old('category') == 'Normal') selected @endif>
                                                    Normal</option>
                                            </select>
                                            @error('category')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>                                        
                                        <div class="col-md-6">
                                            <label class="form-label"> Status <span style="color: red">*</span> :</label>
                                            <select name="status" class="form-control select">
                                                <option value="" disabled selected>Select status</option>
                                                <option value="1" @if (old('status') == '1') selected @endif>
                                                    Pending</option>
                                                <option value="0" @if (old('status') == '0') selected @endif>
                                                    Active</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label"> Assign Employee: <span style="color: red">*</span> :</label>
                                            <select name="sex" class="form-control select">
                                                <option value="" disabled selected>Select employee</option>
                                                @foreach ($employees as $employee)
                                                <option value="{{$employee->id}}" @if (old('sex') == $employee->id) selected @endif>
                                                    {{$employee->name}}</option>
                                                    @endforeach
                                            </select>
                                            @error('sex')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>                                       
                                        <div class="col-md-6">
                                            <label class="form-label"> Remark <span style="color: red">*</span> :</label>
                                            <input type="text" class="form-control" name="remark"
                                                value="{{ old('remark') }}">
                                            @error('remark')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>                                        
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-primary">Add Customer
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
