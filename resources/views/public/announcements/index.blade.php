@extends('layouts.public')
@section('title', 'Pengumuman — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://pesonakota.com/wp-content/uploads/Harga-Tiket-Masuk-dan-Jam-Buka.png')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="color:var(--accent-light);justify-content:center;">Pengumuman</div>
        <h1>Info & <em>Berita Terbaru</em></h1>
        <p>Update terbaru seputar wisata dan kegiatan</p>
    </div>
</section>

<section style="padding:80px 0;background:var(--white);">
    <div class="container">
        <div class="announcement-grid">
            @forelse($announcements as $announcement)
                <article class="announcement-card reveal">
                    @if($announcement->photo)
                        <a href="{{ route('public.announcements.show', $announcement->id) }}" class="announcement-thumb">
                            <img src="{{ $announcement->photo->url }}" alt="{{ $announcement->title }}">
                        </a>
                    @endif
                    <div class="announcement-body">
                        <div class="announcement-meta">
                            <span>{{ $announcement->created_at->format('d M Y') }}</span>
                            <span>{{ ucfirst($announcement->type) }}</span>
                        </div>
                        <h3>
                            <a href="{{ route('public.announcements.show', $announcement->id) }}">
                                {{ $announcement->title }}
                            </a>
                        </h3>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 140) }}</p>
                    </div>
                </article>
            @empty
                <p style="text-align:center;color:var(--text-gray);padding:60px 0;">Belum ada pengumuman.</p>
            @endforelse
        </div>

        @if($announcements->hasPages())
            <div style="margin-top:48px;display:flex;justify-content:center;">{{ $announcements->links() }}</div>
        @endif
    </div>
</section>

@endsection
