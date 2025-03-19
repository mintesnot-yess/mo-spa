<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="my-auto sidebar-resize-hide flex-grow-1"></h5>

                <div>
                    <button type="button"
                        class="border-transparent btn btn-flat-white btn-icon btn-sm rounded-pill sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button"
                        class="border-transparent btn btn-flat-white btn-icon btn-sm rounded-pill sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- /sidebar header -->


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="pt-0 nav-item-header">
                    <div class="opacity-50 text-uppercase fs-sm lh-sm sidebar-resize-hide">{{ 'General' }}
                    </div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link  {{ Route::currentRouteNamed('dashboard') ? 'active' : '' }}">
                        <i class="ph-house"></i>
                        <span>
                            {{ 'Dashboard' }}

                        </span>
                    </a>
                </li>
                @can('show_report')
                    <li class="pt-0 nav-item-header">
                        <div class="opacity-50 text-uppercase fs-sm lh-sm sidebar-resize-hide">
                            {{ 'Trensaction' }}</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    <li
                        class="nav-item nav-item-submenu {{ Route::is('report*', 'report.client*', 'report.vehicle*', 'report.expenseType*', 'report.loadType*', 'report.location*', 'ownVsprivate*') ? 'nav-item-open' : '' }}">
                        {{-- nav-item nav-item-submenu  nav-item-open --}}
                        <a href="#" class="nav-link">
                            <i class="ph-chart-bar"></i>
                            <span>Trensaction</span>
                        </a>
                        <ul
                            class="nav-group-sub {{ Route::is('report*', 'report.client*', 'report.vehicle*', 'report.expenseType*', 'report.loadType*', 'report.location*', 'ownVsprivate*') ? 'show' : 'collapse' }}">
                            <li class="nav-item">
                                <a href="{{ route('report') }}"
                                    class="nav-link {{ Route::currentRouteNamed('report') || Route::currentRouteNamed('report.show') ? 'active' : '' }}">
                                    <i class="ph-file-text text-yellow"></i>
                                    <span>
                                        {{ 'Pending' }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('ownVsprivate') }}"
                                    class="nav-link {{ Route::currentRouteNamed('ownVsprivate') || Route::currentRouteNamed('ownVsprivate.show') ? 'active' : '' }}">
                                    <i class="ph-file-text text-success"></i>
                                    <span>
                                        {{ 'Completed' }}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @if (Auth::user()->can('show_employee') || Auth::user()->can('show_customer')|| Auth::user()->can('show_service')|| Auth::user()->can('show_category'))
                    <li class="pt-0 nav-item-header">
                        <div class="opacity-50 text-uppercase fs-sm lh-sm sidebar-resize-hide">
                            {{ 'Registration' }}</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    <li
                        class="nav-item nav-item-submenu {{ Route::is('employee*', 'client*', 'service*', 'category*') ? 'nav-item-open' : '' }}">
                        {{-- nav-item nav-item-submenu  nav-item-open --}}
                        <a href="#" class="nav-link">
                            <i class="ph-scroll"></i>
                            <span>Registration</span>
                        </a>
                        <ul
                            class="nav-group-sub {{ Route::is('employee*', 'client*', 'service*', 'category*') ? 'show' : 'collapse' }}">
                            @can('show_employee')
                            <li class="nav-item">
                                <a href="{{ route('employee') }}"
                                    class="nav-link {{ Route::is('employee*') ? 'active' : '' }}">
                                    <i class="ph-users-three"></i>
                                    <span>
                                        {{ 'Employee' }}
                                    </span>
                                </a>
                            </li>
                            @endcan
                            @can('show_customer')
                            <li class="nav-item">
                                <a href="{{ route('client') }}"
                                    class="nav-link {{ Route::is('client*') ? 'active' : '' }}">
                                    <i class="ph-handshake"></i>
                                    <span>
                                        {{ 'Customer' }}
                                    </span>
                                </a>
                            </li>
                            @endcan
                            @can('show_service')
                            <li class="nav-item">
                                <a href="{{ route('service') }}"
                                    class="nav-link {{ Route::is('service*') ? 'active' : '' }}">
                                    <i class="ph-stack"></i>
                                    <span>
                                        {{ 'Service' }}
                                    </span>
                                </a>
                            </li>
                            @endcan
                            @can('show_category')
                            <li class="nav-item">
                                <a href="{{ route('category') }}"
                                    class="nav-link {{ Route::is('category*') ? 'active' : '' }}">
                                    <i class="ph-chart-bar-horizontal"></i>
                                    <span>
                                        {{ 'Category' }}
                                    </span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @can('show_report')
                    <li class="pt-0 nav-item-header">
                        <div class="opacity-50 text-uppercase fs-sm lh-sm sidebar-resize-hide">
                            {{ 'Report' }}</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    <li
                        class="nav-item nav-item-submenu {{ Route::is('report*', 'report.client*', 'report.vehicle*', 'report.expenseType*', 'report.loadType*', 'report.location*', 'ownVsprivate*') ? 'nav-item-open' : '' }}">
                        {{-- nav-item nav-item-submenu  nav-item-open --}}
                        <a href="#" class="nav-link">
                            <i class="ph-chart-line-up"></i>
                            <span>Report</span>
                        </a>
                        <ul
                            class="nav-group-sub {{ Route::is('report*', 'report.client*', 'report.vehicle*', 'report.expenseType*', 'report.loadType*', 'report.location*', 'ownVsprivate*') ? 'show' : 'collapse' }}">
                            <li class="nav-item">
                                <a href="{{ route('report') }}"
                                    class="nav-link {{ Route::currentRouteNamed('report') || Route::currentRouteNamed('report.show') ? 'active' : '' }}">
                                    <i class="ph-file-text"></i>
                                    <span>
                                        {{ 'Transaction Report' }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report') }}"
                                    class="nav-link {{ Route::currentRouteNamed('report') || Route::currentRouteNamed('report.show') ? 'active' : '' }}">
                                    <i class="ph-file-text"></i>
                                    <span>
                                        {{ 'Transaction By Service' }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('ownVsprivate') }}"
                                    class="nav-link {{ Route::currentRouteNamed('ownVsprivate') || Route::currentRouteNamed('ownVsprivate.show') ? 'active' : '' }}">
                                    <i class="ph-file-text"></i>
                                    <span>
                                        {{ 'Transaction By Employee' }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.location') }}"
                                    class="nav-link {{ Route::currentRouteNamed('report.location') || Route::currentRouteNamed('report.location.show') ? 'active' : '' }}">
                                    <i class="ph-file-text"></i>
                                    <span>
                                        {{ 'Transaction By Customer' }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.loadingType') }}"
                                    class="nav-link {{ Route::currentRouteNamed('report.loadingType') || Route::currentRouteNamed('report.loadingType.show') ? 'active' : '' }}">
                                    <i class="ph-file-text"></i>
                                    <span>
                                        {{ 'Transaction By Customer Type' }}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @if (Auth::user()->can('show_staff_user') || Auth::user()->can('show_role'))
                    <li class="pt-0 nav-item-header">
                        <div class="opacity-50 text-uppercase fs-sm lh-sm sidebar-resize-hide">
                            {{ 'User Management' }}</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>

                    @can('show_staff_user')
                        <li class="nav-item">
                            <a href="{{ route('staff.index') }}"
                                class="nav-link {{ Route::currentRouteNamed('staff.index') || Route::currentRouteNamed('staff.create') || Route::currentRouteNamed('staff.edit') ? 'active' : '' }}">
                                <i class="ph-user-circle-plus"></i>
                                <span>
                                    {{ 'System User' }}
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('show_role')
                        <li class="nav-item">
                            <a href="{{ route('rolepermission') }}"
                                class="nav-link {{ Route::currentRouteNamed('rolepermission') || Route::currentRouteNamed('assignPermission') || Route::currentRouteNamed('role.create') || Route::currentRouteNamed('role.edit') ? 'active' : '' }}">
                                <i class="ph-user-list"></i>
                                <span>
                                    {{ 'Role And Permission' }}
                                </span>
                            </a>
                        </li>
                    @endcan
                @endif

            </ul>
            <br>
            <br>
            <br>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
