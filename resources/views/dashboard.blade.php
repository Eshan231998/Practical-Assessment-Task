@php
    $user = Auth::user();
    $user_id = $user?->id;
    $role = $user?->role;
@endphp

@if (!empty($user_id))
    @if (\Illuminate\Support\Facades\Auth::id() == $user_id)
        <!doctype html>
        <html lang="en">
        <!-- head -->

        <head>
            @include('layouts.appStyles')
            <style>
                #timecard {
                    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
                }
            </style>
        </head>

        <!-- body -->

        <body data-sidebar="dark">
            <!-- Begin page -->
            <div id="layout-wrapper">
                {{--    Header --}}
                @include('layouts.header')
                {{--    End Header --}}

                <!-- Left Sidebar Start  -->
                @include('layouts.sidebar')
                <!-- Left Sidebar End -->


                <!-- ============================================================== -->
                <!-- Start right Content here -->
                <!-- ============================================================== -->
                <div class="main-content">
                    <div class="page-content">
                        <div class="container-fluid">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a>
                                            </li>
                                            <li class="breadcrumb-item active">Dashboards</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>

                            <!-- start page title -->
                            <div class="row g-4 mb-4">
                                <!-- Admin/User & Time Section on Top -->
                                <div class="col-12">
                                    <div class="row g-4">
                                        <!-- User Card & Greeting -->
                                        <div class="col-lg-4">
                                            <div class="card border-0 shadow h-100 text-center gradient-card"
                                                style="background: linear-gradient(135deg, #f8fafc 60%, #e3e6ec 100%);">
                                                <div
                                                    class="card-body d-flex flex-column align-items-center justify-content-center">
                                                    <img src="{{ URL::asset('/assets/images/users/user.png') }}"
                                                        alt=""
                                                        class="avatar-xl rounded-circle img-thumbnail mb-3 shadow">
                                                    <h5 class="fw-bold mb-1">
                                                        {{ \Illuminate\Support\Facades\Auth::user()->name }}</h5>
                                                    <span
                                                        class="badge bg-info mb-2">{{ \Illuminate\Support\Facades\Auth::user()->role }}</span>
                                                    <p class="mb-2 mt-2 fs-5" id="greetings"></p>
                                                    <a href="{{ url('profile') }}"
                                                        class="btn btn-outline-primary btn-sm mt-2"><i
                                                            class="bx bx-user"></i> Edit Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Welcome/Time Card -->
                                        <div class="col-lg-8">
                                            <div class="row g-4">
                                                <div class="col-12">
                                                    <div class="card bg-info bg-soft border-0 shadow h-100"
                                                        id="timecard">
                                                        <div
                                                            class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between">
                                                            <div class="text-primary p-3">
                                                                <h5 style="color: rgb(20, 21, 21)" class="mb-3">
                                                                    Welcome Back!</h5>
                                                                <h3><span id="time"></span></h3>
                                                            </div>
                                                            <img src="{{ URL::asset('/assets/images/profile-img.png') }}"
                                                                alt="" class="img-fluid"
                                                                style="max-width:120px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Analytics Row - Advanced Look -->
                            <div class="row g-4 mb-4">
                                <!-- First row: Total Registered & Age Group -->
                                <div class="col-md-6">
                                    <div class="card border-0 shadow h-100 gradient-card text-white" style="background: linear-gradient(135deg, #17a2b8 60%, #007bff 100%);">
                                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                            <div class="mb-2"><i class="bx bx-user-plus" style="font-size:2.5rem;"></i></div>
                                            <h6 class="fw-bold">Total Registered</h6>
                                            <h2 class="display-5 fw-bold mb-0">{{ $totalPersons ?? 0 }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow h-100 gradient-card" style="background: #C4E1E6;">
                                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                            <h6 class="fw-bold mb-2 text-gray">By Age Group</h6>
                                            <canvas id="ageGroupChart" height="110"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4 mb-4">
                                <!-- Second row: Birth Month & Religion -->
                                <div class="col-md-6">
                                    <div class="card border-0 shadow h-90 gradient-card" style="background: #C4E1E6;">
                                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                            <h6 class="fw-bold mb-2 text-dark">By Birth Month</h6>
                                            <canvas id="birthMonthChart" height="90"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow h-90 gradient-card" style="background: linear-gradient(135deg, #e0e0e0 60%, #bdbdbd 100%);">
                                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                            <h6 class="fw-bold mb-2 text-gray">By Religion</h6>
                                            <canvas id="religionChart" height="90"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                        
                    </div>
                </div>
            </div>
            </div>

            {{-- Footer --}}
            @include('layouts.footer')
            {{-- End Footer --}}

            <!-- Right Sidebar -->
            @include('layouts.rightSideBar')
            <!-- /Right-bar -->

            <!-- Right bar overlay-->
            <div class="rightbar-overlay"></div>

            @include('layouts.appJs')
            <!-- Chart.js CDN (or local) -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Pass PHP data to JS for charts
                window.ageGroupLabels = @json(array_keys($ageGroups ?? []));
                window.ageGroupData = @json(array_values($ageGroups ?? []));
                window.birthMonthLabels = @json(array_map(fn($m) => DateTime::createFromFormat('!m', $m)->format('F'), array_keys($birthMonthCounts ?? [])));
                window.birthMonthData = @json(array_values($birthMonthCounts ?? []));
                window.religionLabels = @json(array_keys($religionChart ?? []));
                window.religionData = @json(array_values($religionChart ?? []));
            </script>
            <script src="{{ asset('assets/js/custome/dashboard.js') }}"></script>
        </body>

        </html>
    @else
        @include('layouts.notValidateUser')
    @endif
@else
    @include('layouts.noUser')
@endif
