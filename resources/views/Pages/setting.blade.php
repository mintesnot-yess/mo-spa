@extends('layouts.app')
@section('title', 'Profile')

@section('content')
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
                <div class="page-header page-header-light shadow">
                    <div class="page-header-content d-lg-flex border-top">
                        <div class="d-flex">
                            <div class="breadcrumb py-2">
                                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="ph-house"></i></a>
                                {{-- <a href="{{ route('service.index') }}" class="breadcrumb-item">Services</a> --}}
                                <span class="breadcrumb-item active">Setting</span>
                            </div>


                        </div>

                    </div>

                </div>
                <!-- Content area -->
                <div class="content">
                    <!-- Basic layout -->
                    <div class="col-lg-9">
                        <div class="card">


                            <div class="card-body border-top">


                                <div style="margin-bottom: 2%"></div>
                                <ul class="nav nav-tabs mb-3">
                                    <li class="nav-item">
                                        <a href="#Overview"class="nav-link active"
                                            data-bs-toggle="tab">Overview

                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#Edit"class="nav-link" data-bs-toggle="tab">Edit
                                            Profile
                                            @if ($errors->has('name') || $errors->has('email') || $errors->has('document'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#Chenge"class="nav-link" data-bs-toggle="tab"> Chenge
                                            Password
                                            @if ($errors->has('password'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="Overview">
                                        <div class="content">
                                            <div class="col-lg-12">
                                                <div class="row mt-3">

                                                    <div class="col-md-2">
                                                        <label class="form-label"> Full Name :</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        {{ $user->name }}
                                                    </div>

                                                </div>
                                                <div class="row mt-3">

                                                    <div class="col-md-2">
                                                        <label class="form-label">Email :</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        {{ $user->email }}
                                                    </div>

                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade show" id="Edit">
                                        <div class="content">
                                            <div class="col-lg-12">
                                                <div class="row mt-3">
                                                    <form action="{{ route('setting.update.profile') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="col-md-6">
                                                            <label class="form-label"> Full Name:</label>
                                                            <input type="text" class="form-control" name="name"
                                                                placeholder="Full Name"
                                                                value="{{ old('name', $user->name) }}">
                                                            @error('name')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Email:</label>
                                                            <input type="email" class="form-control" name="email"
                                                                placeholder="jhondo@gmail.com"
                                                                value="{{ old('email', $user->email) }}">
                                                            @error('email')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>                                                       

                                                </div>

                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" data-animation="lightSpeedIn"
                                                class="btn btn-primary">Update Profile <i
                                                    class="ph-paper-plane-tilt ms-2"></i></button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade show" id="Chenge">
                                        <div class="content">
                                            <div class="col-lg-12">
                                                <div class="row mt-3">
                                                    <form action="{{ route('setting.update.password') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="col-md-6">
                                                            <label class="form-label"> New Password :</label>
                                                            <input type="password" class="form-control" name="password"
                                                                placeholder="Enter New Password"
                                                                value="{{ old('password') }}">
                                                            @error('password')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label"> Confirm Password :</label>
                                                            <input type="password" class="form-control"
                                                                name="password_confirmation"
                                                                placeholder="Confirm the above password"
                                                                value="{{ old('password_confirmation') }}">
                                                            @error('password_confirmation')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" data-animation="lightSpeedIn"
                                                class="btn btn-primary">Update Password  <i
                                                    class="ph-paper-plane-tilt ms-2"></i></button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /basic layout -->


                    </div>
                    @push('js')
                        <!-- Theme JS files -->
                        <script src="{{ asset('assets/js/vendor/notifications/noty.min.js') }}"></script>
                        <script src="{{ asset('assets/demo/pages/extra_noty.js') }}"></script>
                        <!-- /theme JS files -->
                        
                    @endpush
                @endsection
