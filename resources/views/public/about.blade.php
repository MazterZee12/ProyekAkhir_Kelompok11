@extends('layouts.public')
@section('title', 'Tentang Kami — Pasir Putih Parparean')

@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('{{ $profile?->media?->url ?? 'https://mistar.id/_next/image?url=https%3A%2F%2Ffiles-manager.mistar.id%2Fuploads%2FMISTAR%2F27-09-2025%2Fpantai_pasir_putih_parparean_di_toba_jadi_tempat_favorit_bersantai_keluarga_2025-09-27_16-55-46_2667.jpg&w=750&q=75' }}')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="color:var(--accent-light);justify-content:center;">Tentang Kami</div>
        <h1>Mengenal <em>Pasir Putih Parparean</em></h1>
        <p>Destinasi wisata alam terbaik di tepian Danau Toba, Sumatera Utara</p>
    </div>
</section>

{{-- DESKRIPSI — WHITE --}}
<section style="padding:80px 0;background:var(--white);">
    <div class="container">
        <div class="about-grid">
            <div class="reveal">
                @if($profile?->media)
                    <img
                        src="{{ $profile->media->url }}"
                        alt="Pasir Putih Parparean"
                        style="width:100%;height:420px;object-fit:cover;border-radius:2px;">
                @else
                    <img
                        src="https://www.ninna.id/wp-content/uploads/2021/11/pantai-landai-2.jpg"
                        alt="Pasir Putih Parparean"
                        style="width:100%;height:420px;object-fit:cover;border-radius:2px;">
                @endif
            </div>

            <div class="reveal">
                <div class="section-label">Deskripsi</div>
                <h2 style="font-size:2rem;margin:12px 0 20px;color:var(--dark);">
                    {{ $profile?->name ?? 'Pasir Putih Parparean' }}
                </h2>

                <p style="line-height:1.9;color:var(--text-gray);font-size:0.95rem;">
                    {{ $profile?->description ?? 'Pasir Putih Parparean adalah destinasi wisata alam yang menawarkan keindahan tepi Danau Toba dengan hamparan pasir putih yang bersih dan pemandangan yang memukau.' }}
                </p>

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

{{-- SEJARAH — TINT --}}
@if($profile?->history)
<section style="background:var(--tint);padding:80px 0;border-top:1px solid var(--tint-border);border-bottom:1px solid var(--tint-border);">
    <div class="container">
        <div class="section-label">Sejarah</div>
        <h2 style="font-size:2rem;margin-bottom:24px;color:var(--dark);">Perjalanan Panjang <em>Kami</em></h2>
        <p style="max-width:720px;line-height:1.9;color:var(--text-gray);font-size:0.95rem;">
            {{ $profile->history }}
        </p>
    </div>
</section>
@endif

{{-- VISI MISI — WHITE --}}
@if($profile?->vision || $profile?->mission)
<section style="padding:80px 0;background:var(--white);">
    <div class="container">
        <div class="vm-grid">
            @if($profile?->vision)
                <div class="vm-card reveal">
                    <div class="vm-icon"><i class="fas fa-eye"></i></div>
                    <h3>Visi</h3>
                    <p>{{ $profile->vision }}</p>
                </div>
            @endif

            @if($profile?->mission)
                <div class="vm-card reveal">
                    <div class="vm-icon"><i class="fas fa-bullseye"></i></div>
                    <h3>Misi</h3>
                    <p style="white-space:pre-line;">{{ $profile->mission }}</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- PERATURAN — CREAM --}}
@if($profile?->regulations)
<section style="background:var(--cream);padding:80px 0;border-top:1px solid var(--border);">
    <div class="container">
        <div class="section-label">Tata Tertib</div>
        <h2 style="font-size:2rem;margin-bottom:32px;color:var(--dark);">Peraturan <em>Kawasan Wisata</em></h2>
        <div class="regulations-box reveal">
            {!! nl2br(e($profile->regulations)) !!}
        </div>
    </div>
</section>
@endif

@endsection
