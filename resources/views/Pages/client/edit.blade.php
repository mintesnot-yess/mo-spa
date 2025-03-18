@extends('layouts.app')
@section('title', 'Edit Client')
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
                                <a href="{{ route('client') }}" class="breadcrumb-item">Client</a>
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
                                <h5 class="mb-0"> Update Client Information </h5>
                            </div>


                            <div class="card-body border-top">
                                <form action="{{ route('client.update', $client->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label"> Name <span style="color: red">*</span> :</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name',$client->name) }}">
                                            @error('name')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>                                        
                                        <div class="col-md-6">
                                            <label class="form-label"> Contact Person <span style="color: red">*</span> :</label>
                                            <input type="text" class="form-control" name="contact_person"
                                                value="{{ old('contact_person',$client->contact_person) }}">
                                            @error('contact_person')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label"> Phone <span style="color: red">*</span> :</label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{ old('phone',$client->phone) }}">
                                            @error('phone')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>                                        
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-primary">Update Client
                                            <i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /basic layout -->


                </div>

            @endsection
