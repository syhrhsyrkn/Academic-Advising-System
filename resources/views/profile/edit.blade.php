@extends('layouts.master')
@section('content')

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

                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="full_name" class="form-control" value="{{ $profile->full_name }}" required>
                            </div>

                        @role('student')
                            <div class="form-group">
                                <label>Matric No</label>
                                <input type="text" name="matric_no" class="form-control" value="{{ $profile->matric_no }}">
                            </div>
                        @endrole

                        @role('admin'|'advisor')
                            <div class="form-group">
                                <label>Staff ID</label>
                                <input type="text" name="staff_id" class="form-control" value="{{ $profile->staff_id }}">
                            </div>
                        @endrole

                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" value="{{ $profile->contact_number }}" required>
                        </div>

                        @role('student')
                            <div class="form-group">
                                <label>Specialisation</label>
                                <input type="text" name="specialisation" class="form-control" value="{{ $profile->specialisation }}">
                            </div>
                            <div class="form-group">
                                <label>Year</label>
                                <input type="number" name="year" class="form-control" value="{{ $profile->year }}">
                            </div>
                            <div class="form-group">
                                <label>Semester</label>
                                <input type="number" name="semester" class="form-control" value="{{ $profile->semester }}">
                            </div>
                        @endrole

                        <div class="form-group">
                            <label>Kulliyyah</label>
                            <input type="text" name="kulliyyah" class="form-control" value="{{ $profile->kulliyyah }}" required>
                        </div>

                        <div class="form-group">
                            <label>Department</label>
                            <input type="text" name="department" class="form-control" value="{{ $profile->department }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
