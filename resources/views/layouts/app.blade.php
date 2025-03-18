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
			<button type="button" class="btn btn-primary btn-icon translate-middle-y rounded-end-0" data-bs-toggle="offcanvas" data-bs-target="#demo_config">
				<i class="ph-sun"></i>
			</button>
		</div>

		{{-- <div class="py-0 offcanvas-header border-bottom">
			<h5 class="py-3 offcanvas-title">Demo configuration</h5>
			<button type="button" class="border-transparent btn btn-light btn-sm btn-icon rounded-pill" data-bs-dismiss="offcanvas">
				<i class="ph-x"></i>
			</button>
		</div> --}}

		<div class="offcanvas-body">
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
						<input type="radio" class="cursor-pointer form-check-input ms-auto" name="main-theme" value="light" checked>
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
						<input type="radio" class="cursor-pointer form-check-input ms-auto" name="main-theme" value="dark">
					</div>
				</label>
			</div>
		</div>
	</div>
	<!-- /demo config -->
   
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
       
	</script>
    </div>
    </div>
</body>

</html>
