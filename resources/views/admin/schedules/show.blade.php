@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Schedule Detail</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Day</th>
                    <td>{{ $schedule->day }}</td>
                </tr>
                <tr>
                    <th>Open Time</th>
                    <td>{{ $schedule->open_time }}</td>
                </tr>
                <tr>
                    <th>Close Time</th>
                    <td>{{ $schedule->close_time }}</td>
                </tr>
                <tr>
                    <th>Capacity</th>
                    <td>{{ $schedule->capacity ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Best Time to Visit</th>
                    <td>{{ $schedule->best_time ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Parking Information</th>
                    <td>{{ $schedule->parking_info ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Transportation Information</th>
                    <td>{{ $schedule->transport_info ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Route Information</th>
                    <td>{{ $schedule->route_info ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($schedule->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
