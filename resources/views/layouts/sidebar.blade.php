@php
    $role = Auth::user()?->role;
@endphp

<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Side Menu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="{{ url('/dashboard') }}" class="waves-effect bx-fade-right-hover">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                <center>
                    <hr width="90%">
                </center>

                <li class="menu-title" key="t-menu">Options</li>

                @if ($role === 'Admin')
                    <li>
                        <a href="{{ url('register') }}" class="waves-effect bx-fade-right-hover">
                            <i class="fas fa-user-plus"></i>
                            <span key="t-add-user">Add New User</span>
                        </a>
                    </li>
                @endif

                @if (in_array($role, ['Admin', 'Data Entry', 'Viewer']))
                    <li>
                        <a href="{{ route('persons.create') }}" class="waves-effect bx-fade-right-hover">
                            <i class="fas fa-user-edit"></i>
                            <span key="t-add-person">Persons</span>
                        </a>
                    </li>
                @endif

                {{-- @if (in_array($role, ['Admin', 'Viewer']))
                    <li>
                        <a href="{{ url('view-person') }}" class="waves-effect bx-fade-right-hover">
                            <i class="fas fa-chart-bar"></i>
                            <span key="t-view-person">View Person</span>
                        </a>
                    </li>
                @endif --}}

            </ul>
        </div>
        <!-- Side Menu -->
    </div>
</div>
