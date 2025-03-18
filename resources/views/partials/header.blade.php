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
                <img src="{{asset('/assets/images/logo_icon.png')}}" class="d-sm-inline-block h-40px ms-3">
                {{-- <img src="../../../assets/images/logo_icon.svg" class="d-none d-sm-inline-block h-40px ms-3"
                    alt=""> --}}
                    <h5 class="d-none d-sm-inline-block h-16px ms-3" style="color: white">MO SPA</h5>
            </a>
        </div>


            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a href="#" class="p-1 navbar-nav-link align-items-Bcenter" data-bs-toggle="dropdown">
                    <div class="">
                        <img src="{{asset('/assets/images/logo_icon.png')}}" class="w-32px h-32px rounded-pill"
                            alt="">
                        {{-- <span class="status-indicator bg-success"></span> --}}
                    </div>
                    <span class="d-none d-lg-inline-block mx-lg-2">{{Auth::user()->name}}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{route('setting.index')}}" class="dropdown-item">
                        <i class="ph-gear me-2"></i>
                         {{'Setting'}}
                    </a> 
                    <form action="{{route('logout', Auth::user()->id)}}" method="POST">
                        @csrf
                    <button class="dropdown-item" type="submit">
                        <i class="ph-sign-out me-2"></i>
                        {{'Logout'}}
                    </button>
                </form>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->
