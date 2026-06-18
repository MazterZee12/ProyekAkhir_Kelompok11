@extends('layouts.admin')

@section('title', 'Detail Ulasan')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Detail Ulasan</h4>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">&larr; Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Pengguna</th>
                    <td>{{ $review->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Rating</th>
                    <td>
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor
                        <span class="ms-1">({{ $review->rating }})</span>
                    </td>
                </tr>
                <tr>
                    <th>Komentar</th>
                    <td>{{ $review->comment ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($review->is_hidden)
                            <span class="badge bg-secondary">Disembunyikan</span>
                        @else
                            <span class="badge bg-success">Terlihat</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Kunjungan</th>
                    <td>{{ \Carbon\Carbon::parse($review->visit_date)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Diulas</th>
                    <td>{{ $review->created_at->format('d M Y, H:i') }} WIB</td>
                </tr>
            </table>

            <div class="mt-3 d-flex gap-2">
                <form action="{{ route('admin.reviews.toggleVisibility', $review) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    @if($review->is_hidden)
                        <button class="btn btn-success">Tampilkan Kembali</button>
                    @else
                        <button class="btn btn-secondary">Sembunyikan</button>
                    @endif
                </form>

                <button type="button" class="btn btn-danger"
                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                    data-id="{{ $review->id }}"
                    data-title="{{ $review->user->name ?? 'user ini' }}">
                    Hapus Ulasan
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
                Hapus ulasan dari <strong id="deleteReviewTitle"></strong>?
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
    document.getElementById('deleteReviewTitle').textContent = btn.getAttribute('data-title');
    document.getElementById('deleteForm').action = '/admin/reviews/' + btn.getAttribute('data-id');
});
</script>
@endpush
