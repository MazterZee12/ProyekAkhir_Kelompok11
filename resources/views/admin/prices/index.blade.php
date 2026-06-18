@extends('layouts.admin')
@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Prices</h4>
        <a href="{{ route('admin.prices.create') }}" class="btn btn-primary">+ Add Price</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th width="80">Photo</th>
                        <th width="100">Type</th>
                        <th>Amount</th>
                        <th>Unit</th>
                        <th width="90">Status</th>
                        <th width="230">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($prices as $price)
                    <tr>
                        <td>{{ $prices->firstItem() + $loop->index }}</td>
                        <td>
                            @if($price->media)
                                <img src="{{ $price->media->url }}"
                                    width="80" class="img-thumbnail">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ ucfirst($price->type) }}</td>
                        <td>{{ $price->formatted_amount }}</td>
                        <td>{{ $price->unit }}</td>
                        <td>
                            @if($price->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('admin.prices.show', $price) }}"
                                class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('admin.prices.edit', $price) }}"
                                class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.prices.toggle', $price) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                @if($price->is_active)
                                    <button class="btn btn-sm btn-secondary">Nonaktifkan</button>
                                @else
                                    <button class="btn btn-sm btn-success">Aktifkan</button>
                                @endif
                            </form>
                            <button type="button" class="btn btn-sm btn-danger"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="{{ $price->id }}"
                                data-title="{{ ucfirst($price->type) }} - {{ $price->unit }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No prices found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $prices->links() }}</div>
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
                <strong id="deletePriceTitle"></strong>?
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
    document.getElementById('deletePriceTitle').textContent = btn.getAttribute('data-title');
    document.getElementById('deleteForm').action = '/admin/prices/' + btn.getAttribute('data-id');
});
</script>
@endpush
