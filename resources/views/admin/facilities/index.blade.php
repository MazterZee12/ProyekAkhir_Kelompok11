@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Facilities</h4>
        <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary">+ Add Facility</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th width="100">Photo</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th width="160">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($facilities as $facility)
                    <tr>
                        <td>{{ $facilities->firstItem() + $loop->index }}</td>
                        <td>
                            @if($facility->photo_path)
                                <img src="{{ asset('storage/'.$facility->photo_path) }}"
                                    width="80" class="img-thumbnail">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td><strong>{{ $facility->name }}</strong></td>
                        <td>{{ Str::limit($facility->description, 60) ?? '-' }}</td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('admin.facilities.show', $facility->id) }}"
                                class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('admin.facilities.edit', $facility->id) }}"
                                class="btn btn-sm btn-warning">Edit</a>
                            <button type="button" class="btn btn-sm btn-danger"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="{{ $facility->id }}"
                                data-title="{{ $facility->name }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No facilities found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $facilities->links() }}</div>
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
                Apakah kamu yakin ingin menghapus fasilitas
                <strong id="deleteFacilityTitle"></strong>?
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
    document.getElementById('deleteFacilityTitle').textContent = btn.getAttribute('data-title');
    document.getElementById('deleteForm').action = '/admin/facilities/' + btn.getAttribute('data-id');
});
</script>
@endpush
