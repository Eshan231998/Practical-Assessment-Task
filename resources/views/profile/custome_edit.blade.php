@php
    $user = Auth::user();
    $id = $user?->id;
    $role = $user?->role;
@endphp

@if (!empty($id))
    @if (\Illuminate\Support\Facades\Auth::id() == $id)
        <!doctype html>
        <html lang="en">

        <head>
            @include('Layouts.appStyles')
        </head>

        <style>
            .profile-card {
                transition: box-shadow 0.3s;
            }

            .profile-card:hover {
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            }

            .card-header h4 {
                font-weight: 600;
                letter-spacing: 1px;
            }
        </style>

        <body data-sidebar="dark">

            <!-- Begin page -->
            <div id="layout-wrapper">


                {{--    Header --}}
                @include('Layouts.header')

                {{--    End Header --}}

                <!-- Left Sidebar Start  -->
                @include('Layouts.sidebar')
                <!-- Left Sidebar End -->



                <!-- ============================================================== -->
                <!-- Start right Content here -->
                <!-- ============================================================== -->
                <div class="main-content">

                    <div class="page-content">
                        <div class="container-fluid">

                            <!-- start page title -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h4 class="mb-sm-0 font-size-18">Profile</h4>

                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a>
                                                </li>
                                                <li class="breadcrumb-item active">Edit</li>
                                            </ol>
                                        </div>
                                    </div>

                                    @foreach ($errors->all() as $error)
                                        <div class="col-md-4">
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ $error }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if (session()->has('message'))
                                        <div class="col-md-4">
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session()->get('message') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                            <!-- end page title -->

                            <!-- Profile Card -->
                            <div class="row justify-content-center mt-5 mb-5">
                                <div class="col-md-10 col-lg-8">
                                    <div class="card mb-4 shadow-lg border-0 rounded-4 bg-light profile-card w-100">
                                        <div class="card-body p-5 d-flex flex-column align-items-center">
                                            <img src="{{ URL::asset('/assets/images/users/user.png') }}" alt="" class="avatar-md rounded-circle img-thumbnail mb-3">
                                            <h5 class="font-size-20 text-truncate mb-1">{{ \Illuminate\Support\Facades\Auth::user()->name }}</h5>
                                            <p class="text-muted mb-0 text-truncate">{{ \Illuminate\Support\Facades\Auth::user()->role }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Profile Form -->
                            <div class="row justify-content-center mt-5 mb-5">
                                <div class="col-md-10 col-lg-8">
                                    <div class="d-flex flex-column gap-4 w-100">
                                        <div class="card mb-0 shadow-lg border-0 rounded-4 bg-light profile-card w-100">
                                            <div class="card-header bg-primary text-white rounded-top-4 py-3 px-4">
                                                <h4 class="mb-0">Edit Profile</h4>
                                            </div>
                                            <div class="card-body p-5">
                                                @include('profile.partials.update-profile-information-form')
                                            </div>
                                        </div>
                                        <div class="card mb-0 shadow-lg border-0 rounded-4 bg-light profile-card w-100">
                                            <div class="card-header bg-secondary text-white rounded-top-4 py-3 px-4">
                                                <h4 class="mb-0">Change Password</h4>
                                            </div>
                                            <div class="card-body p-5">
                                                @include('profile.partials.update-password-form')
                                            </div>
                                        </div>
                                        @if (Auth::user()->role === 'Admin')
                                            <div class="card mb-0 shadow-lg border-0 rounded-4 bg-light profile-card w-100">
                                                <div class="card-header bg-danger text-white rounded-top-4 py-3 px-4">
                                                    <h4 class="mb-0">Delete Account</h4>
                                                </div>
                                                <div class="card-body p-5">
                                                    @include('profile.partials.delete-user-form')
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- container-fluid -->
                    </div>
                    <!-- End Page-content -->


                    {{--        Footer --}}
                    @include('Layouts.footer')
                    {{--        End Footer --}}
                </div>
                <!-- end main content-->

            </div>
            <!-- END layout-wrapper -->

            <!-- Right Sidebar -->
            @include('Layouts.rightSideBar')
            <!-- /Right-bar -->

            <!-- Right bar overlay-->
            <div class="rightbar-overlay"></div>

            @include('Layouts.appJs')
        </body>

        </html>
    @else
        @include('Layouts.notValidateUser')
    @endif
@else
    @include('Layouts.notValidateUser')
@endif
