@extends('layouts.app')
@section('title', 'Edit Service')
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
                                <h5 class="mb-0"> Update Service Information </h5>
                            </div>


                            <div class="card-body border-top">
                                <form action="{{ route('service.update', $service->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label"> Title <span style="color: red">*</span>
                                                :</label>
                                            <input type="text" class="form-control" name="title"
                                                value="{{ old('title', $service->title) }}">
                                            @error('title')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label"> Service Code
                                                :</label>
                                            <input type="text" class="form-control" name="code"
                                                value="{{ old('code', $service->code) }}">
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
                                                        @if (old('category', $service->type) == $category->title) selected @endif>
                                                        {{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"> Service Type: <span style="color: red">*</span>
                                                :</label>
                                            <select name="type" class="form-control select">
                                                <option value="ጸጉር ቆራጭ" @if (old('type',$service->type) == 'ጸጉር ቆራጭ') selected @endif>
                                                    ጸጉር ቆራጭ</option>
                                                <option value="ስፓ" @if (old('type',$service->type) == 'ስፓ') selected @endif>
                                                    ስፓ</option>
                                                <option value="የውስጥ ስራዎች" @if (old('type',$service->type) == 'የውስጥ ስራዎች') selected @endif>
                                                    የውስጥ ስራዎች</option>

                                            </select>
                                            @error('type')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label"> Price <span style="color: red">*</span> :</label>
                                            <input type="text" class="form-control" name="price"
                                                value="{{ old('price', $service->price) }}">
                                            @error('price')
                                                <div class="text-danger">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label"> Need Items: <span style="color: red">*</span>
                                                :</label>
                                            <select name="need_item" class="form-select" id="need_item">
                                                <option value="" disabled selected>Select</option>
                                                <option value="yes" @if (old('need_item', $service->have_items) == 'yes') selected @endif>Yes
                                                </option>
                                                <option value="no" @if (old('need_item', $service->have_items) == 'no') selected @endif>No
                                                </option>
                                            </select>
                                            @error('need_item')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6" id="items_section" style="display: none;">
                                            <label class="form-label"> Items: <span style="color: red">*</span> :</label>
                                            <select name="items[]" class="form-control multiselect" multiple="multiple">
                                                <option value="" disabled>Select items</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}"
                                                        @if (is_array(old('items', $serviceItems)) && in_array($item->id, old('items', $serviceItems))) selected @endif>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach

                                            </select>

                                            @error('items')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-primary">Update Service
                                            <i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @push('js')
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const needItemSelect = document.getElementById('need_item');
                                const itemsSection = document.getElementById('items_section');

                                function toggleItems() {
                                    if (needItemSelect.value === 'yes') {
                                        itemsSection.style.display = 'block';
                                    } else {
                                        itemsSection.style.display = 'none';
                                    }
                                }

                                needItemSelect.addEventListener('change', toggleItems);

                                toggleItems();
                            });
                        </script>
                        <script src="{{ asset('assets/js/vendor/forms/tags/tokenfield.min.js') }}"></script>
                        <script src="{{ asset('assets/demo/pages/form_tags.js') }}"></script>
                        <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
                        <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
                        <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
                        <script src="{{ asset('assets/js/vendor/forms/selects/bootstrap_multiselect.js') }}"></script>
                        <script src="{{ asset('assets/demo/pages/form_multiselect.js') }}"></script>
                    @endpush

                @endsection
