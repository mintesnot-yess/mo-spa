@extends('layouts.app')
@section('title', 'Pending Transactions')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@push('css')
    <style>
        .add {
            display: flex;
            justify-content: flex-end;
        }

        .wide-offcanvas {
            width: 40vw !important;
            /* Adjust width as needed */
            max-width: 90vw;
            /* Optional: Prevent excessive width */
        }
            .offcanvas-body {
        -ms-flex-positive: 1;
        flex-grow: 1;
        padding: var(--offcanvas-padding-y) var(--offcanvas-padding-x);
        overflow-y: auto;
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
                                <span class="breadcrumb-item active">Transactions</span>
                                <span class="breadcrumb-item active">Pending</span>
                            </div>


                        </div>

                    </div>

                </div>
                <!-- Content area -->
                <div class="content">


                    <!-- Basic datatable -->
                    <div class="card">
                        
                        <table class="table datatable-basic">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Sex</th>
                                    <th>Phone</th>
                                    <th>Customer Type</th>
                                    <th>Taking Service</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @php
                                    $counter = 1;
                                @endphp
                                @foreach ($transactions as $group)
                                    @php
                                        $firstTransaction = $group->first(); // Get first transaction in the group
                                        $customer = $firstTransaction->client;
                                        $serviceCount = $group->count(); // Count services
                                    @endphp
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $customer->name ?? 'N/A' }}</td>
                                        <td>{{ $customer->sex ?? 'N/A' }}</td>
                                        <td>...{{ substr($customer->phone ?? '', -6) }}</td>
                                        <td>{{ $customer->category === 'Special' ? 'VIP' : 'Regular' }}</td>
                                        <td>
                                            <a href="#" onclick="loadServiceDetails({{ $group }})"
                                                data-bs-toggle="offcanvas" data-bs-target="#show-service">
                                                {{ $serviceCount }} Services
                                            </a>
                                        </td>
                                        <td>{{ $firstTransaction->created_at->format('Y-m-d') }}</td>
                                        <td><a href="#" data-bs-toggle="offcanvas"
                                                onclick="actionServiceDetails({{ $group }}, {{ $customer->id }})"
                                                data-bs-target="#statuses"><i class="ph-list-checks"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <!-- /basic datatable -->

                </div>
                <!-- /page content -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="statuses">

                    <div class="py-0 offcanvas-header">
                        <h5 class="py-3 offcanvas-title">Complate Service</h5>
                        <button type="button" class="border-transparent btn btn-light btn-sm btn-icon rounded-pill"
                            data-bs-dismiss="offcanvas">
                            <i class="ph-x"></i>
                        </button>

                    </div>
                        <div class="p-0 offcanvas-body">
                            <div class="p-3">
                                <div class="mb-3 d-flex align-items-start">
                                    <table class="table datatable" id="action-details">
                                        <thead>
                                            <tr>
                                                <th>Service</th>
                                                <th>Employee</th>
                                                <th>Price</th>
                                                <th>Is New</th>
                                            </tr>
                                        </thead>
                    <form action="{{ route('service.complate') }}" method="POST">
                        @csrf
                                        <tbody>
                                            <!-- Dynamic data will be inserted here -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3 text-end">
                                    <button type="submit" class="btn btn-primary">Complate Service
                                        <i class="ph-paper-plane-tilt ms-2"></i></button>
                                </div>
                        <input type="hidden" name="transactions" id="transactions-input">
                        <input type="hidden" name="cleint_id" id="client-id-input">
                    </form>
                            </div>
                        </div>
                </div>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="show-service">
                    <div class="py-0 offcanvas-header">
                        <h5 class="py-3 offcanvas-title">Service Taking</h5>
                        <button type="button" class="border-transparent btn btn-light btn-sm btn-icon rounded-pill"
                            data-bs-dismiss="offcanvas">
                            <i class="ph-x"></i>
                        </button>
                    </div>
                    <div class="p-0 offcanvas-body">
                        <div class="p-3">
                            <div class="mb-3 d-flex align-items-start">
                                <table class="table datatable" id="service-details">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Employee</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dynamic data will be inserted here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

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
                        function loadServiceDetails(transactions) {
                            let serviceTableBody = document.querySelector("#service-details tbody");
                            serviceTableBody.innerHTML = ""; // Clear previous content

                            transactions.forEach(transaction => {
                                let row = `
                                    <tr id="service-row-${transaction.id}">
                                        <td>${transaction.service.title ?? 'Unknown'}</td>
                                        <td>${transaction.employee.first_name ?? 'N/A'}</td>
                                       
                                        <td>
                                            <button class="btn btn-edit" onclick="deleteService(${transaction.id})">
                                                <i class="ph-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                                serviceTableBody.innerHTML += row;
                            });
                        }

                        function actionServiceDetails(transactions, clientId) {
    let serviceTableBody = document.querySelector("#action-details tbody");
    serviceTableBody.innerHTML = ""; // Clear previous content

    let totalPrice = 0;
    let transactionData = [];

    transactions.forEach(transaction => {
        totalPrice += parseFloat(transaction.price) || 0;

        let row = `
            <tr id="service-row-${transaction.id}">
                <td>${transaction.service.title ?? 'Unknown'}</td>
                <td>${transaction.employee.first_name ?? 'N/A'}</td>                                        
                <td>${transaction.price ?? 'N/A'}</td>
                <td>
                    <label class="form-switch form-check-reverse">
                        <input type="checkbox" class="form-check-input service-status-toggle"
                            data-id="${transaction.id}"
                            ${transaction.is_new == 1 ? 'checked' : ''}>
                    </label>
                </td>
            </tr>
        `;
        serviceTableBody.innerHTML += row;

        // Push initial data
        transactionData.push({
            id: transaction.id,
            is_new: transaction.is_new == 1 ? 1 : 0,
        });
    });

    // Add total row
    serviceTableBody.innerHTML += `
        <tr>
            <td colspan="2"><strong>Total Price</strong></td>
            <td><strong>${totalPrice.toFixed(2)}</strong></td>
            <td></td>
        </tr>
    `;

    // Update hidden input immediately
    document.querySelector("#transactions-input").value = JSON.stringify(transactionData);
    document.querySelector("#client-id-input").value = clientId;

    // Listen for checkbox changes
    document.querySelectorAll(".service-status-toggle").forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            const id = parseInt(this.dataset.id);
            const isNew = this.checked ? 1 : 0;
            console.log(id);
            // Update locally in transactionData
            const transaction = transactionData.find(t => t.id === id);
            if (transaction) transaction.is_new = isNew;

            // Reflect change in hidden input
            document.querySelector("#transactions-input").value = JSON.stringify(transactionData);

            // Send AJAX update
            fetch(`/admin/transactions/${id}/update-is-new`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ is_new: isNew })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) alert('Failed to update status');
            })
            .catch(error => {
                console.error('Error updating status:', error);
                alert('An error occurred');
            });
        });
    });
}




                        function deleteService(transactionId) {
                            if (!confirm("Are you sure you want to delete this service?")) return;

                            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

                            fetch(`/admin/transactions/${transactionId}/delete`, {
                                    method: "DELETE",
                                    // /transactions/{id}/delete
                                    headers: {
                                        "X-CSRF-TOKEN": csrfToken,
                                        "Content-Type": "application/json"
                                    }
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        return response.json().then(err => {
                                            throw err;
                                        });
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        document.getElementById(`service-row-${transactionId}`).remove();
                                    } else {
                                        alert(data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error("Error:", error);
                                    alert("Failed to delete service. Please try again.");
                                });
                        }
                    </script>
                @endpush
            @endsection
