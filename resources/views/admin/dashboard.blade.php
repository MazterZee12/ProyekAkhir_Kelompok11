@extends('layouts.admin')

@section('title', 'Dashboard')
@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold">Dashboard</h4>
            <small class="text-muted">Selamat datang, {{ auth()->user()->name ?? 'Admin' }}</small>
        </div>
        <small class="text-muted"><i class="fas fa-clock me-1"></i>{{ now()->format('d M Y, H:i') }}</small>
    </div>

    <!-- STAT CARDS -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#4a1d96,#7c3aed)">
                <div class="stat-label">Pengunjung Terdaftar</div>
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-sub">Total akun terdaftar</div>
                <i class="fas fa-users stat-icon"></i>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#0c4a6e,#0284c7)">
                <div class="stat-label">Ulasan</div>
                <div class="stat-value">{{ $totalReviews }}</div>
                <div class="stat-sub">{{ $pendingReviews }} menunggu moderasi</div>
                <i class="fas fa-star stat-icon"></i>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#14532d,#16a34a)">
                <div class="stat-label">Pengumuman</div>
                <div class="stat-value">{{ $totalAnnouncements }}</div>
                <div class="stat-sub">{{ $activeAnnouncements }} aktif</div>
                <i class="fas fa-bullhorn stat-icon"></i>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#92400e,#d97706)">
                <div class="stat-label">Galeri</div>
                <div class="stat-value">{{ $totalGalleries }}</div>
                <div class="stat-sub">Total foto & video</div>
                <i class="fas fa-images stat-icon"></i>
            </div>
        </div>
    </div>

    <!-- CHARTS -->
    <div class="row g-3 mb-4">
        <!-- Rating Chart -->
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>Distribusi Rating Ulasan
                    </h6>
                    <canvas id="ratingChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <!-- Review Status -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>Status Ulasan
                    </h6>
                    <canvas id="reviewStatusChart" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- RECENT -->
    <div class="row g-3">
        <!-- Recent Reviews -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">
                            <i class="fas fa-star me-2 text-warning"></i>Ulasan Terbaru
                        </h6>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($recentReviews as $review)
                                <tr>
                                    <td>{{ $review->user->name ?? '-' }}</td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}" style="font-size:0.7rem"></i>
                                        @endfor
                                    </td>
                                    <td>
                                        @if($review->approved)
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted">Belum ada ulasan</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Announcements -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">
                            <i class="fas fa-bullhorn me-2 text-primary"></i>Pengumuman Terbaru
                        </h6>
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Tipe</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($recentAnnouncements as $announcement)
                                <tr>
                                    <td>{{ Str::limit($announcement->title, 30) }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ ucfirst($announcement->type) }}</span>
                                    </td>
                                    <td>
                                        @if($announcement->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted">Belum ada pengumuman</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Rating Distribution Chart
const ratingCtx = document.getElementById('ratingChart').getContext('2d');
new Chart(ratingCtx, {
    type: 'bar',
    data: {
        labels: ['1 Bintang', '2 Bintang', '3 Bintang', '4 Bintang', '5 Bintang'],
        datasets: [{
            label: 'Jumlah Ulasan',
            data: @json($ratingDistribution),
            backgroundColor: [
                'rgba(239,68,68,0.8)',
                'rgba(249,115,22,0.8)',
                'rgba(234,179,8,0.8)',
                'rgba(34,197,94,0.8)',
                'rgba(74,29,150,0.8)',
            ],
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: 'rgba(0,0,0,0.05)' } },
            x: { grid: { display: false } }
        }
    }
});

// Review Status Pie Chart
const statusCtx = document.getElementById('reviewStatusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Disetujui', 'Pending'],
        datasets: [{
            data: [{{ $approvedReviews }}, {{ $pendingReviews }}],
            backgroundColor: ['rgba(74,29,150,0.85)', 'rgba(234,179,8,0.85)'],
            borderWidth: 0,
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true,
        cutout: '65%',
        plugins: {
            legend: { position: 'bottom', labels: { padding: 16, font: { size: 12 } } }
        }
    }
});
</script>
@endpush
