@extends('layouts.public')
@section('title', 'Galeri — Pantai Pasir Putih Toba')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1600&q=80')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center;color:var(--gold)">Galeri</div>
        <h1>Keindahan yang <em>Tak Terlupakan</em></h1>
        <p>Koleksi foto dan video destinasi wisata kami</p>
    </div>
</section>

{{-- FILTER --}}
<section style="padding:40px 0 20px">
    <div class="container">
        <div class="filter-tabs">
            <a href="{{ route('public.gallery') }}" class="filter-tab {{ $type === 'all' ? 'active' : '' }}">
                <i class="fas fa-th"></i> Semua
            </a>
            <a href="{{ route('public.gallery', ['type' => 'photo']) }}" class="filter-tab {{ $type === 'photo' ? 'active' : '' }}">
                <i class="fas fa-image"></i> Foto
            </a>
            <a href="{{ route('public.gallery', ['type' => 'video']) }}" class="filter-tab {{ $type === 'video' ? 'active' : '' }}">
                <i class="fas fa-video"></i> Video
            </a>
        </div>
    </div>
</section>

{{-- GALLERY GRID --}}
<section style="padding:20px 0 80px">
    <div class="container">
        @forelse($galleries as $gallery)
        @if($loop->first)<div class="gallery-masonry">@endif

        <div class="gallery-item reveal" onclick="openLightbox('{{ asset('storage/'.$gallery->file_path) }}','{{ $gallery->type }}','{{ addslashes($gallery->title ?? '') }}')">
            @if($gallery->type === 'video')
                <div class="gallery-item-inner video-thumb">
                    <div class="play-btn"><i class="fas fa-play"></i></div>
                    <div class="gallery-overlay">
                        <span class="gallery-type-badge"><i class="fas fa-video"></i> Video</span>
                        @if($gallery->title)<p>{{ $gallery->title }}</p>@endif
                    </div>
                </div>
            @else
                <div class="gallery-item-inner" style="background-image:url('{{ asset('storage/'.$gallery->file_path) }}')">
                    <div class="gallery-overlay">
                        <i class="fas fa-expand"></i>
                        @if($gallery->title)<p>{{ $gallery->title }}</p>@endif
                    </div>
                </div>
            @endif
        </div>

        @if($loop->last)</div>@endif
        @empty
        <p style="text-align:center;color:var(--text-muted);padding:60px 0">Belum ada item galeri.</p>
        @endforelse

        {{-- PAGINATION --}}
        @if($galleries->hasPages())
        <div style="margin-top:48px;display:flex;justify-content:center">
            {{ $galleries->appends(['type' => $type])->links() }}
        </div>
        @endif
    </div>
</section>

{{-- LIGHTBOX --}}
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <button class="lightbox-close" onclick="closeLightbox()"><i class="fas fa-times"></i></button>
    <div class="lightbox-inner" onclick="event.stopPropagation()">
        <img id="lightbox-img" src="" alt="" style="display:none">
        <video id="lightbox-video" controls style="display:none;max-width:100%;max-height:80vh"></video>
        <p id="lightbox-caption"></p>
    </div>
</div>

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
.gallery-masonry{columns:3;gap:16px}
.gallery-item{break-inside:avoid;margin-bottom:16px;cursor:pointer;border-radius:12px;overflow:hidden}
.gallery-item-inner{height:240px;background-size:cover;background-position:center;position:relative;transition:transform .4s}
.gallery-item:hover .gallery-item-inner{transform:scale(1.02)}
.gallery-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.7),transparent);display:flex;flex-direction:column;justify-content:flex-end;padding:16px;opacity:0;transition:opacity .3s;color:#fff}
.gallery-item:hover .gallery-overlay{opacity:1}
.gallery-overlay p{margin:4px 0 0;font-size:.9rem}
.gallery-type-badge{font-size:.75rem;background:rgba(255,255,255,.2);padding:3px 10px;border-radius:50px;align-self:flex-start}
.video-thumb{background:linear-gradient(135deg,#0a1628,#0e3a5c);display:flex;align-items:center;justify-content:center}
.play-btn{width:60px;height:60px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#fff;backdrop-filter:blur(4px);position:absolute}
.lightbox{display:none;position:fixed;inset:0;background:rgba(0,0,0,.95);z-index:1000;align-items:center;justify-content:center}
.lightbox.open{display:flex}
.lightbox-close{position:absolute;top:20px;right:20px;background:none;border:none;color:#fff;font-size:1.5rem;cursor:pointer}
.lightbox-inner{max-width:90vw;text-align:center}
.lightbox-inner img{max-width:100%;max-height:80vh;border-radius:8px}
#lightbox-caption{color:rgba(255,255,255,.7);margin-top:12px;font-size:.95rem}
@media(max-width:768px){.gallery-masonry{columns:2}}
@media(max-width:480px){.gallery-masonry{columns:1}}
</style>

<script>
function openLightbox(src, type, title) {
    const lb    = document.getElementById('lightbox');
    const img   = document.getElementById('lightbox-img');
    const video = document.getElementById('lightbox-video');
    const cap   = document.getElementById('lightbox-caption');
    if (type === 'video') {
        video.src = src; img.style.display = 'none'; video.style.display = 'block';
    } else {
        img.src = src; img.style.display = 'block'; video.style.display = 'none';
    }
    cap.textContent = title;
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
    document.getElementById('lightbox-video').pause();
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
</script>
@endsection
