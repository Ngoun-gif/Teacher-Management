<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/dashboard')}}" class="brand-link">
        <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('frontend/assets/img/3.jpg')}}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="{{url('/dashboard')}}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{url('/dashboard')}}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Teacher -->
                <li class="nav-item {{ request()->is('dashboard/teacher*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('dashboard/teacher*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Employees
                            <i class="right fas fa-angle-left"></i>
                           
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('/dashboard/teacher')}}" class="nav-link {{ request()->is('dashboard/teacher') ? 'active' : '' }}">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <p>Teachers</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Setting Header -->
                <li class="nav-header">SETTING</li>

                <!-- Education -->
                <li class="nav-item {{ request()->is('dashboard/major*') || request()->is('dashboard/subject*') || request()->is('dashboard/course*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('dashboard/major*') || request()->is('dashboard/subject*') || request()->is('dashboard/course*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Education
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('/dashboard/major')}}" class="nav-link {{ request()->is('dashboard/major*') ? 'active' : '' }}">
                                <i class="fas fa-graduation-cap nav-icon"></i>
                                <p>Majors</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/dashboard/subject')}}" class="nav-link {{ request()->is('dashboard/subject*') ? 'active' : '' }}">
                                <i class="fas fa-book nav-icon"></i>
                                <p>Subjects</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/dashboard/course')}}" class="nav-link {{ request()->is('dashboard/course*') ? 'active' : '' }}">
                                <i class="fab fa-discourse nav-icon"></i>
                                <p>Courses</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Divider -->
                <li class="nav-header mt-auto"></li>

                <!-- Logout Button - Placed at bottom -->
                <!-- Logout Button with Confirmation -->
            <li class="nav-item">
                <a class="nav-link text-danger" href="{{ route('logout') }}" 
                   onclick="
                        event.preventDefault();
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'You will be logged out of the system.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: 'red',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, logout!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('logout-form').submit();
                            }
                        });
                   ">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>