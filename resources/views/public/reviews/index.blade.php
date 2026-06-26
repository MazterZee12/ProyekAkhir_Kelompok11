@extends('layouts.public')

@section('title', 'Ulasan Pengunjung — Pasir Putih Parparean')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
@endpush

@section('content')

{{-- PAGE HERO --}}
<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://tobaria.com/wp-content/uploads/2021/04/IMG_20210415_144408-1024x576.jpg')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center">Pengunjung Kami</div>
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
                            @elseif($review->rating >= $i - 0.5)
                                <i class="fas fa-star-half-alt star-filled"></i>
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
                                <button type="submit" class="btn-report" style="color:#e05252;">
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
<div id="reportModal" class="report-modal">
    <div class="report-modal-card">
        <div class="report-modal-header">
            <h5>Laporkan Ulasan</h5>
            <button type="button" class="report-modal-close" onclick="closeReportModal()" aria-label="Tutup">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <p class="report-modal-desc">Pilih alasan pelaporan. Ulasan akan otomatis disembunyikan jika mendapat 5 laporan.</p>

        <form id="reportForm" method="POST">
            @csrf
            <div class="report-options">
                <label class="report-option">
                    <input type="radio" name="reason" value="spam" onchange="onReasonChange(this)"> Spam
                </label>
                <label class="report-option">
                    <input type="radio" name="reason" value="kata_kasar" onchange="onReasonChange(this)"> Kata Kasar
                </label>
                <label class="report-option">
                    <input type="radio" name="reason" value="tidak_relevan" onchange="onReasonChange(this)"> Tidak Relevan
                </label>
                <label class="report-option">
                    <input type="radio" name="reason" value="lainnya" onchange="onReasonChange(this)"> Lainnya
                </label>
            </div>

            <div id="noteBox" class="report-note-box">
                <textarea name="note" rows="3" class="report-textarea"
                    placeholder="Jelaskan lebih lanjut (opsional)..."></textarea>
            </div>

            <div class="report-modal-actions">
                <button type="button" onclick="closeReportModal()" class="btn-outline-hero form-btn">Batal</button>
                <button type="submit" class="btn-primary-hero form-btn">
                    <i class="fas fa-flag"></i> Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>
@endauth

@push('scripts')
    <script src="{{ asset('js/reviews.js') }}" defer></script>
@endpush

@endsection
