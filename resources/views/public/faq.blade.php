@extends('layouts.public')
@section('title', 'FAQ — Pantai Pasir Putih Toba')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1471922694854-ff1b63b20054?w=1600&q=80')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center;color:var(--gold)">FAQ</div>
        <h1>Pertanyaan yang <em>Sering Ditanyakan</em></h1>
        <p>Temukan jawaban atas pertanyaan umum seputar wisata kami</p>
    </div>
</section>

<section style="padding:80px 0">
    <div class="container">
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
        <p style="text-align:center;color:var(--text-muted);padding:60px 0">Belum ada FAQ tersedia.</p>
        @endforelse

        <div class="faq-cta reveal">
            <h3>Masih punya pertanyaan?</h3>
            <p>Tim kami siap membantu menjawab pertanyaanmu.</p>
            <a href="{{ route('public.contact') }}" class="btn-primary-hero">Hubungi Kami</a>
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
.container{max-width:800px;margin:0 auto;padding:0 24px}
.faq-item{background:var(--surface);border:1px solid rgba(255,255,255,.08);border-radius:14px;margin-bottom:12px;overflow:hidden;cursor:pointer;transition:border-color .3s}
.faq-item.open{border-color:var(--ocean)}
.faq-question{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:22px 28px;font-size:1rem;font-weight:600;color:#fff}
.faq-icon{width:32px;height:32px;background:rgba(255,255,255,.06);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:transform .3s,background .3s}
.faq-item.open .faq-icon{transform:rotate(45deg);background:var(--ocean)}
.faq-answer{max-height:0;overflow:hidden;transition:max-height .4s ease,padding .3s}
.faq-item.open .faq-answer{max-height:400px;padding-bottom:4px}
.faq-answer p{padding:0 28px 22px;color:var(--text-muted);line-height:1.8;margin:0;font-size:.95rem}
.faq-cta{text-align:center;margin-top:64px;padding:48px;background:linear-gradient(135deg,var(--ocean),#0a5a8a);border-radius:20px}
.faq-cta h3{font-size:1.6rem;margin:0 0 12px;color:#fff}
.faq-cta p{color:rgba(255,255,255,.7);margin-bottom:28px}
</style>

<script>
function toggleFaq(el) {
    const isOpen = el.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(item => item.classList.remove('open'));
    if (!isOpen) el.classList.add('open');
}
</script>
@endsection
