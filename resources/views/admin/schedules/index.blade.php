@extends('layouts.admin')
@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Schedules</h4>
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">+ Add Schedule</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Day</th>
                        <th width="110">Open Time</th>
                        <th width="110">Close Time</th>
                        <th width="100">Capacity</th>
                        <th width="90">Status</th>
                        <th width="200">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($schedules as $schedule)
                    <tr>
                        <td>{{ $schedules->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $schedule->day }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($schedule->open_time)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->close_time)->format('H:i') }}</td>
                        <td>{{ $schedule->capacity ?? '-' }}</td>
                        <td>
                            @if($schedule->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('admin.schedules.show', $schedule->id) }}"
                                class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('admin.schedules.edit', $schedule->id) }}"
                                class="btn btn-sm btn-warning">Edit</a>
                            <button type="button" class="btn btn-sm btn-danger"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="{{ $schedule->id }}"
                                data-title="{{ $schedule->day }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No schedules found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $schedules->links() }}</div>
        </div>
    </div>

</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Apakah kamu yakin ingin menghapus jadwal
                <strong id="deleteScheduleTitle"></strong>?
                Tindakan ini tidak bisa dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('deleteModal').addEventListener('show.bs.modal', function (e) {
    const btn = e.relatedTarget;
    document.getElementById('deleteScheduleTitle').textContent = btn.getAttribute('data-title');
    document.getElementById('deleteForm').action = '/admin/schedules/' + btn.getAttribute('data-id');
});
</script>
@endpush
