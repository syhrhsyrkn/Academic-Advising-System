@extends('layouts.master')
@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <!-- Profile Header -->
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-auto profile-image">
                            <a href="#">
                                <img class="rounded-circle" alt="User Image" src="{{ asset('assets/img/profiles/avatar-02.jpg') }}">
                            </a>
                        </div>
                        <div class="col ms-md-n2 profile-user-info">
                            <h4 class="user-name mb-0">{{ $profile->full_name }}</h4>
                            <h6 class="text-muted">{{ auth()->user()->roles->pluck('name')->first() }}</h6>
                            <div class="user-location"><i class="fas fa-map-marker-alt"></i> {{ $profile->kulliyyah }}, {{ $profile->department }}</div>
                        </div>
                        <div class="col-auto profile-btn">
                            <!-- <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                Edit
                            </a> -->
                        </div>
                    </div>
                </div>
                <!-- /Profile Header -->

                <!-- Profile Menu -->
                <div class="profile-menu">
                    <ul class="nav nav-tabs nav-tabs-solid">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#per_details_tab">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#password_tab">Password</a>
                        </li>
                    </ul>
                </div>
                <!-- /Profile Menu -->

                <!-- Profile Content -->
                <div class="tab-content profile-tab-cont">

                    <!-- Personal Details Tab -->
                    <div class="tab-pane fade show active" id="per_details_tab">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span>Personal Details</span>
                                            <a class="edit-link" href="{{ route('profile.edit') }}"><i class="far fa-edit me-1"></i>Edit</a>
                                        </h5>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Full Name</p>
                                            <p class="col-sm-9">{{ $profile->full_name }}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Contact Number</p>
                                            <p class="col-sm-9">{{ $profile->contact_number }}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Kulliyyah</p>
                                            <p class="col-sm-9">{{ $profile->kulliyyah }}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Department</p>
                                            <p class="col-sm-9">{{ $profile->department }}</p>
                                        </div>

                                        @if(auth()->user()->hasRole('student'))
                                            <div class="row">
                                                <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Matric No</p>
                                                <p class="col-sm-9">{{ $profile->matric_no }}</p>
                                            </div>
                                            <div class="row">
                                                <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Specialisation</p>
                                                <p class="col-sm-9">{{ $profile->specialisation }}</p>
                                            </div>
                                            <div class="row">
                                                <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Year</p>
                                                <p class="col-sm-9">{{ $profile->year }}</p>
                                            </div>
                                            <div class="row">
                                                <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Semester</p>
                                                <p class="col-sm-9">{{ $profile->semester }}</p>
                                            </div>
                                        @endif

                                        @if(auth()->user()->hasRole(['advisor', 'admin']))
                                            <div class="row">
                                                <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Staff ID</p>
                                                <p class="col-sm-9">{{ $profile->staff_id }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Personal Details Tab -->

                </div>
                <!-- /Profile Content -->
            </div>
        </div>
    </div>
</div>

@endsection
