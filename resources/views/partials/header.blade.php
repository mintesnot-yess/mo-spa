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
                        class="top-0 mt-1 text-black badge bg-yellow position-absolute end-0 translate-middle-top zindex-1 rounded-pill me-1">2</span>
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
        <h5 class="py-3 offcanvas-title">Activity</h5>
        <button type="button" class="border-transparent btn btn-light btn-sm btn-icon rounded-pill" data-bs-dismiss="offcanvas">
            <i class="ph-x"></i>
        </button>
    </div>

    <div class="p-0 offcanvas-body">
        <div class="px-3 py-2 bg-light fw-medium">New notifications</div>
        <div class="p-3">
            <div class="mb-3 d-flex align-items-start">
                <a href="#" class="status-indicator-container me-3">
                    <img src="../../../assets/images/demo/users/face1.jpg" class="w-40px h-40px rounded-pill" alt="">
                    <span class="status-indicator bg-success"></span>
                </a>
                <div class="flex-fill">
                    <a href="#" class="fw-semibold">James</a> has completed the task <a href="#">Submit documents</a> from <a href="#">Onboarding</a> list

                    <div class="p-2 my-2 rounded bg-light">
                        <label class="form-check ms-1">
                            <input type="checkbox" class="form-check-input" checked disabled>
                            <del class="form-check-label">Submit personal documents</del>
                        </label>
                    </div>

                    <div class="mt-1 fs-sm text-muted">2 hours ago</div>
                </div>
            </div>

            <div class="mb-3 d-flex align-items-start">
                <a href="#" class="status-indicator-container me-3">
                    <img src="../../../assets/images/demo/users/face3.jpg" class="w-40px h-40px rounded-pill" alt="">
                    <span class="status-indicator bg-warning"></span>
                </a>
                <div class="flex-fill">
                    <a href="#" class="fw-semibold">Margo</a> has added 4 users to <span class="fw-semibold">Customer enablement</span> channel

                    <div class="my-2 d-flex">
                        <a href="#" class="status-indicator-container me-1">
                            <img src="../../../assets/images/demo/users/face10.jpg" class="w-32px h-32px rounded-pill" alt="">
                            <span class="status-indicator bg-danger"></span>
                        </a>
                        <a href="#" class="status-indicator-container me-1">
                            <img src="../../../assets/images/demo/users/face11.jpg" class="w-32px h-32px rounded-pill" alt="">
                            <span class="status-indicator bg-success"></span>
                        </a>
                        <a href="#" class="status-indicator-container me-1">
                            <img src="../../../assets/images/demo/users/face12.jpg" class="w-32px h-32px rounded-pill" alt="">
                            <span class="status-indicator bg-success"></span>
                        </a>
                        <a href="#" class="status-indicator-container me-1">
                            <img src="../../../assets/images/demo/users/face13.jpg" class="w-32px h-32px rounded-pill" alt="">
                            <span class="status-indicator bg-success"></span>
                        </a>
                        <button type="button" class="p-0 btn btn-light btn-icon d-inline-flex align-items-center justify-content-center w-32px h-32px rounded-pill">
                            <i class="ph-plus ph-sm"></i>
                        </button>
                    </div>

                    <div class="mt-1 fs-sm text-muted">3 hours ago</div>
                </div>
            </div>

            <div class="d-flex align-items-start">
                <div class="me-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-pill">
                        <i class="p-2 ph-warning"></i>
                    </div>
                </div>
                <div class="flex-1">
                    Subscription <a href="#">#466573</a> from 10.12.2021 has been cancelled. Refund case <a href="#">#4492</a> created
                    <div class="mt-1 fs-sm text-muted">4 hours ago</div>
                </div>
            </div>
        </div>

        <div class="px-3 py-2 bg-light fw-medium">Older notifications</div>
        <div class="p-3">
            <div class="mb-3 d-flex align-items-start">
                <a href="#" class="status-indicator-container me-3">
                    <img src="../../../assets/images/demo/users/face25.jpg" class="w-40px h-40px rounded-pill" alt="">
                    <span class="status-indicator bg-success"></span>
                </a>
                <div class="flex-fill">
                    <a href="#" class="fw-semibold">Nick</a> requested your feedback and approval in support request <a href="#">#458</a>

                    <div class="my-2">
                        <a href="#" class="btn btn-success btn-sm me-1">
                            <i class="ph-checks ph-sm me-1"></i>
                            Approve
                        </a>
                        <a href="#" class="btn btn-light btn-sm">
                            Review
                        </a>
                    </div>

                    <div class="mt-1 fs-sm text-muted">3 days ago</div>
                </div>
            </div>

            <div class="mb-3 d-flex align-items-start">
                <a href="#" class="status-indicator-container me-3">
                    <img src="../../../assets/images/demo/users/face24.jpg" class="w-40px h-40px rounded-pill" alt="">
                    <span class="status-indicator bg-grey"></span>
                </a>
                <div class="flex-fill">
                    <a href="#" class="fw-semibold">Mike</a> added 1 new file(s) to <a href="#">Product management</a> project

                    <div class="p-2 my-2 rounded bg-light">
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <img src="../../../assets/images/icons/pdf.svg" width="34" height="34" alt="">
                            </div>
                            <div class="flex-fill">
                                new_contract.pdf
                                <div class="fs-sm text-muted">112KB</div>
                            </div>
                            <div class="ms-2">
                                <button type="button" class="border-transparent btn btn-flat-dark text-body btn-icon btn-sm rounded-pill">
                                    <i class="ph-arrow-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-1 fs-sm text-muted">1 day ago</div>
                </div>
            </div>

            <div class="mb-3 d-flex align-items-start">
                <div class="me-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-pill">
                        <i class="p-2 ph-calendar-plus"></i>
                    </div>
                </div>
                <div class="flex-fill">
                    All hands meeting will take place coming Thursday at 13:45.

                    <div class="my-2">
                        <a href="#" class="btn btn-primary btn-sm">
                            <i class="ph-calendar-plus ph-sm me-1"></i>
                            Add to calendar
                        </a>
                    </div>

                    <div class="mt-1 fs-sm text-muted">2 days ago</div>
                </div>
            </div>

            <div class="mb-3 d-flex align-items-start">
                <a href="#" class="status-indicator-container me-3">
                    <img src="../../../assets/images/demo/users/face4.jpg" class="w-40px h-40px rounded-pill" alt="">
                    <span class="status-indicator bg-danger"></span>
                </a>
                <div class="flex-fill">
                    <a href="#" class="fw-semibold">Christine</a> commented on your community <a href="#">post</a> from 10.12.2021

                    <div class="mt-1 fs-sm text-muted">2 days ago</div>
                </div>
            </div>

            <div class="mb-3 d-flex align-items-start">
                <div class="me-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-pill">
                        <i class="p-2 ph-users-four"></i>
                    </div>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold">HR department</span> requested you to complete internal survey by Friday

                    <div class="mt-1 fs-sm text-muted">3 days ago</div>
                </div>
            </div>

            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>