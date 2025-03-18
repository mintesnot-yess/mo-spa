<!-- Footer -->
<div class="navbar navbar-sm navbar-footer border-top">
    <div class="container-fluid">
        <span>&copy; {{\Carbon\Carbon::now()->format('Y')}}  MO-SPA</span>

       
    </div>
</div>
<!-- /footer -->
{{-- \Carbon\Carbon::parse($service->created_at)->format('M-d-Y') --}}
<!-- Core JS files -->
<script src="{{ asset('assets/demo/demo_configurator.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script src="{{ asset('assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>

<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/demo/pages/dashboard.js') }}"></script>
<script src="{{ asset('assets/demo/charts/pages/dashboard/streamgraph.js') }}"></script>
<script src="{{ asset('assets/demo/charts/pages/dashboard/sparklines.js') }}"></script>
<script src="{{ asset('assets/demo/charts/pages/dashboard/lines.js') }}"></script>
<script src="{{ asset('assets/demo/charts/pages/dashboard/areas.js') }}"></script>
<script src="{{ asset('assets/demo/charts/pages/dashboard/donuts.js') }}"></script>
<script src="{{ asset('assets/demo/charts/pages/dashboard/bars.js') }}"></script>
<script src="{{ asset('assets/demo/charts/pages/dashboard/progress.js') }}"></script>
<script src="{{ asset('assets/demo/charts/pages/dashboard/heatmaps.js') }}"></script>
<script src="{{ asset('assets/demo/charts/pages/dashboard/pies.js') }}"></script>
<script src="{{ asset('assets/demo/charts/pages/dashboard/bullets.js') }}"></script>
@stack('js')
<!-- /theme JS files -->
