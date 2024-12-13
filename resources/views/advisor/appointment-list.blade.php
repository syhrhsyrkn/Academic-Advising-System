@extends('layouts.master')

@section('content')
<div class="container">
    <h1>All Appointments</h1>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('advisor.appointment-list') }}" class="mb-4">        
        <div style="display: flex; gap: 20px; align-items: center;">
            <!-- Filter by Status -->
            <div>
                <label for="status">Filter by Status:</label>
                <select name="status" id="status" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- Filter by Date -->
            <div>
                <label for="date">Filter by Date:</label>
                <input type="date" name="date" id="date" value="{{ request('date') }}" onchange="this.form.submit()">
            </div>
        </div>
    </form>

    <!-- Appointments Table -->
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Matric No</th>
                <th>Advising Reason</th>
                <th>Status</th>
                <th>Appointment Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $loop->iteration + ($appointments->currentPage() - 1) * $appointments->perPage() }}</td>
                    <td>{{ $appointment->user->name }}</td>
                    <td>{{ $appointment->user->student->matric_no ?? 'N/A' }}</td>
                    <td>{{ $appointment->advising_reason }}</td>
                    <td>{{ $appointment->status }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>
                        <a href="{{ route('advisor.update-advising-status', $appointment->id) }}">Update</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No appointments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $appointments->withQueryString()->links() }}
    </div>
</div>
@endsection
