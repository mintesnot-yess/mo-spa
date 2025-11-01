@extends('layouts.app')
@section('title', 'Edit Customer')
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
                                <h5 class="mb-0"> Update Customer Information </h5>
                            </div>


                            <div class="card-body border-top">
                                <form action="{{ route('client.update',$client->id) }}" method="POST" enctype="multipart/form-data">
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
                                            <label class="form-label"> Qr Code <span style="color: red">*</span> :</label>
                                            <input type="text" class="form-control" name="code"
                                                value="{{ old('code',$client->code) }}">
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
                                                value="{{ old('phone',$client->phone) }}">
                                            @error('phone')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"> Sex <span style="color: red">*</span> :</label>
                                            <select name="sex" class="form-control select">
                                                <option value="" disabled selected>Select Sex</option>
                                                <option value="Male" @if (old('sex',$client->sex) == 'Male') selected @endif>
                                                    Male</option>
                                                <option value="Female" @if (old('sex',$client->sex) == 'Female') selected @endif>
                                                    Female</option>
                                                <option value="Other" @if (old('sex',$client->sex) == 'Other') selected @endif>
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
                                                <option value="Special" @if (old('category',$client->category) == 'Special') selected @endif>
                                                    VIP</option>
                                                <option value="Normal" @if (old('category',$client->category) == 'Normal') selected @endif>
                                                    Regular</option>
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
                                                <option value="1" @if (old('status',$client->status) == '1') selected @endif>
                                                    Active</option>
                                                <option value="0" @if (old('status',$client->status) == '0') selected @endif>
                                                    Inactive</option>
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
                                           @php
                                                $selectedEmployees = old('employee_id', $client->employee_id ?? []);
                                                $selectedEmployees = is_array($selectedEmployees) ? $selectedEmployees : (array) json_decode($selectedEmployees);
                                            @endphp

                                            <select name="employee_id[]" id="employee-select"  class="form-control multiselect" multiple="multiple">
                                                <!--<option value="" disabled>Select employee</option>-->
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}" data-service-group="{{ $employee->service_group }}"
                                                        {{ in_array($employee->id, $selectedEmployees) ? 'selected' : '' }}>
                                                        {{ $employee->first_name }} {{ $employee->middle_name ?? $employee->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('employee_id')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Profile Image  :</label>
                                            <input type="file" class="form-control" name="image">
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label"> Remark  :</label>
                                            <input type="text" class="form-control" name="remark"
                                                value="{{ old('remark',$client->remark) }}">
                                            @error('remark')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                         <div class="col-md-6">
                                            <label class="form-label"> Branch: <span style="color: red">*</span> :</label>
                                            <select name="branch_id" class="form-select">
                                                <option value="" disabled selected>Select branch</option>
                                                @foreach ($branchs as $branch)
                                                <option value="{{$branch->id}}" @if (old('branch_id',$client->branch_id) == $branch->id) selected @endif>
                                                    {{$branch->name}} </option>
                                                    @endforeach
                                            </select>
                                            @error('branch_id')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-primary">Update Customer
                                            <i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @push('js')
                    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
                    <script src="{{ asset('assets/js/vendor/forms/tags/tokenfield.min.js') }}"></script>
                    <script src="{{ asset('assets/demo/pages/form_tags.js') }}"></script>
                    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
                    <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
                    <script src="{{ asset('assets/js/vendor/forms/selects/bootstrap_multiselect.js') }}"></script>
                    <!-- <script src="{{ asset('assets/demo/pages/form_multiselect.js') }}"></script> -->

                    <script>

                        $(document).ready(function () {

                            // =====================================
                            // ✅ MULTISELECT INITIALIZATION
                            // =====================================
                            $('#employee-select').multiselect({
                                includeSelectAllOption: false,
                                enableFiltering: true,
                                enableCaseInsensitiveFiltering: true,
                                buttonWidth: '100%',
                                nonSelectedText: 'Select employee',
                                onChange: function(option, checked) {
                                    handleEmployeeGroupLogic();
                                }
                            });

                            // =====================================
                            // ✅ FUNCTION: Handle Employee Group Logic
                            // =====================================
                            function handleEmployeeGroupLogic() {
                                const selectedOptions = $('#employee-select option:selected');
                                const selectedGroups = selectedOptions.map(function() {
                                    return $(this).data('service-group');
                                }).get();

                                $('#employee-select option').each(function() {
                                    const group = $(this).data('service-group');
                                    const isSelected = $(this).is(':selected');

                                    if (!isSelected && selectedGroups.includes(group)) {
                                        $(this).prop('disabled', true);
                                    } else {
                                        $(this).prop('disabled', false);
                                    }
                                });

                                $('#employee-select').multiselect('rebuild');
                            }

                            handleEmployeeGroupLogic();

                        });
                    </script>
                    @endpush

                @endsection
