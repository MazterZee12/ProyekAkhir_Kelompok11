@extends('layouts.public')
@section('title', 'Pengumuman — Pantai Pasir Putih Toba')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1471922694854-ff1b63b20054?w=1600&q=80')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center;color:var(--gold)">Pengumuman</div>
        <h1>Berita & <em>Event Terkini</em></h1>
        <p>Informasi terbaru seputar kawasan wisata Pantai Pasir Putih Toba</p>
    </div>
</section>

{{-- FILTER --}}
<section style="padding:40px 0 20px">
    <div class="container">
        <div class="filter-tabs">
            <a href="{{ route('public.announcements') }}" class="filter-tab {{ $type === 'all' ? 'active' : '' }}">Semua</a>
            <a href="{{ route('public.announcements', ['type' => 'event']) }}" class="filter-tab {{ $type === 'event' ? 'active' : '' }}"><i class="fas fa-calendar"></i> Event</a>
            <a href="{{ route('public.announcements', ['type' => 'promo']) }}" class="filter-tab {{ $type === 'promo' ? 'active' : '' }}"><i class="fas fa-tags"></i> Promo</a>
            <a href="{{ route('public.announcements', ['type' => 'info']) }}" class="filter-tab {{ $type === 'info' ? 'active' : '' }}"><i class="fas fa-info-circle"></i> Info</a>
        </div>
    </div>
</section>

<section style="padding:20px 0 80px">
    <div class="container">
        @forelse($announcements as $announcement)
        @if($loop->first)<div class="ann-grid">@endif

        <a href="{{ route('public.announcements.show', $announcement->slug) }}" class="ann-card reveal">
            <div class="ann-img">
                @if($announcement->photo_path)
                    <img src="{{ asset('storage/'.$announcement->photo_path) }}" alt="{{ $announcement->title }}">
                @else
                    <div class="ann-img-placeholder ann-type-{{ $announcement->type }}">
                        <i class="fas fa-{{ $announcement->type === 'event' ? 'calendar-star' : ($announcement->type === 'promo' ? 'tags' : 'bullhorn') }}"></i>
                    </div>
                @endif
                <div class="ann-type-badge ann-type-{{ $announcement->type }}">{{ ucfirst($announcement->type) }}</div>
            </div>
            <div class="ann-body">
                @if($announcement->is_featured)
                <div class="ann-featured-tag"><i class="fas fa-fire"></i> Unggulan</div>
                @endif
                <h3>{{ $announcement->title }}</h3>
                <p>{{ Str::limit($announcement->content, 120) }}</p>
                <div class="ann-meta">
                    <span><i class="far fa-calendar"></i> {{ $announcement->created_at->format('d M Y') }}</span>
                    <span><i class="far fa-eye"></i> {{ number_format($announcement->views) }}</span>
                </div>
            </div>
        </a>

        @if($loop->last)</div>@endif
        @empty
        <p style="text-align:center;color:var(--text-muted);padding:60px 0">Belum ada pengumuman.</p>
        @endforelse

        @if($announcements->hasPages())
        <div style="margin-top:48px;display:flex;justify-content:center">
            {{ $announcements->appends(['type' => $type])->links() }}
        </div>
        @endif
    </div>
</section>

<style>
.page-hero{position:relative;height:420px;display:flex;align-items:center;justify-content:center;text-align:center;overflow:hidden}
.page-hero-bg{position:absolute;inset:0;background-size:cover;background-position:center}
.page-hero-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,30,60,.6),rgba(0,10,30,.8))}
.page-hero-content{position:relative;z-index:2;color:#fff;padding:0 24px}
.page-hero-content h1{font-size:clamp(2rem,5vw,3.5rem);margin:12px 0}
.page-hero-content p{opacity:.8;font-size:1.1rem}
.container{max-width:1100px;margin:0 auto;padding:0 24px}
.filter-tabs{display:flex;gap:12px;flex-wrap:wrap}
.filter-tab{display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:50px;border:1px solid rgba(255,255,255,.15);color:var(--text-muted);text-decoration:none;font-size:.9rem;transition:all .3s}
.filter-tab:hover,.filter-tab.active{background:var(--ocean);border-color:var(--ocean);color:#fff}
.ann-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}
.ann-card{text-decoration:none;color:inherit;background:var(--surface);border-radius:16px;overflow:hidden;border:1px solid rgba(255,255,255,.06);transition:transform .3s,border-color .3s;display:block}
.ann-card:hover{transform:translateY(-6px);border-color:var(--ocean)}
.ann-img{position:relative;height:200px;overflow:hidden}
.ann-img img{width:100%;height:100%;object-fit:cover;transition:transform .4s}
.ann-card:hover .ann-img img{transform:scale(1.05)}
.ann-img-placeholder{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:3rem;color:rgba(255,255,255,.3)}
.ann-type-event{background:linear-gradient(135deg,#1a4a8a,#0e3a6c)}
.ann-type-promo{background:linear-gradient(135deg,#8a4a00,#6c3800)}
.ann-type-info{background:linear-gradient(135deg,#1a6a4a,#0e5a3c)}
.ann-type-badge{position:absolute;top:12px;left:12px;font-size:.75rem;font-weight:700;padding:4px 12px;border-radius:50px;color:#fff;text-transform:uppercase;letter-spacing:.5px}
.ann-body{padding:24px}
.ann-featured-tag{font-size:.75rem;color:var(--gold);margin-bottom:8px;display:flex;align-items:center;gap:6px}
.ann-body h3{font-size:1.05rem;margin:0 0 10px;line-height:1.4;color:#fff}
.ann-body p{font-size:.875rem;color:var(--text-muted);line-height:1.6;margin-bottom:16px}
.ann-meta{display:flex;gap:16px;font-size:.8rem;color:rgba(255,255,255,.35)}
.ann-meta i{margin-right:4px}
@media(max-width:900px){.ann-grid{grid-template-columns:1fr 1fr}}
@media(max-width:600px){.ann-grid{grid-template-columns:1fr}}
</style>
@endsection
