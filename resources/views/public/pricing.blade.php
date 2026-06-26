@extends('layouts.public')
@section('title', 'Harga Tiket — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgdTRGVOhCDDRPoHoxZDGXvVQsVp78DJNcbf77h3hsW9xOMB0MvRxC4P-Kl8s9RCdTaxZ1Q1NQ8JKUfhKAihWRYCJbIUg0B3TlJyZ_WTROcKSwyyVdc5TD2j9Cr5lmPDMQzCJfPxiJaA3zN/s1600/pantai+parparean+toba+samosir.jpg')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="color:var(--accent-light);justify-content:center;">Tiket & Harga</div>
        <h1>Harga Terjangkau, <em>Pengalaman Tak Ternilai</em></h1>
        <p>Informasi lengkap harga tiket masuk dan sewa fasilitas</p>
    </div>
</section>

<section style="padding:80px 0;background:var(--white);">
    <div class="container">
        <div class="section-label">Tiket Masuk</div>
        <h2 style="font-family:'Lora',serif;font-size:2rem;margin-bottom:40px;color:var(--dark);">Harga <em>Tiket</em></h2>
        <div class="pricing-cards">
            @forelse($tickets as $i => $ticket)
                <button
                    type="button"
                    class="pricing-card reveal js-detail-card {{ $i === 1 ? 'pricing-card-featured' : '' }}"
                    data-detail-type="price"
                    data-title="{{ $ticket->unit }}"
                    data-badge="Tiket Masuk"
                    data-meta="Rp{{ number_format($ticket->amount, 0, ',', '.') }}"
                    data-description="{{ e($ticket->notes ?? 'Tidak ada keterangan tambahan.') }}"
                    data-image=""
                >
                    @if($i === 1)<div class="pricing-badge">Populer</div>@endif
                    <div class="pricing-icon"><i class="fas fa-ticket-alt"></i></div>
                    <div class="pricing-amount">Rp{{ number_format($ticket->amount, 0, ',', '.') }}</div>
                    <div class="pricing-unit">{{ $ticket->unit }}</div>
                    <div class="pricing-divider"></div>
                    @if($ticket->notes)
                        <p class="pricing-notes">{{ $ticket->notes }}</p>
                    @endif
                </button>
            @empty
                <p style="color:var(--text-gray);">Belum ada informasi harga tiket.</p>
            @endforelse
        </div>
    </div>
</section>

@if($rentals->count())
<section style="background:var(--tint);padding:80px 0;border-top:1px solid var(--tint-border);border-bottom:1px solid var(--tint-border);">
    <div class="container">
        <div class="section-label">Sewa Fasilitas</div>
        <h2 style="font-family:'Lora',serif;font-size:2rem;margin-bottom:40px;color:var(--dark);">Harga <em>Sewa</em></h2>
        <div class="rental-grid">
            @foreach($rentals as $rental)
                <button
                    type="button"
                    class="rental-card reveal js-detail-card"
                    data-detail-type="price"
                    data-title="{{ $rental->unit }}"
                    data-badge="Sewa Fasilitas"
                    data-meta="Rp{{ number_format($rental->amount, 0, ',', '.') }}"
                    data-description="{{ e($rental->notes ?? 'Tidak ada keterangan tambahan.') }}"
                    data-image="{{ $rental->media?->url ?? '' }}"
                >
                    @if($rental->media)
                        <div class="rental-img">
                            <img src="{{ $rental->media->url }}" alt="{{ $rental->unit }}">
                        </div>
                    @endif
                    <div class="rental-body">
                        <div class="rental-unit">{{ $rental->unit }}</div>
                        <div class="rental-price">Rp{{ number_format($rental->amount, 0, ',', '.') }}</div>
                        @if($rental->notes)
                            <p class="rental-notes">{{ $rental->notes }}</p>
                        @endif
                    </div>
                </button>
            @endforeach
        </div>
    </div>
</section>
@endif

<section style="padding:60px 0;background:var(--cream);">
    <div class="container">
        <div class="info-box reveal">
            <div class="info-box-icon"><i class="fas fa-info-circle"></i></div>
            <div>
                <h4>Informasi Penting</h4>
                <ul>
                    <li>Harga dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya.</li>
                    <li>Tiket yang sudah dibeli tidak dapat dikembalikan.</li>
                    <li>Anak di bawah 5 tahun gratis masuk.</li>
                    <li>Untuk informasi lebih lanjut, silakan hubungi kami.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- DETAIL MODAL --}}
<div class="detail-modal" id="detailModal" aria-hidden="true">
    <div class="detail-modal-backdrop" data-close-modal></div>
    <div class="detail-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="detailModalTitle">
        <button type="button" class="detail-modal-close" data-close-modal>
            <i class="fas fa-times"></i>
        </button>
        <div class="detail-modal-image-wrap">
            <img id="detailModalImage" alt="" style="display:none;">
        </div>
        <div class="detail-modal-body">
            <div class="detail-modal-badge" id="detailModalBadge"></div>
            <h3 id="detailModalTitle"></h3>
            <div class="detail-modal-meta" id="detailModalMeta"></div>
            <p class="detail-modal-description" id="detailModalDescription"></p>
        </div>
    </div>
</div>

@endsection
