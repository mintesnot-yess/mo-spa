@extends('layouts.app')
@section('title', 'Create Services')
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
                                <a href="{{ route('service') }}" class="breadcrumb-item">Service</a>
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
                                <h5 class="mb-0"> Fill Service Information </h5>
                            </div>


                            <div class="card-body border-top">
                                <form action="{{ route('service.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label"> Title <span style="color: red">*</span>
                                                :</label>
                                            <input type="text" class="form-control" name="title"
                                                value="{{ old('title') }}">
                                            @error('title')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="form-label"> Service Code 
                                                :</label>
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
                                            <label class="form-label"> Category: <span style="color: red">*</span>
                                                :</label>
                                            <select name="category" class="form-control select">
                                                <option value="" disabled selected>Select category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        @if (old('category') == $category->id) selected @endif>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"> Price <span style="color: red">*</span> :</label>
                                            <input type="text" class="form-control" name="price"
                                                value="{{ old('price') }}">
                                            @error('price')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label"> Service Type: <span style="color: red">*</span>
                                                :</label>
                                                <select name="type" class="form-control select">
                                                    <option value="" disabled selected>Select type</option>
                                                    <option value="ጸጉር ቆራጭ" @if (old('type') == 'ጸጉር ቆራጭ') selected @endif>
                                                        ጸጉር ቆራጭ</option>
                                                    <option value="የውስጥ ስራዎች" @if (old('type') == 'የውስጥ ስራዎች') selected @endif>
                                                        የውስጥ ስራዎች</option>
                                                    <option value="ስፓ" @if (old('type') == 'ስፓ') selected @endif>
                                                        ስፓ</option>
                                                </select>
                                            @error('type')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    

                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-primary">Add Employee
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
