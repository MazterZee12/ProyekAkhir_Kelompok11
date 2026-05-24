@extends('layouts.public')
@section('title', 'Kontak — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgdTRGVOhCDDRPoHoxZDGXvVQsVp78DJNcbf77h3hsW9xOMB0MvRxC4P-Kl8s9RCdTaxZ1Q1NQ8JKUfhKAihWRYCJbIUg0B3TlJyZ_WTROcKSwyyVdc5TD2j9Cr5lmPDMQzCJfPxiJaA3zN/s1600/pantai+parparean+toba+samosir.jpg')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center;color:var(--gold)">Kontak</div>
        <h1>Hubungi <em>Kami</em></h1>
        <p>Kami siap membantu pertanyaan dan kebutuhanmu</p>
    </div>
</section>

<section style="padding:80px 0; background:var(--bg); min-height:calc(100vh - 72px)">
    <div class="container">
        <div class="contact-layout">

            {{-- INFO KONTAK --}}
            <div class="contact-info">
                <div class="section-label" style="color:var(--ocean)">Informasi Kontak</div>
                <h2 style="margin-bottom:32px">Temukan <em>Kami</em></h2>

                @if($contact?->address)
                <div class="contact-item reveal">
                    <div class="contact-item-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <div class="contact-item-label">Alamat</div>
                        <div class="contact-item-value">{{ $contact->address }}</div>
                    </div>
                </div>
                @endif

                @if($contact?->phone)
                <div class="contact-item reveal">
                    <div class="contact-item-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <div class="contact-item-label">Telepon / WhatsApp</div>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}" class="contact-item-value contact-link" target="_blank">
                            {{ $contact->phone }}
                        </a>
                    </div>
                </div>
                @endif

                @if($contact?->email)
                <div class="contact-item reveal">
                    <div class="contact-item-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="contact-item-label">Email</div>
                        <a href="mailto:{{ $contact->email }}" class="contact-item-value contact-link">{{ $contact->email }}</a>
                    </div>
                </div>
                @endif

                {{-- SOSMED --}}
                @if($contact && ($contact->instagram || $contact->facebook || $contact->youtube || $contact->twitter))
                <div class="contact-socials reveal">
                    <div class="contact-item-label" style="margin-bottom:16px">Media Sosial</div>
                    <div class="socials-row">
                        @if($contact->instagram)
                        <a href="{{ $contact->instagram }}" target="_blank" class="social-btn instagram" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        @if($contact->facebook)
                        <a href="{{ $contact->facebook }}" target="_blank" class="social-btn facebook" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        @if($contact->youtube)
                        <a href="{{ $contact->youtube }}" target="_blank" class="social-btn youtube" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        @endif
                        @if($contact->twitter)
                        <a href="{{ $contact->twitter }}" target="_blank" class="social-btn twitter" title="Twitter / X">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                {{-- QUICK LINKS --}}
                <div class="contact-quick reveal">
                    <div class="contact-item-label" style="margin-bottom:16px">Info Cepat</div>
                    <a href="{{ route('public.schedule') }}" class="quick-link"><i class="far fa-clock"></i> Jam Operasional</a>
                    <a href="{{ route('public.pricing') }}" class="quick-link"><i class="fas fa-ticket-alt"></i> Harga Tiket</a>
                    <a href="{{ route('public.faq') }}" class="quick-link"><i class="fas fa-question-circle"></i> Pertanyaan Umum</a>
                </div>
            </div>

            {{-- PETA --}}
            <div class="contact-map-area">
                @if($contact?->google_maps_embed)
                <div class="map-wrapper reveal">
                    <div class="map-label"><i class="fas fa-map-pin"></i> Lokasi Kami</div>
                    {!! $contact->google_maps_embed !!}
                </div>
                @else
                <div class="map-placeholder reveal">
                    <i class="fas fa-map-marked-alt"></i>
                    <p>Peta lokasi belum tersedia</p>
                </div>
                @endif
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

.container{max-width:1100px;margin:0 auto;padding:0 40px}
.contact-layout{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:start}

/* Contact items */
.contact-item{display:flex;gap:16px;align-items:flex-start;margin-bottom:28px}
.contact-item-icon{width:44px;height:44px;background:linear-gradient(135deg,var(--ocean),#0a5a8a);border-radius:12px;display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0;font-size:1rem}
.contact-item-label{font-size:.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.8px;margin-bottom:4px}
.contact-item-value{color:#fff;line-height:1.6;font-size:.95rem}
.contact-link{color:var(--ocean);text-decoration:none;transition:opacity .2s}
.contact-link:hover{opacity:.8}

/* Social */
.contact-socials,.contact-quick{margin-bottom:32px}
.socials-row{display:flex;gap:12px;flex-wrap:wrap}
.social-btn{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem;text-decoration:none;transition:transform .2s,opacity .2s}
.social-btn:hover{transform:translateY(-3px);opacity:.85}
.instagram{background:linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888)}
.facebook{background:#1877f2}
.youtube{background:#ff0000}
.twitter{background:#000}

/* Quick links */
.quick-link{display:flex;align-items:center;gap:10px;padding:12px 0;border-bottom:1px solid rgba(255,255,255,.06);text-decoration:none;color:var(--text-muted);font-size:.9rem;transition:color .2s}
.quick-link:last-child{border-bottom:none}
.quick-link:hover{color:#fff}
.quick-link i{color:var(--ocean);width:16px;text-align:center}

/* Map */
.map-wrapper{background:var(--surface);border:1px solid rgba(255,255,255,.08);border-radius:16px;overflow:hidden;padding:24px}
.map-label{font-size:.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.8px;margin-bottom:16px;display:flex;align-items:center;gap:8px}
.map-label i{color:var(--ocean)}
.map-wrapper iframe{width:100%;height:420px;border-radius:10px;border:0;display:block}
.map-placeholder{height:420px;background:var(--surface);border:1px solid rgba(255,255,255,.08);border-radius:16px;display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--text-muted);gap:12px}
.map-placeholder i{font-size:3rem;opacity:.4}
.map-placeholder p{font-size:1rem;margin:0;opacity:.6}

@media(max-width:800px){
    .container{padding:0 24px}
    .contact-layout{grid-template-columns:1fr}
}
</style>
@endsection
