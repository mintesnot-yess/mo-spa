<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>MO-SPA | @yield('title')</title>

	<!-- Global stylesheets -->
	<link href="{{ asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">

	@stack('css')
	<!-- /global stylesheets -->

	<script src="{{ asset('assets/js/vendor/notifications/noty.min.js') }}"></script>
	<script src="{{ asset('assets/demo/pages/extra_noty.js') }}"></script>
	<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
	<script>
		// Initialize Pusher
    var pusher = new Pusher('8f0b52c70071f178a28c', {
        cluster: 'mt1',
        encrypted: true,
        authEndpoint: '/broadcasting/auth' // Ensure Laravel Echo auth is configured properly
    });

    // Get the authenticated employee ID
    var employeeId = {!! json_encode(auth()->user()->emp_id) !!};

    // Subscribe to the employee-specific private channel
    var channel = pusher.subscribe('user-notification.' + employeeId);

    // Bind the notification event
    channel.bind('user-notification', function(data) {
        console.log("Received Notification Data:", data);

        // Update modal content dynamically
        $('#modal_default .modal-title').text(data.customers.title);
        $('#modal_default .modal-body p').text(data.customers.body);

        // Show the modal
        $('#modal_default').modal('show');

        // Play notification sound
        var audio = new Audio('/notification.mp3');
        audio.play();

        // Optional Noty notification
        // new Noty({
        //     type: 'success',
        //     layout: 'topRight',
        //     text: data.customers.body,
        //     timeout: 30000
        // }).show();
    });
	</script>

</head>

<body>
	@if (session('success'))
	<div id="noty_success" data-message="{{ session('success') }}"></div>
	@endif

	@if (session('error'))
	<div id="noty_error" data-message="{{ session('error') }}"></div>
	@endif
	@include('partials.header')
	<!-- Page content -->
	<div class="page-content">
		@include('partials.sidebar')
		@yield('content')
	</div>
	<!-- /page content -->
	<!-- Demo config -->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="demo_config">
		<div class="visible position-absolute top-50 end-100">
			<button type="button" class="btn btn-primary btn-icon translate-middle-y rounded-end-0"
				data-bs-toggle="offcanvas" data-bs-target="#demo_config">
				<i class="ph-sun"></i>
			</button>
		</div>

		{{-- <div class="py-0 offcanvas-header border-bottom">
			<h5 class="py-3 offcanvas-title">Demo configuration</h5>
			<button type="button" class="border-transparent btn btn-light btn-sm btn-icon rounded-pill"
				data-bs-dismiss="offcanvas">
				<i class="ph-x"></i>
			</button>
		</div> --}}

		<div class="offcanvas-body" id="demo_config">
			<div class="mb-2 fw-semibold">Color mode</div>
			<div class="mb-3 list-group">
				<label class="mb-2 rounded list-group-item list-group-item-action form-check border-width-1">
					<div class="my-1 d-flex flex-fill">
						<div class="form-check-label d-flex me-2">
							<i class="ph-sun ph-lg me-3"></i>
							<div>
								<span class="fw-bold">Light theme</span>
								<div class="fs-sm text-muted">Set light theme or reset to default</div>
							</div>
						</div>
						<input type="radio" class="cursor-pointer form-check-input ms-auto" name="main-theme"
							value="light" checked>
					</div>
				</label>

				<label class="mb-2 rounded list-group-item list-group-item-action form-check border-width-1">
					<div class="my-1 d-flex flex-fill">
						<div class="form-check-label d-flex me-2">
							<i class="ph-moon ph-lg me-3"></i>
							<div>
								<span class="fw-bold">Dark theme</span>
								<div class="fs-sm text-muted">Switch to dark theme</div>
							</div>
						</div>
						<input type="radio" class="cursor-pointer form-check-input ms-auto" name="main-theme"
							value="dark">
					</div>
				</label>
			</div>
		</div>

	</div>
	<!-- /demo config -->
	<script src="{{ asset('/assets/demo/pages/components_modals.js') }}"></script>
	<!-- /demo config -->
	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><span id="modal-title">Notification</span></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<div class="modal-body">
					<p id="modal-body">You have a new notification.</p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	@include('partials.footer')
	<script src="{{ asset('assets/js/vendor/notifications/noty.min.js') }}"></script>
	<script src="{{ asset('assets/demo/pages/extra_noty.js') }}"></script>
	<!-- /theme JS files -->
	<script>
		document.addEventListener('DOMContentLoaded', function() {
            const notySuccessElement = document.querySelector('#noty_success');
            if (notySuccessElement) {
                new Noty({
                    text: notySuccessElement.getAttribute('data-message'),
                    type: 'success'
                }).show();
            }

            const notyErrorElement = document.querySelector('#noty_error');
            if (notyErrorElement) {
                new Noty({
                    text: notyErrorElement.getAttribute('data-message'),
                    type: 'error'
                }).show();
            }

        });
	</script>
	<script type="module">
		import { initializeApp } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-app.js";
		import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-analytics.js";
		import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-messaging.js";
	
		const firebaseConfig = {
			apiKey: "AIzaSyASEfDNWw1ItexziaB-PBxm50YC2nXxhrI",
			authDomain: "mo-spa-26cfd.firebaseapp.com",
			projectId: "mo-spa-26cfd",
			storageBucket: "mo-spa-26cfd.firebasestorage.app",
			messagingSenderId: "187976211852",
			appId: "1:187976211852:web:3b52cd23e8e75dc6de8aa9",
			measurementId: "G-RW76C19DBZ"
		};
	
		// Initialize Firebase
		const app = initializeApp(firebaseConfig);
		const analytics = getAnalytics(app);
		const messaging = getMessaging(app);
		const vapidKey = "BOuXdkLNpvSzRoWxcqyEVLA7EDbei4VoselKiIjJXMqWXbizmfd_wUPT78W2tBllSpYOItNWzrJ8J1uw2Ts2T7A";
	
		function requestNotificationPermission() {
			Notification.requestPermission().then((permission) => {
				if (permission === "granted") {
					console.log("Notification permission granted.");
					registerServiceWorker();
				} else {
					console.log("Notification permission denied.");
				}
			}).catch((error) => {
				console.error("Permission request error:", error);
			});
		}
	
		function registerServiceWorker() {
			navigator.serviceWorker.register('/firebase-messaging-sw.js', { type: 'module' })
				.then((registration) => {
					console.log("Service Worker Registered:", registration);
					getFcmToken(registration);
				})
				.catch((error) => {
					console.error("Service Worker registration failed:", error);
				});
		}
	
		function getFcmToken(registration) {
			getToken(messaging, { serviceWorkerRegistration: registration, vapidKey: vapidKey })
				.then((currentToken) => {
					if (currentToken) {
						console.log("FCM Token:", currentToken);
	
						// Send token to the server
						$.post("{{ url('/admin/store_fcm') }}", {
							'_token': '{{ csrf_token() }}',
							'fcm_token': currentToken
						}).then((resp) => {
							console.log("Token Stored:", resp);
						}).catch((err) => {
							console.error("Token Storage Failed:", err);
						});
	
					} else {
						console.log("No FCM token available. Request permission to generate one.");
					}
				})
				.catch((err) => {
					console.error("Error retrieving FCM token:", err);
				});
		}
	
		$(document).ready(function () {
			requestNotificationPermission();
		});
		messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });
	</script>
	</div>
	</div>
</body>

</html>