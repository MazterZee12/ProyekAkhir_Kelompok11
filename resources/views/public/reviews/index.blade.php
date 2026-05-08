@extends('layouts.public')

@section('title', 'Ulasan Pengunjung — Pantai Pasir Putih Toba')

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
        <p>Cerita nyata dari para wisatawan yang telah merasakan keindahan Pantai Pasir Putih Toba.</p>
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
                        @elseif(auth()->user()->id !== $review->user_id && auth()->user()->role !== 'admin')
                            <form action="{{ route('reviews.report', $review) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-report"
                                    onclick="return confirm('Laporkan ulasan ini?')">
                                    <i class="fas fa-flag"></i> Laporkan
                                    @if($review->reports_count > 0)
                                        <span class="report-count">({{ $review->reports_count }})</span>
                                    @endif
                                </button>
                            </form>
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

@endsection
