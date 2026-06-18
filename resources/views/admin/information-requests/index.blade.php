@extends('layouts.admin')
@section('title', 'Kelola Permintaan Informasi')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="fw-bold mb-0">Kelola Permintaan Informasi</h4>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card ir-stat-total">
                <div class="stat-label">Total</div>
                <div class="stat-value">{{ $total }}</div>
                <i class="fas fa-inbox stat-icon"></i>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card ir-stat-pending">
                <div class="stat-label">Pending</div>
                <div class="stat-value">{{ $pending }}</div>
                <i class="fas fa-clock stat-icon"></i>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card ir-stat-answered">
                <div class="stat-label">Answered</div>
                <div class="stat-value">{{ $answered }}</div>
                <i class="fas fa-check-circle stat-icon"></i>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card ir-stat-closed">
                <div class="stat-label">Closed</div>
                <div class="stat-value">{{ $closed }}</div>
                <i class="fas fa-lock stat-icon"></i>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            {{-- Filter Status --}}
            <div class="btn-group mb-3">
                <a href="{{ route('admin.information-requests.index') }}"
                   class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Semua
                </a>

                <a href="{{ route('admin.information-requests.index', ['status' => 'pending']) }}"
                   class="btn btn-sm {{ request('status') === 'pending' ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Pending
                </a>

                <a href="{{ route('admin.information-requests.index', ['status' => 'answered']) }}"
                   class="btn btn-sm {{ request('status') === 'answered' ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Answered
                </a>

                <a href="{{ route('admin.information-requests.index', ['status' => 'closed']) }}"
                   class="btn btn-sm {{ request('status') === 'closed' ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Closed
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pengguna</th>
                            <th>Subjek</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($informationRequests as $ir)
                        <tr>
                            <td>{{ $informationRequests->firstItem() + $loop->index }}</td>
                            <td>{{ $ir->user->name ?? '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($ir->subject, 40) }}</td>
                            <td>
                                <span class="ir-badge ir-badge-{{ $ir->status }}">
                                    {{ ucfirst($ir->status) }}
                                </span>
                            </td>
                            <td>{{ $ir->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.information-requests.show', $ir) }}"
                                   class="btn btn-sm btn-info">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada permintaan informasi.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $informationRequests->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
