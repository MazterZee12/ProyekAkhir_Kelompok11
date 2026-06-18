@extends('layouts.public')
@section('title', 'FAQ — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS5gcpKipwVqFKMIX9FzasGIF9ca5XRoccTzg&s')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="color:var(--accent-light);justify-content:center;">FAQ</div>
        <h1>Pertanyaan yang <em>Sering Ditanyakan</em></h1>
        <p>Temukan jawaban atas pertanyaan umum seputar wisata kami</p>
    </div>
</section>

<section style="padding:80px 0;background:var(--cream);">
    <div class="container-sm">
        @forelse($faqs as $faq)
        <div class="faq-item reveal" onclick="toggleFaq(this)">
            <div class="faq-question">
                <span>{{ $faq->question }}</span>
                <div class="faq-icon"><i class="fas fa-plus"></i></div>
            </div>
            <div class="faq-answer">
                <p>{{ $faq->answer }}</p>
            </div>
        </div>
        @empty
        <p style="text-align:center;color:var(--text-gray);padding:60px 0;">Belum ada FAQ tersedia.</p>
        @endforelse
        <div class="faq-cta reveal">
            <h3>Masih punya pertanyaan?</h3>
            <p>Tim kami siap membantu menjawab pertanyaanmu.</p>
            <a href="{{ route('public.contact') }}" class="btn-primary-hero">Hubungi Kami</a>
        </div>
    </div>
</section>

@endsection
