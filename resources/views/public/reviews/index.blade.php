@extends('layouts.public')

@section('title', 'Ulasan Pengunjung — Pasir Putih Parparean')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
@endpush

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header">
    <div class="page-header-bg"></div>
    <div class="page-header-content">
        <div class="hero-eyebrow">Pengunjung Kami</div>
        <h1>Ulasan & <em>Testimoni</em></h1>
        <p>Cerita nyata dari para wisatawan yang telah merasakan keindahan Pasir Putih Parparean.</p>
    </div>
</section>

{{-- STATS --}}
<section class="reviews-stat-bar">
    <div class="reviews-stat-bar-inner">
        <div class="rsb-item">
            <span class="rsb-num">{{ $averageRating }}★</span>
            <span class="rsb-label">Rating Rata-rata</span>
        </div>
        <div class="rsb-divider"></div>
        <div class="rsb-item">
            <span class="rsb-num">{{ $total }}</span>
            <span class="rsb-label">Total Ulasan</span>
        </div>
        <div class="rsb-divider"></div>
        <div class="rsb-item">
            @auth
                @if(auth()->user()->role !== 'admin')
                    <a href="{{ route('reviews.create') }}" class="btn-primary-hero rsb-btn">
                        <i class="fas fa-star"></i> Tulis Ulasan
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-primary-hero rsb-btn">
                    <i class="fas fa-star"></i> Tulis Ulasan
                </a>
            @endauth
        </div>
    </div>
</section>

{{-- REVIEWS LIST --}}
<section class="reviews-page-section">
    <div class="reviews-page-inner">

        @if(session('success'))
            <div class="page-alert page-alert-success reveal">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="page-alert page-alert-error reveal">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @forelse($reviews as $review)
            <div class="review-card-full reveal">
                <div class="review-card-top">
                    <div class="review-author">
                        <div class="review-avatar">{{ strtoupper(substr($review->user->name ?? 'A', 0, 2)) }}</div>
                        <div>
                            <div class="review-name">{{ $review->user->name ?? 'Anonim' }}</div>
                            <div class="review-date">{{ $review->created_at->format('d F Y') }}</div>
                        </div>
                    </div>
                    <div class="review-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($review->rating >= $i)
                                <i class="fas fa-star star-filled"></i>
                            @else
                                <i class="far fa-star star-empty"></i>
                            @endif
                        @endfor
                    </div>
                </div>
                <div class="review-text">"{{ $review->comment }}"</div>
                <div class="review-card-footer">
                    @auth
                        @if(auth()->user()->id === $review->user_id)
                            <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                                onsubmit="return confirm('Hapus ulasan kamu?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-report" style="color:#ef4444; border-color:#ef4444;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @elseif(auth()->user()->role !== 'admin')
                            {{-- Tombol laporkan — buka modal --}}
                            <button type="button" class="btn-report"
                                onclick="openReportModal({{ $review->id }})">
                                <i class="fas fa-flag"></i> Laporkan
                                @if($review->reports_count > 0)
                                    <span class="report-count">({{ $review->reports_count }})</span>
                                @endif
                            </button>
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-comment-slash"></i>
                <p>Belum ada ulasan. Jadilah yang pertama!</p>
                <a href="{{ route('reviews.create') }}" class="btn-primary-hero empty-btn">Tulis Ulasan</a>
            </div>
        @endforelse

        <div class="pagination-wrap">
            {{ $reviews->links() }}
        </div>

    </div>
</section>

{{-- Modal Laporan --}}
@auth
<div id="reportModal"
    style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#1e293b;border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:32px;max-width:420px;width:90%;color:#f1f5f9;">
        <h5 style="margin:0 0 8px;font-size:1.1rem;color:#f1f5f9;">Laporkan Ulasan</h5>
        <p style="font-size:0.85rem;color:#94a3b8;margin-bottom:24px;line-height:1.6;">
            Pilih alasan pelaporan. Ulasan akan otomatis disembunyikan jika mendapat 5 laporan.
        </p>
        <form id="reportForm" method="POST">
            @csrf
            <div style="display:flex;flex-direction:column;gap:14px;margin-bottom:20px;">

                <label style="display:flex;align-items:center;gap:12px;cursor:pointer;color:#f1f5f9;font-size:0.9rem;">
                    <input type="radio" name="reason" value="spam" onchange="onReasonChange(this)">
                    Spam
                </label>

                <label style="display:flex;align-items:center;gap:12px;cursor:pointer;color:#f1f5f9;font-size:0.9rem;">
                    <input type="radio" name="reason" value="kata_kasar" onchange="onReasonChange(this)">
                    Kata Kasar
                </label>

                <label style="display:flex;align-items:center;gap:12px;cursor:pointer;color:#f1f5f9;font-size:0.9rem;">
                    <input type="radio" name="reason" value="tidak_relevan" onchange="onReasonChange(this)">
                    Tidak Relevan
                </label>

                <label style="display:flex;align-items:center;gap:12px;cursor:pointer;color:#f1f5f9;font-size:0.9rem;">
                    <input type="radio" name="reason" value="lainnya" onchange="onReasonChange(this)">
                    Lainnya
                </label>

            </div>

            {{-- Textbox opsional — muncul saat pilih Lainnya --}}
            <div id="noteBox" style="display:none;margin-bottom:20px;">
                <textarea name="note" rows="3"
                    placeholder="Jelaskan lebih lanjut (opsional)..."
                    style="width:100%;background:#0f172a;border:1px solid rgba(255,255,255,0.15);border-radius:10px;padding:12px;color:#f1f5f9;font-size:0.875rem;font-family:inherit;resize:none;box-sizing:border-box;">
                </textarea>
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" onclick="closeReportModal()" class="btn-outline-hero">Batal</button>
                <button type="submit" class="btn-primary-hero">
                    <i class="fas fa-flag"></i> Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openReportModal(reviewId) {
    const modal = document.getElementById('reportModal');
    const form  = document.getElementById('reportForm');
    form.action = '/reviews/' + reviewId + '/report';
    document.querySelectorAll('#reportForm input[type=radio]').forEach(r => r.checked = false);
    document.getElementById('noteBox').style.display = 'none';
    modal.style.display = 'flex';
}

function closeReportModal() {
    document.getElementById('reportModal').style.display = 'none';
}

function onReasonChange(radio) {
    const noteBox = document.getElementById('noteBox');
    noteBox.style.display = radio.value === 'lainnya' ? 'block' : 'none';
}

document.getElementById('reportModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeReportModal();
});
</script>
@endauth


@endsection
