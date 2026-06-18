@extends('layouts.admin')
@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Gallery</h4>
        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">+ Upload Gallery</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th width="120">Preview</th>
                        <th>Title</th>
                        <th width="100">Type</th>
                        <th width="120">Created</th>
                        <th width="200">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($galleries as $gallery)
                    <tr>
                        <td>{{ $galleries->firstItem() + $loop->index }}</td>
                        <td>
                            @if($gallery->type == 'photo')
                                <img src="{{ $gallery->media->url }}" width="80" class="img-thumbnail">
                            @else
                                <video width="80">
                                    <source src="{{ $gallery->media->url }}">
                                </video>
                            @endif
                        </td>
                        <td><strong>{{ $gallery->title ?? '-' }}</strong></td>
                        <td>
                            <span class="badge bg-info text-dark">{{ ucfirst($gallery->type) }}</span>
                        </td>
                        <td>{{ $gallery->created_at->format('d M Y') }}</td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('admin.galleries.show', $gallery->id) }}"
                                class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('admin.galleries.edit', $gallery->id) }}"
                                class="btn btn-sm btn-warning">Edit</a>
                            <button type="button" class="btn btn-sm btn-danger"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="{{ $gallery->id }}"
                                data-title="{{ $gallery->title ?? 'gallery ini' }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No gallery found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $galleries->links() }}</div>
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
                Apakah kamu yakin ingin menghapus
                <strong id="deleteGalleryTitle"></strong>?
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
    document.getElementById('deleteGalleryTitle').textContent = btn.getAttribute('data-title');
    document.getElementById('deleteForm').action = '/admin/galleries/' + btn.getAttribute('data-id');
});
</script>
@endpush
