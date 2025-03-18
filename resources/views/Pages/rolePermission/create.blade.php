@extends('layouts.app')
@section('title', 'Create Role')
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
                                <a href="{{ route('rolepermission') }}" class="breadcrumb-item">Role</a>
                                <span class="breadcrumb-item active">Create</span>
                            </div>


                        </div>

                    </div>

                </div>
                <!-- Content area -->
                <div class="content">
                    <!-- Basic layout -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Fill Role Information</h5>
                            </div>



                            <div class="card-body border-top">
                                <form action="{{ route('role.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label"> Role Name <span style="color: red">*</span> :</label>
                                        <input type="text" class="form-control" name="name" placeholder="Role Name">
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" data-animation="lightSpeedIn" class="btn btn-primary">Add Role
                                             <i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /basic layout -->


                </div>
            </div>
        </div>
    </div>
    <!-- /content area -->



    </div>
    <!-- /inner content -->

    </div>
    <!-- /main content -->

    </div>

@endsection
