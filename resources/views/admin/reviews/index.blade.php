@extends('layouts.admin')

@section('title', 'Kelola Ulasan')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            Kelola Ulasan
            @if($reportedCount > 0)
                <span class="badge bg-danger ms-2">{{ $reportedCount }} dilaporkan</span>
            @endif
        </h4>
        {{-- Filter --}}
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reviews.index') }}"
                class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-secondary' }}">
                Semua
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'reported']) }}"
                class="btn btn-sm {{ request('status') === 'reported' ? 'btn-danger' : 'btn-outline-danger' }}">
                Dilaporkan
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'hidden']) }}"
                class="btn btn-sm {{ request('status') === 'hidden' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                Disembunyikan
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pengguna</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Laporan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($reviews as $review)
                        <tr class="{{ $review->is_hidden ? 'table-warning' : '' }}">
                            <td>{{ $reviews->firstItem() + $loop->index }}</td>
                            <td>{{ $review->user->name ?? '-' }}</td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"
                                        style="font-size:0.75rem"></i>
                                @endfor
                            </td>
                            <td>
                                {{ Str::limit($review->comment, 60) }}
                                @if($review->is_hidden)
                                    <span class="badge bg-secondary ms-1">Disembunyikan</span>
                                @endif
                            </td>
                            <td>
                                @if($review->reports_count > 0)
                                    <span class="badge bg-danger">
                                        {{ $review->reports_count }}x
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $review->created_at->format('d M Y') }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('admin.reviews.show', $review) }}"
                                    class="btn btn-sm btn-info">Detail</a>

                                @if($review->is_hidden)
                                    <form action="{{ route('admin.reviews.unhide', $review) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-success">Tampilkan</button>
                                    </form>
                                @endif

                                <button type="button" class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-id="{{ $review->id }}"
                                    data-title="{{ $review->user->name ?? 'user ini' }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada ulasan.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $reviews->links() }}</div>
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
                Apakah kamu yakin ingin menghapus ulasan dari
                <strong id="deleteReviewTitle"></strong>?
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
