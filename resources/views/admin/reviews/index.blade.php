@extends('layouts.admin')

@section('title', 'Kelola Ulasan')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Kelola Ulasan</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pengguna</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $review->user->name ?? '-' }}</td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}" style="font-size:0.75rem"></i>
                                @endfor
                            </td>
                            <td>{{ Str::limit($review->comment, 60) }}</td>
                            <td>{{ $review->created_at->format('d M Y') }}</td>
                            <td>
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                    onsubmit="return confirm('Hapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Belum ada ulasan</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $reviews->links() }}</div>
        </div>
    </div>

</div>
@endsection
