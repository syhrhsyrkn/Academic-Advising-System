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
                            <input type="text" name="full_name" id="full_name" class="form-control" 
                                value="{{ old('full_name', $profile->full_name ?? '') }}" required>
                        </div>

                        <!-- Role-specific Fields -->
                        @if(auth()->user()->hasRole('student'))
                            <!-- Matric No -->
                            <div class="form-group mb-3">
                                <label for="matric_no">Matric No</label>
                                <input type="text" name="matric_no" id="matric_no" class="form-control" 
                                    value="{{ old('matric_no', $profile->matric_no ?? '') }}" required>
                            </div>

                            <!-- Specialisation -->
                            <div class="form-group mb-3">
                                <label for="specialisation">Specialisation</label>
                                <input type="text" name="specialisation" id="specialisation" class="form-control" 
                                    value="{{ old('specialisation', $profile->specialisation ?? '') }}">
                            </div>

                        @elseif(auth()->user()->hasRole(['admin', 'advisor']))
                            <!-- Staff ID -->
                            <div class="form-group mb-3">
                                <label for="staff_id">Staff ID</label>
                                <input type="text" name="staff_id" id="staff_id" class="form-control" 
                                    value="{{ old('staff_id', $profile->staff_id ?? '') }}" required>
                            </div>
                        @endif

                        <!-- Contact Number -->
                        <div class="form-group mb-3">
                            <label for="contact_no">Contact Number</label>
                            <input type="text" name="contact_no" id="contact_no" class="form-control" 
                                value="{{ old('contact_no', $profile->contact_no ?? '') }}" required>
                        </div>

                        <!-- Kulliyyah -->
                        <div class="form-group mb-3">
                            <label for="kulliyyah">Kulliyyah</label>
                            <input type="text" name="kulliyyah" id="kulliyyah" class="form-control" 
                                value="{{ old('kulliyyah', $profile->kulliyyah ?? '') }}" required>
                        </div>

                        <!-- Department -->
                        <div class="form-group">
                            <label for="department">Department</label>
                            <select name="department" id="department" class="form-control" required>
                                <option value="Department of Information Systems" {{ old('department', Auth::user()->department) == 'Department of Information Systems' ? 'selected' : '' }}>Department of Information Systems</option>
                                <option value="Department of Computer Science" {{ old('department', Auth::user()->department) == 'Department of Computer Science' ? 'selected' : '' }}>Department of Computer Science</option>
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
@endsection
