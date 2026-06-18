@extends('layouts.admin')
@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Banners</h4>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">+ Add Banner</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th width="150">Image</th>
                        <th>Title</th>
                        <th width="70">Order</th>
                        <th width="90">Status</th>
                        <th width="230">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($banners as $banner)
                    <tr>
                        <td>{{ $banners->firstItem() + $loop->index }}</td>
                        <td>
                            @if($banner->media)
                                <img src="{{ $banner->media->url }}" width="120" class="img-thumbnail" alt="{{ $banner->title }}">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td><strong>{{ $banner->title }}</strong></td>
                        <td>{{ $banner->order }}</td>
                        <td>
                            @if($banner->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('admin.banners.show', $banner->id) }}" class="btn btn-sm btn-info">Lihat</a>

                            <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('admin.banners.toggle', $banner->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                @if($banner->is_active)
                                    <button class="btn btn-sm btn-secondary">Nonaktifkan</button>
                                @else
                                    <button class="btn btn-sm btn-success">Aktifkan</button>
                                @endif
                            </form>

                            <button type="button" class="btn btn-sm btn-danger"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="{{ $banner->id }}"
                                data-title="{{ $banner->title }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No banners found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $banners->links() }}</div>
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
                Apakah kamu yakin ingin menghapus banner
                <strong id="deleteBannerTitle"></strong>?
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
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        document.getElementById('deleteBannerTitle').textContent = btn.getAttribute('data-title');
        document.getElementById('deleteForm').action =
            '/admin/banners/' + btn.getAttribute('data-id');
    });
});
</script>
@endpush
