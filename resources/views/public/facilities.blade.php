@extends('layouts.public')
@section('title', 'Fasilitas — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://pesonakota.com/wp-content/uploads/Harga-Tiket-Masuk-dan-Jam-Buka.png')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="color:var(--accent-light);justify-content:center;">Fasilitas</div>
        <h1>Semua yang Kamu <em>Butuhkan</em></h1>
        <p>Fasilitas lengkap untuk kenyamanan pengunjung</p>
    </div>
</section>

<section style="padding:80px 0;background:var(--white);">
    <div class="container">
        @forelse($facilities as $facility)
        <div class="facility-row reveal {{ $loop->even ? 'facility-row-reverse' : '' }}">
            <div class="facility-row-img">
                @if($facility->media)
                    <img src="{{ $facility->media->url }}" alt="{{ $facility->name }}">
                @else
                    <div class="facility-placeholder">
                        <i class="fas fa-{{ ['umbrella-beach','shower','parking','utensils','campground','ship','mosque','star'][$loop->index % 8] }}"></i>
                    </div>
                @endif
            </div>
            <div class="facility-row-content">
                <div class="facility-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                <h2>{{ $facility->name }}</h2>
                <p>{{ $facility->description }}</p>
            </div>
        </div>
        @empty
        <p style="text-align:center;color:var(--text-gray);padding:60px 0;">Belum ada fasilitas tersedia.</p>
        @endforelse
    </div>
</section>

@endsection
