<!DOCTYPE html>
<html>
 @php
    $groupMappings = [
        'ስፓ' => 1,
        'ጸጉር ቆራጭ' => 2,
        'የውስጥ ስራዎች' => 3,
    ];
    $employee = \App\Models\Employee::find(auth()->user()->emp_id);
    $userGroupId = $groupMappings[$employee->service_group] ?? null;
@endphp

<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        // Fetch authenticated user's employee ID (Modify this as needed)
        // var employeeId = 3; // Replace with actual employee ID from session or AJAX call

        // Initialize Pusher
        Pusher.logToConsole = true;
        var pusher = new Pusher('8f0b52c70071f178a28c', {
            cluster: 'mt1',
            authEndpoint: '/broadcasting/auth', // Ensure Laravel Echo Server is set up for private channels
            auth: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for authentication
                }
            }
        });
       

       var userServiceGroup = "{{ $userGroupId }}";
var channel = pusher.subscribe('mospa-channel-service.' + userServiceGroup);

channel.bind('service.updated', function(data) {
    console.log("Service Update:", data);
    document.getElementById("serviceoutput").innerText = JSON.stringify(data, null, 2);
});


        var allCustomerChannel = pusher.subscribe('mospa-customer-channel');
        allCustomerChannel.bind('all.customer.updated', function(data) {
            console.log("All Customers Update:", data);
            document.getElementById("allcustomeroutput").innerText = JSON.stringify(data, null, 2);
        });

         // Staff-specific updates (private channel)
    var employeeId = {!! json_encode(auth()->user()->emp_id) !!}; 
        var staffChannel = pusher.subscribe('staff.customer.' + employeeId);
        staffChannel.bind('staff.customer.updated', function(data) {
            console.log("Staff-Specific Customer Update:", data);
            document.getElementById("customeroutput").innerText = JSON.stringify(data, null, 2);
        });
    </script>
</head>

<body>
    <h2>Service Updates:</h2>
    <pre id="serviceoutput"></pre>
    <hr>
    <h2>Customer Updates (Only Assigned to You):</h2>
    <pre id="customeroutput"></pre>
    <hr>
    <h2>All Customer Updates:</h2>
    <pre id="allcustomeroutput"></pre>
</body>

</html>
