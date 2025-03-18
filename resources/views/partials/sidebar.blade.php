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


                @if (Auth::user()->can('show_order') ||
                        Auth::user()->can('show_expense_type') ||
                        Auth::user()->can('show_expense'))
                    <li class="pt-0 nav-item-header">
                        <div class="opacity-50 text-uppercase fs-sm lh-sm sidebar-resize-hide">
                            {{ 'Orders' }}</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    @can('show_order')
                        <li class="nav-item">
                            <a href="{{ route('order') }}"
                                class="nav-link  {{ Route::currentRouteNamed('order') || Route::currentRouteNamed('order.detail') || Route::currentRouteNamed('order.create')
                                 || Route::currentRouteNamed('order.edit')|| Route::currentRouteNamed('order.expense.create') || Route::currentRouteNamed('order.expense.edit')
                                 || Route::currentRouteNamed('paymentCollection.create') || Route::currentRouteNamed('paymentCollection.edit') ? 'active' : '' }}">
                                <i class="ph-scroll"></i>
                                <span>
                                    Order
                                </span>
                            </a>
                        </li>
                    @endcan
                    
                    @can('show_expense_type')
                        <li class="nav-item">
                            <a href="{{route('expenseType')}}" class="nav-link {{ Route::currentRouteNamed('expenseType') || Route::currentRouteNamed('expenseType.create') || Route::currentRouteNamed('expenseType.edit') ? 'active' : '' }}">
                                <i class="ph-receipt"></i>
                                <span>
                                    {{ 'Expense Type' }}
                                </span>
                            </a>
                        </li>
                    @endcan 
                    @can('show_expense')
                        <li class="nav-item">
                            <a href="{{route('expense')}}" class="nav-link {{ Route::currentRouteNamed('expense') || Route::currentRouteNamed('expense.create') || Route::currentRouteNamed('expense.edit') ? 'active' : '' }}">
                                <i class="ph-currency-circle-dollar"></i>
                                <span>
                                    {{ 'Expenses' }}
                                </span>
                            </a>
                        </li>
                    @endcan
                @endif
                @if (Auth::user()->can('show_vehicles') ||
                        Auth::user()->can('show_driver') ||
                        Auth::user()->can('show_location') ||
                        Auth::user()->can('show_load_type') ||
                        Auth::user()->can('show_bank'))
                    <li class="pt-0 nav-item-header">
                        <div class="opacity-50 text-uppercase fs-sm lh-sm sidebar-resize-hide">
                            {{ 'Setting' }}</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>

                    @can('show_vehicles')
                        <li class="nav-item">
                            <a href="{{ route('vehicle') }}"
                                class="nav-link {{ Route::currentRouteNamed('vehicle') || Route::currentRouteNamed('vehicle.create') || Route::currentRouteNamed('vehicle.edit') ? 'active' : '' }}">
                                <i class="ph-truck"></i>
                                <span>
                                    Vehicles
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('show_drivers')
                        <li class="nav-item">
                            <a href="{{ route('driver') }}"
                                class="nav-link {{ Route::currentRouteNamed('driver') || Route::currentRouteNamed('driver.create') || Route::currentRouteNamed('driver.edit') ? 'active' : '' }}">
                                <i class="ph-users-three"></i>
                                <span>
                                    Employees
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('show_location')
                        <li class="nav-item">
                            <a href="{{ route('location') }}"
                                class="nav-link {{ Route::currentRouteNamed('location') || Route::currentRouteNamed('location.create') || Route::currentRouteNamed('location.edit') ? 'active' : '' }}">
                                <i class="ph-map-pin-line"></i>
                                <span>
                                    {{ 'Location' }}
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('show_load_type')
                        <li class="nav-item">
                            <a href="{{ route('loadType') }}"
                                class="nav-link {{ Route::currentRouteNamed('loadType') || Route::currentRouteNamed('loadType.create') || Route::currentRouteNamed('loadType.edit') ? 'active' : '' }}">
                                <i class="ph-chart-bar-horizontal"></i>
                                <span>
                                    {{ 'Load Type' }}
                                </span>
                            </a>
                        </li>
                    @endcan

                    @can('show_bank')
                        <li class="nav-item">
                            <a href="{{ route('bank') }}"
                                class="nav-link {{ Route::currentRouteNamed('bank') || Route::currentRouteNamed('bank.create') || Route::currentRouteNamed('bank.edit') ? 'active' : '' }}">
                                <i class="ph-bank"></i>
                                <span>
                                    Bank
                                </span>
                            </a>
                        </li>
                    @endcan
                @endif
                @if (Auth::user()->can('show_staff_user') || Auth::user()->can('show_role') || Auth::user()->can('show_client'))
                    <li class="pt-0 nav-item-header">
                        <div class="opacity-50 text-uppercase fs-sm lh-sm sidebar-resize-hide">
                            {{ 'User Management' }}</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    @can('show_client')
                        <li class="nav-item">
                            <a href="{{ route('client') }}"
                                class="nav-link {{ Route::currentRouteNamed('client') || Route::currentRouteNamed('client.create') || Route::currentRouteNamed('client.edit') ? 'active' : '' }}">
                                <i class="ph-handshake"></i>
                                <span>
                                    {{ 'Clients' }}
                                </span>
                            </a>
                        </li>
                    @endcan
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
                @can('show_report')
                    <li class="pt-0 nav-item-header">
                        <div class="opacity-50 text-uppercase fs-sm lh-sm sidebar-resize-hide">
                            {{ 'Report' }}</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    <li class="nav-item nav-item-submenu {{ Route::is('report*', 'report.client*', 'report.vehicle*','report.expenseType*','report.loadType*','report.location*','ownVsprivate*') ? 'nav-item-open' : '' }}">
                        {{-- nav-item nav-item-submenu  nav-item-open --}}
                        <a href="#" class="nav-link">
                            <i class="ph-chart-bar"></i>
                            <span>Report</span>
                        </a>
                        <ul class="nav-group-sub {{ Route::is('report*', 'report.client*', 'report.vehicle*','report.expenseType*','report.loadType*','report.location*','ownVsprivate*') ? 'show' : 'collapse' }}">
                            <li class="nav-item">
                                <a href="{{ route('report') }}"
                                    class="nav-link {{ Route::currentRouteNamed('report') || Route::currentRouteNamed('report.show') ? 'active' : '' }}">
                                    <i class="ph-file-text"></i>
                                    <span>
                                        {{ 'Report' }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('ownVsprivate') }}"
                                    class="nav-link {{ Route::currentRouteNamed('ownVsprivate') || Route::currentRouteNamed('ownVsprivate.show') ? 'active' : '' }}">
                                    <i class="ph-file-text"></i>
                                    <span>
                                        {{ 'Own Vs Private' }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.location') }}"
                                    class="nav-link {{ Route::currentRouteNamed('report.location') || Route::currentRouteNamed('report.location.show') ? 'active' : '' }}">
                                    <i class="ph-file-text"></i>
                                    <span>
                                        {{ 'Location' }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.loadingType') }}"
                                    class="nav-link {{ Route::currentRouteNamed('report.loadingType') || Route::currentRouteNamed('report.loadingType.show') ? 'active' : '' }}">
                                    <i class="ph-file-text"></i>
                                    <span>
                                        {{ 'Load Type' }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.client') }}"
                                    class="nav-link {{ Route::currentRouteNamed('report.client') || Route::currentRouteNamed('report.client.show') ? 'active' : '' }}">
                                    <i class="ph-file-text"></i>
                                    <span>
                                        {{ 'Client' }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.expenseType') }}"
                                    class="nav-link {{ Route::currentRouteNamed('report.expenseType') || Route::currentRouteNamed('report.expenseType.show') ? 'active' : '' }}">
                                    <i class="ph-file-text"></i>
                                    <span>
                                        {{ 'Expense Type' }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.vehicle') }}"
                                    class="nav-link {{ Route::currentRouteNamed('report.vehicle') || Route::currentRouteNamed('report.vehicle.show') ? 'active' : '' }}">
                                    <i class="ph-file-text"></i>
                                    <span>
                                        {{ 'Vehicle' }}
                                    </span>
                                </a>
                            </li>
                         </ul>
                    </li>
                     
                @endcan
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
