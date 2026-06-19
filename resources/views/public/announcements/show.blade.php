@extends('layouts.public')
@section('title', $announcement->title . ' — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg"
        style="background-image:url('{{ $announcement->photo?->url ?? 'https://pesonakota.com/wp-content/uploads/Harga-Tiket-Masuk-dan-Jam-Buka.png' }}')">
    </div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="color:var(--accent-light);justify-content:center;">
            {{ ucfirst($announcement->type) }}
        </div>
        <h1>{{ $announcement->title }}</h1>
        <p style="opacity:0.65;font-size:0.88rem;display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;">
            <span><i class="far fa-calendar"></i> {{ $announcement->created_at->format('d F Y') }}</span>
            @if($announcement->views ?? false)
                <span><i class="far fa-eye"></i> {{ number_format($announcement->views) }} dilihat</span>
            @endif
        </p>
    </div>
</section>

<section style="padding:72px 0 96px;background:var(--cream);">
    <div class="container">

        <div class="ann-detail-layout">

            {{-- Main content --}}
            <div class="ann-detail-main">

                <a href="{{ route('public.announcements') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> Kembali ke Pengumuman
                </a>

                <div style="display:inline-flex;align-items:center;gap:8px;margin-bottom:24px;">
                    <span class="ann-type-badge ann-type-{{ $announcement->type }}"
                          style="position:static;font-size:0.7rem;">
                        <i class="fas fa-{{ $announcement->type === 'event' ? 'calendar' : ($announcement->type === 'promo' ? 'tags' : 'info-circle') }}"></i>
                        {{ ucfirst($announcement->type) }}
                    </span>
                </div>

                @if($announcement->photo)
                    <div class="ann-detail-cover reveal">
                        <img src="{{ $announcement->photo->url }}" alt="{{ $announcement->title }}">
                    </div>
                @endif

                <div class="ann-detail-content reveal">
                    {!! nl2br(e($announcement->content)) !!}
                </div>

                {{-- Share / back --}}
                <div style="margin-top:40px;padding-top:32px;border-top:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                    <a href="{{ route('public.announcements') }}" class="back-link" style="margin-bottom:0;">
                        <i class="fas fa-arrow-left"></i> Semua Pengumuman
                    </a>
                    <div style="display:flex;gap:8px;">
                        <a href="{{ url('/contact') }}" class="view-all" style="font-size:0.72rem;gap:8px;">
                            Ada pertanyaan? <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <aside class="ann-detail-sidebar">

                @if($related->count())
                    <div class="ann-sidebar-block">
                        <h4 class="ann-sidebar-title">Pengumuman Terkait</h4>
                        @foreach($related as $rel)
                            <a href="{{ route('public.announcements.show', $rel->id) }}"
                               class="ann-sidebar-item">
                                <span class="ann-type-badge ann-type-{{ $rel->type }}"
                                      style="position:static;font-size:0.6rem;margin-bottom:6px;">
                                    {{ ucfirst($rel->type) }}
                                </span>
                                <div class="ann-sidebar-item-title">{{ $rel->title }}</div>
                                <div class="ann-sidebar-item-date">
                                    <i class="far fa-calendar"></i> {{ $rel->created_at->format('d M Y') }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="ann-sidebar-block">
                    <h4 class="ann-sidebar-title">Info Wisata</h4>
                    <a href="{{ route('public.pricing') }}" class="ann-sidebar-link">
                        <i class="fas fa-ticket-alt"></i> Harga Tiket
                    </a>
                    <a href="{{ route('public.facilities') }}" class="ann-sidebar-link">
                        <i class="fas fa-umbrella-beach"></i> Fasilitas
                    </a>
                    <a href="{{ route('public.contact') }}" class="ann-sidebar-link">
                        <i class="fas fa-phone"></i> Hubungi Kami
                    </a>
                </div>

                <div class="ann-sidebar-block" style="background:var(--dark);border-color:var(--dark);text-align:center;">
                    <div class="section-label" style="justify-content:center;color:var(--accent-light);margin-bottom:12px;">
                        Kunjungi Kami
                    </div>
                    <p style="font-size:0.85rem;color:rgba(255,255,255,0.55);margin-bottom:20px;line-height:1.7;">
                        Pasir Putih Parparean buka setiap hari. Cek jadwal dan harga sebelum datang.
                    </p>
                    <a href="{{ route('public.pricing') }}" class="btn-primary-hero"
                       style="font-size:0.72rem;padding:12px 22px;display:inline-flex;">
                        Lihat Harga <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

            </aside>

        </div>
    </div>
</section>

@push('styles')
<style>
.ann-detail-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 48px;
    align-items: start;
}
.ann-detail-main {
    min-width: 0;
}
.ann-detail-cover {
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 32px;
    border: 1px solid var(--border);
}
.ann-detail-cover img {
    width: 100%;
    max-height: 480px;
    object-fit: cover;
    display: block;
}
.ann-detail-content {
    background: var(--white);
    border: 1px solid var(--border);
    border-left: 3px solid var(--accent);
    border-radius: 10px;
    padding: 36px 40px;
    line-height: 2;
    color: var(--text-gray);
    font-size: 0.95rem;
}
.ann-detail-sidebar {
    position: sticky;
    top: 100px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.ann-sidebar-block {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 24px;
}
.ann-sidebar-title {
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--accent);
    margin: 0 0 16px;
    font-weight: 700;
    font-family: 'Figtree', sans-serif;
}
.ann-sidebar-item {
    display: block;
    text-decoration: none;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
    transition: opacity 0.2s;
}
.ann-sidebar-item:last-child { border-bottom: none; padding-bottom: 0; }
.ann-sidebar-item:hover { opacity: 0.75; }
.ann-sidebar-item-title {
    font-size: 0.88rem;
    color: var(--dark);
    margin-bottom: 4px;
    line-height: 1.4;
    font-weight: 500;
}
.ann-sidebar-item-date {
    font-size: 0.75rem;
    color: var(--text-light);
    display: flex;
    align-items: center;
    gap: 5px;
}
.ann-sidebar-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 0;
    border-bottom: 1px solid var(--border);
    text-decoration: none;
    color: var(--text-gray);
    font-size: 0.88rem;
    transition: color 0.2s, padding-left 0.2s;
}
.ann-sidebar-link:last-child { border-bottom: none; padding-bottom: 0; }
.ann-sidebar-link:hover { color: var(--dark); padding-left: 4px; }
.ann-sidebar-link i { color: var(--accent); width: 16px; text-align: center; }
@media (max-width: 900px) {
    .ann-detail-layout { grid-template-columns: 1fr; }
    .ann-detail-sidebar { position: static; }
    .ann-detail-content { padding: 24px; }
}
</style>
@endpush

@endsection
