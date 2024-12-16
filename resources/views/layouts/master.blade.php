<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>KICT Dashboard</title>
    <link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/icons/flags/flags.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->

<!-- Bootstrap Bundle with Popper (necessary for dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left">
                <a href="/dashboard" class="logo">
                    <img src="{{asset('assets/img/logo.png')}}" alt="Logo">
                </a>
                <a href="/dashboard" class="logo logo-small">
                    <img src="{{asset('assets/img/logo-small.png')}}" alt="Logo" width="30" height="30">
                </a>
            </div>
            <div class="menu-toggle">
                <a href="javascript:void(0);" id="toggle_btn">
                    <i class="fas fa-bars"></i>
                </a>
            </div>

            <div class="top-nav-search">
                <form>
                    <input type="text" class="form-control" placeholder="Search here">
                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <a class="mobile_btn" id="mobile_btn">
                <i class="fas fa-bars"></i>
            </a>

            <ul class="nav user-menu">

                <li class="nav-item zoom-screen me-2">
                    <a href="#" class="nav-link header-nav-list win-maximize">
                        <img src="{{asset('assets/img/icons/header-icon-04.svg')}}" alt="">
                    </a>
                </li>

                <li class="nav-item dropdown has-arrow new-user-menus">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="user-img">
                            <img class="rounded-circle" src="{{ asset('assets/img/profiles/avatar-01.jpg') }}" width="31" alt="{{ session('name') ?? 'User' }}">
                            <div class="user-text">
                            <h6>{{ Auth::user()->name ?? 'Guest' }}</h6>
                            <p class="text-muted mb-0">{{ Auth::user()->getRoleNames()->first() ?? 'Role Not Assigned' }}</p>
                            </div>
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                <img src="assets/img/profiles/avatar-01.jpg" alt="User Image"
                                    class="avatar-img rounded-circle">
                            </div>
                            <div class="user-text">
                                <h6>{{ Auth::user()->name ?? 'Guest' }}</h6>
                                <p class="text-muted mb-0">{{ Auth::user()->getRoleNames()->first() ?? 'Role Not Assigned' }}</p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="profile">My Profile</a>
                        <a class="dropdown-item" href="#" onclick="document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>

            </ul>

        </div>


        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">
                            <span>Main Menu</span>
                        </li>
                        @role('admin')
                        <li>
                            <a href="kict-dashboard"><i class="feather-grid"></i> <span> Admin Dashboard</span> </a>
                        </li>
                        @endrole
                        @role('advisor')
                        <li>
                            <a href="teacher-dashboard"><i class="feather-grid"></i> <span> Advisor Dashboard</span> </a>
                        </li>
                        @endrole
                        @role('student')
                        <li>
                            <a href="{{ route('student-dashboard') }}"><i class="feather-grid"></i> <span> Student Dashboard</span> </a>
                        </li>
                        @endrole
                        @role('advisor')
                        <li class="submenu">
                            <a href="#"><i class="fas fa-graduation-cap"></i> <span> Advising </span> <span
                            class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="advisor/student-list">Student List</a></li>
                                <li><a href=advisor/appointment-list>Appointment List</a></li>
                            </ul>
                        </li>
                        @endrole
                        <li class="submenu">
                            <a href="#"><i class="fas fa-book-reader"></i> <span> Course</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('course.index') }}">Course List</a></li>
                                @role('admin')
                                <li><a href="{{ route('course.create') }}">Course Add</a></li>
                                @endrole
                            </ul>
                        </li>
                        @role('student')
                        <li class="submenu">
                            <a href="#"><i class="fas fa-graduation-cap"></i> <span> Course Schedule</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('student_course_schedule.index', ['studentId' => auth()->user()->student->student_id]) }}">Course Schedule View</a></li>
                            </ul>
                        </li>
                        @endrole
                        @role('student')
                        <li class="submenu">
                            <a href="#"><i class="fas fa-graduation-cap"></i> <span>Academic Result</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="s.result-view.html">Academic Result View</a></li>
                                <li><a href="s.result-edit.html">Academic Result Edit</a></li>
                            </ul>
                        </li>
                        @endrole
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @yield('content')

        <footer>
            <p>Copyright © 2024 by MyKICT.</p>
        </footer>
    </div>

    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/feather.min.js')}}"></script>
    <script src="{{asset('assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('assets/plugins/apexchart/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/plugins/apexchart/chart-data.js')}}"></script>
    <script src="{{asset('assets/js/script.js')}}"></script>

    {{-- <script src="assets/plugins/simple-calendar/jquery.simple-calendar.js"></script>
    <script src="assets/js/calander.js"></script>
    <script src="assets/js/circle-progress.min.js"></script> --}}

</body>

</html>
