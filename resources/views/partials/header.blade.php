@php
    $newNotifications = App\Models\Notification::where('user_id',auth()->user()->id)->where('is_read', false)->orderBy('created_at', 'desc')->get();
    $unreadNotificationsCount = $newNotifications->count();
    $oldNotifications = App\Models\Notification::where('user_id',auth()->user()->id)->where('is_read', true)->orderBy('created_at', 'desc')->take(3)->get();
@endphp
<!-- Main navbar -->
<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="flex-1 navbar-brand flex-lg-0">
            <a href="#" class="d-inline-flex align-items-center">
                <img src="{{ asset('/assets/images/logo_icon.png') }}" class="d-sm-inline-block h-40px ms-3">
                {{-- <img src="../../../assets/images/logo_icon.svg" class="d-none d-sm-inline-block h-40px ms-3"
                    alt=""> --}}
                <h5 class="d-none d-sm-inline-block h-16px ms-3" style="color: white">MO SPA</h5>
            </a>
        </div>

        <ul class="flex-row order-1 nav justify-content-end order-lg-2">
            <li class="nav-item ms-lg-2">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="offcanvas"
                    data-bs-target="#notifications">
                    <i class="ph-bell"></i>
                    <span
                        class="top-0 mt-1 text-black badge bg-primary position-absolute end-0 translate-middle-top zindex-1 rounded-pill me-1">{{ $unreadNotificationsCount }}</span>
                </a>
            </li>
            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a href="#" class="p-1 navbar-nav-link align-items-Bcenter" data-bs-toggle="dropdown">
                    <div class="">
                        <img src="{{ asset('/assets/images/logo_icon.png') }}" class="w-32px h-32px rounded-pill"
                            alt="">
                        {{-- <span class="status-indicator bg-success"></span> --}}
                    </div>
                    <span class="d-none d-lg-inline-block mx-lg-2">{{ Auth::user()->name }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{ route('setting.index') }}" class="dropdown-item">
                        <i class="ph-gear me-2"></i>
                        {{ 'Setting' }}
                    </a>
                    <form action="{{ route('logout', Auth::user()->id) }}" method="POST">
                        @csrf
                        <button class="dropdown-item" type="submit">
                            <i class="ph-sign-out me-2"></i>
                            {{ 'Logout' }}
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="notifications">
    <div class="py-0 offcanvas-header">
        <h5 class="py-3 offcanvas-title">Notifications</h5>
        <button type="button" class="border-transparent btn btn-light btn-sm btn-icon rounded-pill"
            data-bs-dismiss="offcanvas">
            <i class="ph-x"></i>
        </button>
    </div>

    <div class="p-0 offcanvas-body">
        <!-- New Notifications Header -->
        <div class="px-3 py-2 d-flex justify-content-between align-items-center bg-light fw-medium">
            <span>New Notifications</span>
            @if ($newNotifications->isNotEmpty())
                <button class="btn btn-sm btn-primary" id="markAllRead">Mark All as Read</button>
            @endif
        </div>
    
        <!-- New Notifications List -->
        <div class="p-3">
            @if ($newNotifications->isNotEmpty())
                @foreach ($newNotifications as $notification)
                    <div class="pb-2 mb-3 d-flex align-items-start border-bottom">
                        <div class="flex-fill">
                            <span class="fw-semibold">{{ $notification->title }}</span><br>
                            {{ $notification->message }}
                            <div class="mt-1 fs-sm text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center text-muted">
                    <i class="ph-x-circle fs-2"></i> <!-- Improved "No Notifications" Icon -->
                    <p class="mt-2">No new notifications</p>
                </div>
            @endif
        </div>
    
        <!-- Old Notifications Header -->
        <div class="px-3 py-2 bg-light fw-medium">Old Notifications</div>
    
        <!-- Old Notifications List -->
        <div class="p-3">
            @if ($oldNotifications->isNotEmpty())
                @foreach ($oldNotifications as $notification)
                    <div class="pb-2 mb-3 d-flex align-items-start border-bottom">
                        <div class="flex-fill">
                            <span class="fw-semibold">{{ $notification->title }}</span><br>
                            {{ $notification->message }}
                            <div class="mt-1 fs-sm text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center text-muted">
                    <i class="ph-x-circle fs-2"></i> <!-- Improved "No Notifications" Icon -->
                    <p class="mt-2">No old notifications</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- JavaScript for Mark All as Read -->
    <script>
        document.getElementById('markAllRead')?.addEventListener('click', function() {
            fetch("{{ route('notifications.markAllRead') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
        });
    </script>
    
</div>
