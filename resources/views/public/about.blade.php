@extends('layouts.public')
@section('title', 'Tentang Kami — Pantai Pasir Putih Toba')
@section('content')

{{-- HERO --}}
<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1600&q=80')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center;color:var(--gold)">Tentang Kami</div>
        <h1>Mengenal <em>Pasir Putih Toba</em></h1>
        <p>Destinasi wisata alam terbaik di tepian Danau Toba, Sumatera Utara</p>
    </div>
</section>

{{-- DESKRIPSI --}}
<section class="about-full" style="padding:80px 0">
    <div class="container">
        <div class="about-grid">
            <div class="about-grid-img reveal">
                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80" alt="Pantai Pasir Putih Toba" style="width:100%;border-radius:16px;object-fit:cover;height:420px;">
            </div>
            <div class="about-grid-content reveal">
                <div class="section-label" style="color:var(--ocean)">Deskripsi</div>
                <h2>{{ $profile->name ?? 'Pantai Pasir Putih Toba' }}</h2>
                <p>{{ $profile->description ?? 'Pantai Pasir Putih Toba adalah destinasi wisata alam yang menawarkan keindahan tepi Danau Toba dengan hamparan pasir putih yang bersih dan pemandangan yang memukau.' }}</p>
                @if($profile?->established_year)
                <div class="stat-badge">
                    <span>Berdiri sejak</span>
                    <strong>{{ $profile->established_year }}</strong>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- SEJARAH --}}
@if($profile?->history)
<section style="background:var(--surface);padding:80px 0">
    <div class="container">
        <div class="section-label" style="color:var(--ocean)">Sejarah</div>
        <h2 style="margin-bottom:24px">Perjalanan Panjang <em>Kami</em></h2>
        <p style="max-width:720px;line-height:1.9;color:var(--text-muted)">{{ $profile->history }}</p>
    </div>
</section>
@endif

{{-- VISI MISI --}}
@if($profile?->vision || $profile?->mission)
<section style="padding:80px 0">
    <div class="container">
        <div class="vm-grid">
            @if($profile->vision)
            <div class="vm-card reveal">
                <div class="vm-icon"><i class="fas fa-eye"></i></div>
                <h3>Visi</h3>
                <p>{{ $profile->vision }}</p>
            </div>
            @endif
            @if($profile->mission)
            <div class="vm-card reveal">
                <div class="vm-icon"><i class="fas fa-bullseye"></i></div>
                <h3>Misi</h3>
                <p>{{ $profile->mission }}</p>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- PERATURAN --}}
@if($profile?->regulations)
<section style="background:var(--surface);padding:80px 0">
    <div class="container">
        <div class="section-label" style="color:var(--gold)">Tata Tertib</div>
        <h2 style="margin-bottom:32px">Peraturan <em>Kawasan Wisata</em></h2>
        <div class="regulations-box reveal">
            {!! nl2br(e($profile->regulations)) !!}
        </div>
    </div>
</section>
@endif

<style>
.page-hero{position:relative;height:420px;display:flex;align-items:center;justify-content:center;text-align:center;overflow:hidden}
.page-hero-bg{position:absolute;inset:0;background-size:cover;background-position:center}
.page-hero-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,30,60,.6),rgba(0,10,30,.8))}
.page-hero-content{position:relative;z-index:2;color:#fff;padding:0 24px}
.page-hero-content h1{font-size:clamp(2rem,5vw,3.5rem);margin:12px 0}
.page-hero-content p{opacity:.8;font-size:1.1rem}
.container{max-width:1100px;margin:0 auto;padding:0 24px}
.about-grid{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center}
.about-grid-content h2{font-size:2rem;margin:12px 0 20px}
.about-grid-content p{line-height:1.9;color:var(--text-muted)}
.stat-badge{display:inline-flex;flex-direction:column;background:var(--ocean);color:#fff;padding:16px 24px;border-radius:12px;margin-top:24px}
.stat-badge span{font-size:.8rem;opacity:.8;text-transform:uppercase;letter-spacing:1px}
.stat-badge strong{font-size:2rem;line-height:1}
.vm-grid{display:grid;grid-template-columns:1fr 1fr;gap:32px}
.vm-card{background:var(--surface);border:1px solid rgba(255,255,255,.08);border-radius:16px;padding:40px;transition:transform .3s}
.vm-card:hover{transform:translateY(-4px)}
.vm-icon{width:56px;height:56px;background:linear-gradient(135deg,var(--ocean),var(--gold));border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#fff;margin-bottom:20px}
.vm-card h3{font-size:1.4rem;margin-bottom:12px}
.vm-card p{color:var(--text-muted);line-height:1.8}
.regulations-box{background:var(--bg);border:1px solid rgba(255,255,255,.08);border-radius:16px;padding:40px;line-height:2;color:var(--text-muted)}
@media(max-width:768px){
    .about-grid,.vm-grid{grid-template-columns:1fr}
}
</style>
@endsection
