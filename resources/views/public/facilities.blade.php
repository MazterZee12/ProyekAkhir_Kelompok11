@extends('layouts.public')
@section('title', 'Fasilitas — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://pesonakota.com/wp-content/uploads/Harga-Tiket-Masuk-dan-Jam-Buka.png')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center;color:var(--gold)">Fasilitas</div>
        <h1>Semua yang Kamu <em>Butuhkan</em></h1>
        <p>Fasilitas lengkap untuk kenyamanan pengunjung</p>
    </div>
</section>

<section style="padding:80px 0">
    <div class="container">
        @forelse($facilities as $facility)
        <div class="facility-row reveal {{ $loop->even ? 'facility-row-reverse' : '' }}">
            <div class="facility-row-img">
                @if($facility->photo_path)
                    <img src="{{ asset('storage/'.$facility->photo_path) }}" alt="{{ $facility->name }}">
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
        <p style="text-align:center;color:var(--text-muted)">Belum ada fasilitas tersedia.</p>
        @endforelse
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
.facility-row{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;padding:60px 0;border-bottom:1px solid rgba(255,255,255,.06)}
.facility-row:last-child{border-bottom:none}
.facility-row-reverse{direction:rtl}
.facility-row-reverse>*{direction:ltr}
.facility-row-img img{width:100%;height:320px;object-fit:cover;border-radius:16px}
.facility-placeholder{width:100%;height:320px;background:linear-gradient(135deg,var(--ocean),var(--surface));border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:4rem;color:rgba(255,255,255,.3)}
.facility-number{font-size:4rem;font-weight:900;color:rgba(255,255,255,.06);line-height:1;margin-bottom:8px}
.facility-row-content h2{font-size:1.8rem;margin-bottom:16px}
.facility-row-content p{color:var(--text-muted);line-height:1.9}
@media(max-width:768px){
    .facility-row,.facility-row-reverse{grid-template-columns:1fr;direction:ltr}
}
</style>
@endsection
