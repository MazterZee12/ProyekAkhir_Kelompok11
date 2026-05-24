@extends('layouts.public')
@section('title', 'Harga Tiket — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgdTRGVOhCDDRPoHoxZDGXvVQsVp78DJNcbf77h3hsW9xOMB0MvRxC4P-Kl8s9RCdTaxZ1Q1NQ8JKUfhKAihWRYCJbIUg0B3TlJyZ_WTROcKSwyyVdc5TD2j9Cr5lmPDMQzCJfPxiJaA3zN/s1600/pantai+parparean+toba+samosir.jpg')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center;color:var(--gold)">Tiket & Harga</div>
        <h1>Harga Terjangkau, <em>Pengalaman Tak Ternilai</em></h1>
        <p>Informasi lengkap harga tiket masuk dan sewa fasilitas</p>
    </div>
</section>

{{-- TIKET MASUK --}}
<section style="padding:80px 0">
    <div class="container">
        <div class="section-label" style="color:var(--ocean)">Tiket Masuk</div>
        <h2 style="margin-bottom:40px">Harga <em>Tiket</em></h2>
        <div class="pricing-cards">
            @forelse($tickets as $i => $ticket)
            <div class="pricing-card reveal {{ $i === 1 ? 'pricing-card-featured' : '' }}">
                @if($i === 1)<div class="pricing-badge">Populer</div>@endif
                <div class="pricing-icon"><i class="fas fa-ticket-alt"></i></div>
                <div class="pricing-amount">Rp{{ number_format($ticket->amount, 0, ',', '.') }}</div>
                <div class="pricing-unit">{{ $ticket->unit }}</div>
                <div class="pricing-divider"></div>
                @if($ticket->notes)
                <p class="pricing-notes">{{ $ticket->notes }}</p>
                @endif
            </div>
            @empty
            <p style="color:var(--text-muted)">Belum ada informasi harga tiket.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- SEWA FASILITAS --}}
@if($rentals->count())
<section style="background:var(--surface);padding:80px 0">
    <div class="container">
        <div class="section-label" style="color:var(--gold)">Sewa Fasilitas</div>
        <h2 style="margin-bottom:40px">Harga <em>Sewa</em></h2>
        <div class="rental-grid">
            @foreach($rentals as $rental)
            <div class="rental-card reveal">
                @if($rental->photo_path)
                <div class="rental-img">
                    <img src="{{ asset('storage/'.$rental->photo_path) }}" alt="{{ $rental->unit }}">
                </div>
                @endif
                <div class="rental-body">
                    <div class="rental-unit">{{ $rental->unit }}</div>
                    <div class="rental-price">Rp{{ number_format($rental->amount, 0, ',', '.') }}</div>
                    @if($rental->notes)
                    <p class="rental-notes">{{ $rental->notes }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- NOTE --}}
<section style="padding:60px 0">
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

<style>
.page-hero{position:relative;height:420px;display:flex;align-items:center;justify-content:center;text-align:center;overflow:hidden}
.page-hero-bg{position:absolute;inset:0;background-size:cover;background-position:center}
.page-hero-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,30,60,.6),rgba(0,10,30,.8))}
.page-hero-content{position:relative;z-index:2;color:#fff;padding:0 24px}
.page-hero-content h1{font-size:clamp(2rem,5vw,3.5rem);margin:12px 0}
.page-hero-content p{opacity:.8;font-size:1.1rem}
.container{max-width:1100px;margin:0 auto;padding:0 24px}
.pricing-cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:24px}
.pricing-card{background:var(--surface);border:1px solid rgba(255,255,255,.08);border-radius:20px;padding:36px 28px;text-align:center;position:relative;transition:transform .3s}
.pricing-card:hover{transform:translateY(-6px)}
.pricing-card-featured{background:linear-gradient(135deg,var(--ocean),#0a5a8a);border-color:var(--ocean);transform:scale(1.04)}
.pricing-card-featured:hover{transform:scale(1.04) translateY(-4px)}
.pricing-badge{position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:var(--gold);color:#000;font-size:.75rem;font-weight:700;padding:4px 16px;border-radius:50px;white-space:nowrap}
.pricing-icon{font-size:2rem;color:var(--gold);margin-bottom:16px}
.pricing-amount{font-size:2rem;font-weight:800;color:#fff;line-height:1}
.pricing-unit{font-size:.85rem;color:rgba(255,255,255,.5);margin-top:4px;text-transform:uppercase;letter-spacing:1px}
.pricing-divider{height:1px;background:rgba(255,255,255,.1);margin:20px 0}
.pricing-notes{font-size:.875rem;color:rgba(255,255,255,.6);line-height:1.6;text-align:left}
.rental-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:24px}
.rental-card{background:var(--bg);border:1px solid rgba(255,255,255,.08);border-radius:16px;overflow:hidden;transition:transform .3s}
.rental-card:hover{transform:translateY(-4px)}
.rental-img img{width:100%;height:180px;object-fit:cover}
.rental-body{padding:24px}
.rental-unit{font-size:.85rem;color:var(--gold);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px}
.rental-price{font-size:1.6rem;font-weight:800;color:#fff;margin-bottom:12px}
.rental-notes{font-size:.875rem;color:var(--text-muted);line-height:1.6}
.info-box{display:flex;gap:24px;background:var(--surface);border:1px solid rgba(255,255,255,.08);border-left:4px solid var(--ocean);border-radius:12px;padding:32px}
.info-box-icon{font-size:1.5rem;color:var(--ocean);flex-shrink:0;margin-top:2px}
.info-box h4{margin:0 0 12px;font-size:1.1rem}
.info-box ul{margin:0;padding-left:20px;color:var(--text-muted);line-height:2}
@media(max-width:600px){.pricing-cards{grid-template-columns:1fr 1fr}.pricing-card-featured{transform:none}}
</style>
@endsection
