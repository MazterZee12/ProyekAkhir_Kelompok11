@extends('layouts.public')
@section('title', 'Kontak — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgdTRGVOhCDDRPoHoxZDGXvVQsVp78DJNcbf77h3hsW9xOMB0MvRxC4P-Kl8s9RCdTaxZ1Q1NQ8JKUfhKAihWRYCJbIUg0B3TlJyZ_WTROcKSwyyVdc5TD2j9Cr5lmPDMQzCJfPxiJaA3zN/s1600/pantai+parparean+toba+samosir.jpg')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="color:var(--accent-light);justify-content:center;">Kontak</div>
        <h1>Hubungi <em>Kami</em></h1>
        <p>Kami siap membantu pertanyaan dan kebutuhanmu</p>
    </div>
</section>

<section style="padding:80px 0;background:var(--white);">
    <div class="container">
        <div class="contact-layout">

            <div>
                <div class="section-label">Informasi Kontak</div>
                <h2 style="font-family:'Lora',serif;font-size:2rem;margin-bottom:32px;color:var(--dark);">Temukan <em>Kami</em></h2>

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
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}"
                           class="contact-item-value contact-link" target="_blank">{{ $contact->phone }}</a>
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

                @if($contact && ($contact->instagram || $contact->facebook || $contact->youtube || $contact->twitter))
                <div class="contact-socials reveal">
                    <div class="contact-item-label" style="margin-bottom:14px;">Media Sosial</div>
                    <div class="socials-row">
                        @if($contact->instagram)<a href="{{ $contact->instagram }}" target="_blank" class="social-btn instagram"><i class="fab fa-instagram"></i></a>@endif
                        @if($contact->facebook)<a href="{{ $contact->facebook }}" target="_blank" class="social-btn facebook"><i class="fab fa-facebook-f"></i></a>@endif
                        @if($contact->youtube)<a href="{{ $contact->youtube }}" target="_blank" class="social-btn youtube"><i class="fab fa-youtube"></i></a>@endif
                        @if($contact->twitter)<a href="{{ $contact->twitter }}" target="_blank" class="social-btn twitter"><i class="fab fa-x-twitter"></i></a>@endif
                    </div>
                </div>
                @endif

                <div class="contact-quick reveal">
                    <div class="contact-item-label" style="margin-bottom:14px;">Info Cepat</div>
                    <a href="{{ route('public.schedule') }}" class="quick-link"><i class="far fa-clock"></i> Jam Operasional</a>
                    <a href="{{ route('public.pricing') }}" class="quick-link"><i class="fas fa-ticket-alt"></i> Harga Tiket</a>
                    <a href="{{ route('public.faq') }}" class="quick-link"><i class="fas fa-question-circle"></i> Pertanyaan Umum</a>
                </div>
            </div>

            <div>
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

@endsection
