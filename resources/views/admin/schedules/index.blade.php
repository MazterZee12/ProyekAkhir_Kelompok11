@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Schedules</h4>
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
            + Add Schedule
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Day</th>
                        <th>Open Time</th>
                        <th>Close Time</th>
                        <th>Capacity</th>
                        <th width="80">Status</th>
                        <th width="220">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($schedules as $schedule)
                    <tr>
                        <td>{{ $schedules->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $schedule->day }}</strong></td>
                        <td>{{ $schedule->open_time }}</td>
                        <td>{{ $schedule->close_time }}</td>
                        <td>{{ $schedule->capacity ?? '-' }}</td>
                        <td>
                            @if($schedule->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.schedules.show', $schedule->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST"
                                onsubmit="return confirm('Delete this schedule?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No schedules found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $schedules->links() }}</div>
        </div>
    </div>
</div>
@endsection
