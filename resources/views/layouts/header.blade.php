@auth
    @php
        $user = Auth::user();
        $id = $user->id;
        $role = $user->role;
    @endphp

    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="{{ url('/dashboard') }}" class="logo logo-dark mt-3">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/pr_2.jpg') }}" alt="Logo" height="48" width="48"
                                class="rounded-circle object-fit-cover">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/pr_2.jpg') }}" alt="Logo" height="72" width="72"
                                class="rounded-circle object-fit-cover">
                        </span>
                    </a>

                    <a href="{{ url('/dashboard') }}" class="logo logo-light mt-3">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/pr_2.jpg') }}" alt="Logo" height="48" width="48"
                                class="rounded-circle object-fit-cover">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/pr_2.jpg') }}" alt="Logo" height="72" width="72"
                                class="rounded-circle object-fit-cover">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
            </div>

            <div class="d-flex align-items-center">
                <!-- Notifications -->
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bx bx-bell bx-tada"></i>
                        <span class="badge bg-danger rounded-pill">1</span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0" key="t-notifications">Notifications</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Profile Dropdown -->
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ $role }}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item text-primary" href="{{ url('profile') }}">
                            <i class="bx bx-user font-size-17 align-middle me-1 text-danger"></i>
                            <span key="t-profile">Profile</span>
                        </a>

                        <div class="dropdown-divider"></div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-primary"
                                style="background: none; border: none;">
                                <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                                <span key="t-logout">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Theme Settings -->
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                        <i class="bx bx-palette bx-spin"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Modal for Change Password -->
    <div class="modal fade change-password" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ url('changePassword') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">

                        <div class="mb-3 row">
                            <label for="oldpassword" class="col-sm-3 col-form-label">Old Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="oldpassword" name="oldpassword"
                                    required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="newpassword" class="col-sm-3 col-form-label">New Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="newpassword" name="newpassword"
                                    required>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endauth
