@extends('layouts.public')
@section('title', 'Galeri — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://www.switour.com/wp-content/uploads/2022/08/Pantai-Pasir-Putih-Parparean-3-1024x541.jpeg')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="color:var(--accent-light);justify-content:center;">Galeri</div>
        <h1>Keindahan yang <em>Tak Terlupakan</em></h1>
        <p>Koleksi foto destinasi wisata kami</p>
    </div>
</section>

<section style="padding:48px 0 80px;background:var(--cream);">
    <div class="container">
        @forelse($galleries as $gallery)
        @if($loop->first)<div class="gallery-masonry">@endif

        <div class="gallery-item reveal"
             @if($gallery->media)
             onclick="openLightbox('{{ $gallery->media->url }}','{{ addslashes($gallery->title ?? '') }}')"
             @endif>
            <div class="gallery-item-inner" style="background-image:url('{{ $gallery->media?->url }}')">
                <div class="gallery-overlay">
                    <i class="fas fa-expand"></i>
                    @if($gallery->title)<p>{{ $gallery->title }}</p>@endif
                </div>
            </div>
        </div>

        @if($loop->last)</div>@endif
        @empty
        <p style="text-align:center;color:var(--text-gray);padding:60px 0;">Belum ada item galeri.</p>
        @endforelse

        @if($galleries->hasPages())
        <div style="margin-top:48px;display:flex;justify-content:center;">{{ $galleries->links() }}</div>
        @endif
    </div>
</section>

<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <button class="lightbox-close" onclick="closeLightbox()"><i class="fas fa-times"></i></button>
    <div class="lightbox-inner" onclick="event.stopPropagation()">
        <img id="lightbox-img" src="" alt="" style="display:none">
        <p id="lightbox-caption"></p>
    </div>
</div>

@endsection
