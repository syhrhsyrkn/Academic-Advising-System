<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>i-Plan</title>
    <link rel="shortcut icon" href="{{asset('assets/img/logo-small.png')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">
    
    <!-- Include only Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/icons/flags/flags.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>

<body>
    <div class="header">
        <div class="header-left">
            <a href="#" class="logo">
                <img src="{{asset('assets/img/logo.png')}}" alt="Logo">
            </a>
            <a href="#" class="logo logo-small">
                <img src="{{asset('assets/img/logo-small.png')}}" alt="Logo" width="30" height="30">
            </a>
        </div>

        <div class="menu-toggle">
            <a href="javascript:void(0);" id="toggle_btn">
                <i class="fas fa-bars"></i>
            </a>
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
                        <!-- @role('admin')
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
                        @endrole -->
                        @if(auth()->user()->hasRole('advisor') || auth()->user()->hasRole('student'))
                    <li class="submenu">
                        <a href="#"><i class="fas fa-graduation-cap"></i> <span> Advising </span> <span class="menu-arrow"></span></a>
                        <ul>
                            @role('advisor')
                            <li><a href="advisor/student-list">Student List</a></li>
                            <li><a href="{{ route('appointments.index') }}">Appointment List</a></li>
                            @endrole
                            @role('student')
                            <li><a href="{{ route('appointments.create') }}">Book Appointment</a></li>
                            <li><a href="{{ route('appointments.myAppointments') }}">Appointment History</a></li>
                            @endrole
                        </ul>
                    </li>
                    @endif
                    <li class="submenu">
                        <a href="#"><i class="fas fa-book-reader"></i> <span> Course</span> <span class="menu-arrow"></span></a>
                        <ul>
                            <li><a href="{{ route('course.index') }}">Course List</a></li>
                            @role('admin')
                            <li><a href="{{ route('course.create') }}">Course Add</a></li>
                            @endrole
                        </ul>
                    </li>
                    @role('student')
                    <li class="submenu">
                        <a href="#"><i class="fas fa-graduation-cap"></i> <span> Course Schedule</span> <span class="menu-arrow"></span></a>
                        <ul>
                        </ul>
                    </li>
                    @endrole
                    @role('student')
                    <li class="submenu">
                        <a href="#"><i class="fas fa-graduation-cap"></i> <span>Academic Result</span> <span class="menu-arrow"></span></a>
                        <ul>
                        </ul>
                    </li>
                    @endrole
                </ul>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')

                            <!-- Display Validation Errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Full Name -->
                            <div class="form-group mb-3">
                                <label for="full_name">Full Name</label>
                                <input 
                                    type="text" 
                                    name="full_name" 
                                    id="full_name" 
                                    class="form-control" 
                                    value="{{ old('full_name', $profile->full_name ?? '') }}" 
                                    required>
                            </div>

                            <!-- Role-specific Fields -->
                            @if (auth()->user()->hasRole('student'))
                                <!-- Matric No -->
                                <div class="form-group mb-3">
                                    <label for="matric_no">Matric No</label>
                                    <input 
                                        type="text" 
                                        name="matric_no" 
                                        id="matric_no" 
                                        class="form-control" 
                                        value="{{ old('matric_no', $profile->matric_no ?? '') }}" 
                                        required>
                                </div>

                                <!-- Year -->
                                <div class="form-group mb-3">
                                    <label for="year">Year</label>
                                    <select name="year" id="year" class="form-control" required>
                                        <option disabled value="">Select Year</option>
                                        <option value="1" {{ old('year', $profile->year ?? '') == 1 ? 'selected' : '' }}>Year 1</option>
                                        <option value="2" {{ old('year', $profile->year ?? '') == 2 ? 'selected' : '' }}>Year 2</option>
                                        <option value="3" {{ old('year', $profile->year ?? '') == 3 ? 'selected' : '' }}>Year 3</option>
                                        <option value="4" {{ old('year', $profile->year ?? '') == 4 ? 'selected' : '' }}>Year 4</option>
                                    </select>
                                </div>

                                <!-- Semester -->
                                <div class="form-group mb-3">
                                    <label for="semester">Semester</label>
                                    <select name="semester" id="semester" class="form-control" required>
                                    <option disabled value="">Select Semester</option>
                                        <option value="1" {{ old('semester', $profile->semester ?? '') == 1 ? 'selected' : '' }}>Semester 1</option>
                                        <option value="2" {{ old('semester', $profile->semester ?? '') == 2 ? 'selected' : '' }}>Semester 2</option>
                                        <option value="3" {{ old('semester', $profile->semester ?? '') == 3 ? 'selected' : '' }}>Semester 3</option>
                                    </select>
                                </div>

                            <!-- Specialisation -->
                            <div class="form-group mb-3">
                                <label for="specialisation">Specialisation</label>
                                <select name="specialisation" id="specialisation" class="form-control">
                                    <option value="-">-</option>
                                    <option value="Cybersecurity" {{ old('specialisation', $profile->specialisation ?? '') == 'Cybersecurity' ? 'selected' : '' }}>Cybersecurity</option>
                                    <option value="Cloud Computing and System Paradigm" {{ old('specialisation', $profile->specialisation ?? '') == 'Cloud Computing and System Paradigm' ? 'selected' : '' }}>Cloud Computing and System Paradigm</option>
                                    <option value="Innovative Digital Experience (IDEx)" {{ old('specialisation', $profile->specialisation ?? '') == 'Innovative Digital Experience (IDEx)' ? 'selected' : '' }}>Innovative Digital Experience (IDEx)</option>
                                    <option value="Data Analytics" {{ old('specialisation', $profile->specialisation ?? '') == 'Data Analytics' ? 'selected' : '' }}>Data Analytics</option>
                                    <option value="Digital Transformation" {{ old('specialisation', $profile->specialisation ?? '') == 'Digital Transformation' ? 'selected' : '' }}>Digital Transformation</option>
                                </select>
                            </div>

                            @elseif (auth()->user()->hasRole(['admin', 'advisor']))
                                <!-- Staff ID -->
                                <div class="form-group mb-3">
                                    <label for="staff_id">Staff ID</label>
                                    <input 
                                        type="text" 
                                        name="staff_id" 
                                        id="staff_id" 
                                        class="form-control" 
                                        value="{{ old('staff_id', $profile->staff_id ?? '') }}" 
                                        required>
                                </div>
                            @endif

                            <!-- Contact Number -->
                            <div class="form-group mb-3">
                                <label for="contact_no">Contact Number</label>
                                <input 
                                    type="text" 
                                    name="contact_no" 
                                    id="contact_no" 
                                    class="form-control" 
                                    value="{{ old('contact_no', $profile->contact_no ?? '') }}" 
                                    required>
                            </div>

                            <!-- Kulliyyah -->
                            <div class="form-group mb-3">
                                <label for="kulliyyah">Kulliyyah</label>
                                <input 
                                    type="text" 
                                    name="kulliyyah" 
                                    id="kulliyyah" 
                                    class="form-control" 
                                    value="{{ old('kulliyyah', $profile->kulliyyah ?? '') }}" 
                                    required>
                            </div>

                            <!-- Department -->
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select name="department" id="department" class="form-control" required>
                                    <option 
                                        value="Department of Information Systems" 
                                        {{ old('department', Auth::user()->department) == 'Department of Information Systems' ? 'selected' : '' }}>
                                        Department of Information Systems
                                    </option>
                                    <option 
                                        value="Department of Computer Science" 
                                        {{ old('department', Auth::user()->department) == 'Department of Computer Science' ? 'selected' : '' }}>
                                        Department of Computer Science
                                    </option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p class="text-center">Copyright © 2024 by MyKICT</p>
    </footer>

    </div>

    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{asset('assets/js/feather.min.js')}}"></script>
    <script src="{{asset('assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('assets/plugins/apexchart/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/plugins/apexchart/chart-data.js')}}"></script>
    <script src="{{asset('assets/js/script.js')}}"></script>

    <script src="{{ asset('assets/plugins/simple-calendar/jquery.simple-calendar.js') }}"></script>
    <script src="{{ asset('assets/js/calander.js') }}"></script>
    <script src="{{ asset('assets/js/circle-progress.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the toggle button and sidebar
            const toggleButton = document.getElementById('toggle_btn');
            const sidebar = document.getElementById('sidebar');

            // Toggle sidebar visibility on button click
            toggleButton.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        });
    </script>

</body>

<style>

    .sidebar {
        display: none;
        transition: all 0.3s ease;
    }

    .sidebar.active {
        display: block;
    }

    body {
    background-color: white !important;
    }

</style>

</html>

