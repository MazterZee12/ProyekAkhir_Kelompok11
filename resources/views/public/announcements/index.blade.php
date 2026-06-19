@extends('layouts.public')
@section('title', 'Pengumuman — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://pesonakota.com/wp-content/uploads/Harga-Tiket-Masuk-dan-Jam-Buka.png')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="color:var(--accent-light);justify-content:center;">Pengumuman</div>
        <h1>Info & <em>Berita Terbaru</em></h1>
        <p>Update terbaru seputar wisata dan kegiatan di Pasir Putih Parparean</p>
    </div>
</section>

<section style="padding:80px 0;background:var(--cream);">
    <div class="container">

        {{-- Filter tabs --}}
        <div class="filter-tabs reveal" style="margin-bottom:48px;">
            <a href="{{ route('public.announcements') }}"
               class="filter-tab {{ !request('type') ? 'active' : '' }}">
                <i class="fas fa-border-all"></i> Semua
            </a>
            <a href="{{ route('public.announcements', ['type' => 'event']) }}"
               class="filter-tab {{ request('type') === 'event' ? 'active' : '' }}">
                <i class="fas fa-calendar"></i> Event
            </a>
            <a href="{{ route('public.announcements', ['type' => 'promo']) }}"
               class="filter-tab {{ request('type') === 'promo' ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Promo
            </a>
            <a href="{{ route('public.announcements', ['type' => 'info']) }}"
               class="filter-tab {{ request('type') === 'info' ? 'active' : '' }}">
                <i class="fas fa-info-circle"></i> Info
            </a>
        </div>

        {{-- Grid --}}
        <div class="announcements-grid">
            @forelse($announcements as $announcement)
                <a href="{{ route('public.announcements.show', $announcement->id) }}"
                   class="ann-card reveal">

                    <div class="ann-img">
                        @if($announcement->photo)
                            <img src="{{ $announcement->photo->url }}" alt="{{ $announcement->title }}">
                        @else
                            <i class="fas fa-{{ $announcement->type === 'event' ? 'calendar' : ($announcement->type === 'promo' ? 'tags' : 'info-circle') }}"></i>
                        @endif
                        <span class="ann-type-badge ann-type-{{ $announcement->type }}">
                            {{ ucfirst($announcement->type) }}
                        </span>
                    </div>

                    <div class="ann-body">
                        <div class="ann-meta" style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                            <span style="font-size:0.72rem;color:var(--text-light);display:flex;align-items:center;gap:5px;">
                                <i class="far fa-calendar" style="color:var(--accent);"></i>
                                {{ $announcement->created_at->format('d M Y') }}
                            </span>
                            @if($announcement->views ?? false)
                                <span style="font-size:0.72rem;color:var(--text-light);display:flex;align-items:center;gap:5px;">
                                    <i class="far fa-eye" style="color:var(--accent);"></i>
                                    {{ number_format($announcement->views) }}
                                </span>
                            @endif
                        </div>
                        <h3 style="font-family:'Lora',serif;font-size:1.12rem;font-weight:600;color:var(--dark);margin-bottom:10px;line-height:1.38;">
                            {{ $announcement->title }}
                        </h3>
                        <p style="font-size:0.87rem;color:var(--text-gray);line-height:1.65;margin-bottom:14px;">
                            {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 120) }}
                        </p>
                        <span class="view-all" style="font-size:0.7rem;gap:6px;padding-bottom:2px;">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:80px 0;color:var(--text-gray);">
                    <i class="fas fa-bell-slash" style="font-size:2.5rem;opacity:0.3;display:block;margin-bottom:16px;"></i>
                    <p>Belum ada pengumuman{{ request('type') ? ' untuk kategori ini' : '' }}.</p>
                </div>
            @endforelse
        </div>

        @if($announcements->hasPages())
            <div style="margin-top:56px;display:flex;justify-content:center;">
                {{ $announcements->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
