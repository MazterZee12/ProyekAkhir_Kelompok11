@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Detail Fasilitas</h4>
        <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">&larr; Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">

            @if($facility->photo_path)
                <div class="mb-4">
                    <img src="{{ asset('storage/'.$facility->photo_path) }}"
                        width="200" class="img-thumbnail">
                </div>
            @endif

            <table class="table table-bordered">
                <tr>
                    <th width="200">Nama</th>
                    <td>{{ $facility->name }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $facility->description ?? '-' }}</td>
                </tr>
            </table>

            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('admin.facilities.edit', $facility->id) }}"
                    class="btn btn-warning">Edit</a>
                <button type="button" class="btn btn-danger"
                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                    data-id="{{ $facility->id }}"
                    data-title="{{ $facility->name }}">
                    Hapus
                </button>
            </div>

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
                Hapus fasilitas <strong id="deleteFacilityTitle"></strong>?
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
