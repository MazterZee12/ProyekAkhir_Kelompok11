@extends('layouts.admin')
@section('title', 'Detail Permintaan Informasi')
@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Detail Permintaan Informasi</h4>
        <a href="{{ route('admin.information-requests.index') }}" class="btn btn-secondary">&larr; Kembali</a>
    </div>

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th width="180">Pengguna</th>
                            <td>{{ $informationRequest->user->name ?? '-' }} ({{ $informationRequest->user->email ?? '-' }})</td>
                        </tr>
                        <tr>
                            <th>Subjek</th>
                            <td>{{ $informationRequest->subject }}</td>
                        </tr>
                        <tr>
                            <th>Pesan</th>
                            <td>{{ $informationRequest->message }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span class="ir-badge ir-badge-{{ $informationRequest->status }}">{{ ucfirst($informationRequest->status) }}</span></td>
                        </tr>
                        <tr>
                            <th>Diajukan</th>
                            <td>{{ $informationRequest->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @if($informationRequest->responded_at)
                        <tr>
                            <th>Dijawab</th>
                            <td>{{ $informationRequest->responded_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            @if($informationRequest->response)
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-2"><i class="fas fa-reply me-2 text-info"></i>Jawaban Saat Ini</h6>
                        <p class="mb-0">{{ $informationRequest->response }}</p>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3"><i class="fas fa-paper-plane me-2 text-primary"></i>
                        {{ $informationRequest->response ? 'Perbarui Jawaban' : 'Jawab Permintaan' }}
                    </h6>
                    <form action="{{ route('admin.information-requests.answer', $informationRequest) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <textarea name="response" rows="5" class="form-control"
                                placeholder="Tulis jawaban untuk pengguna...">{{ old('response', $informationRequest->response) }}</textarea>
                            @error('response')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Kirim Jawaban
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3"><i class="fas fa-sliders-h me-2 text-secondary"></i>Ubah Status</h6>
                    <form action="{{ route('admin.information-requests.status', $informationRequest) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select ir-status-select mb-3"
                            data-current="{{ $informationRequest->status }}">
                            <option value="pending"  {{ $informationRequest->status === 'pending'  ? 'selected' : '' }}>Pending</option>
                            <option value="answered" {{ $informationRequest->status === 'answered' ? 'selected' : '' }}>Answered</option>
                            <option value="closed"   {{ $informationRequest->status === 'closed'   ? 'selected' : '' }}>Closed</option>
                        </select>
                    </form>

                    @if($informationRequest->status !== 'closed')
                        <form action="{{ route('admin.information-requests.status', $informationRequest) }}" method="POST"
                            data-confirm="Tutup permintaan ini? Pengguna tidak akan bisa mengedit lagi.">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="closed">
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-lock me-1"></i> Tutup Permintaan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
