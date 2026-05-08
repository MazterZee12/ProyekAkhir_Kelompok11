@extends('layouts.public')
@section('title', $announcement->title . ' — Pantai Pasir Putih Toba')
@section('content')

<section style="padding:60px 0 80px; background:var(--bg); min-height:calc(100vh - 72px)">
    <div class="container">
        <div class="ann-layout">

            {{-- MAIN --}}
            <div class="ann-main">
                <a href="{{ route('public.announcements') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> Kembali ke Pengumuman
                </a>

                <div class="ann-type-pill ann-type-{{ $announcement->type }}">
                    <i class="fas fa-{{ $announcement->type === 'event' ? 'calendar' : ($announcement->type === 'promo' ? 'tags' : 'info-circle') }}"></i>
                    {{ ucfirst($announcement->type) }}
                </div>

                <h1 class="ann-title reveal">{{ $announcement->title }}</h1>

                <div class="ann-meta-row">
                    <span><i class="far fa-calendar"></i> {{ $announcement->created_at->format('d F Y') }}</span>
                    <span><i class="far fa-eye"></i> {{ number_format($announcement->views) }} dilihat</span>
                    @if($announcement->starts_at)
                    <span><i class="fas fa-clock"></i> Mulai {{ \Carbon\Carbon::parse($announcement->starts_at)->format('d M Y') }}</span>
                    @endif
                    @if($announcement->ends_at)
                    <span><i class="fas fa-hourglass-end"></i> Hingga {{ \Carbon\Carbon::parse($announcement->ends_at)->format('d M Y') }}</span>
                    @endif
                </div>

                @if($announcement->photo_path)
                <div class="ann-cover reveal">
                    <img src="{{ asset('storage/'.$announcement->photo_path) }}" alt="{{ $announcement->title }}">
                </div>
                @endif

                <div class="ann-content reveal">
                    {!! nl2br(e($announcement->content)) !!}
                </div>

                @if($announcement->attachment_path)
                <div class="ann-attachment reveal">
                    <i class="fas fa-paperclip"></i>
                    <a href="{{ asset('storage/'.$announcement->attachment_path) }}" target="_blank">Unduh Lampiran</a>
                </div>
                @endif
            </div>

            {{-- SIDEBAR --}}
            <aside class="ann-sidebar">
                @if($related->count())
                <div class="sidebar-block">
                    <h4 class="sidebar-title">Pengumuman Terkait</h4>
                    @foreach($related as $rel)
                    <a href="{{ route('public.announcements.show', $rel->slug) }}" class="sidebar-item">
                        <div class="sidebar-item-type ann-type-{{ $rel->type }}">{{ ucfirst($rel->type) }}</div>
                        <div class="sidebar-item-title">{{ $rel->title }}</div>
                        <div class="sidebar-item-date">{{ $rel->created_at->format('d M Y') }}</div>
                    </a>
                    @endforeach
                </div>
                @endif

                <div class="sidebar-block">
                    <h4 class="sidebar-title">Info Wisata</h4>
                    <a href="{{ route('public.schedule') }}" class="sidebar-link"><i class="fas fa-clock"></i> Jam Operasional</a>
                    <a href="{{ route('public.pricing') }}" class="sidebar-link"><i class="fas fa-ticket-alt"></i> Harga Tiket</a>
                    <a href="{{ route('public.contact') }}" class="sidebar-link"><i class="fas fa-phone"></i> Hubungi Kami</a>
                </div>
            </aside>
        </div>
    </div>
</section>

<style>
.container{max-width:1100px;margin:0 auto;padding:0 24px}
.ann-layout{display:grid;grid-template-columns:1fr 320px;gap:48px;align-items:start}

/* Back link */
.back-link{display:inline-flex;align-items:center;gap:8px;color:var(--text-muted);text-decoration:none;font-size:.9rem;margin-bottom:28px;transition:color .2s}
.back-link:hover{color:var(--ocean)}
.back-link i{font-size:.8rem}

/* Type pill */
.ann-type-pill{display:inline-flex;align-items:center;gap:8px;font-size:.75rem;font-weight:700;padding:5px 14px;border-radius:50px;color:#fff;text-transform:uppercase;letter-spacing:.5px;margin-bottom:20px}
.ann-type-event{background:#1a4a8a}
.ann-type-promo{background:#8a4a00}
.ann-type-info{background:#1a6a4a}

/* Title */
.ann-title{font-size:clamp(1.8rem,4vw,2.6rem);line-height:1.3;margin:0 0 20px;color:#fff;font-weight:600}

/* Meta row */
/* Meta row */
.ann-meta-row{display:flex;flex-wrap:wrap;gap:16px;font-size:.85rem;color:rgba(255,255,255,.55);margin-bottom:32px;padding-bottom:24px;border-bottom:1px solid rgba(255,255,255,.08)}
.ann-meta-row span{display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.55)}
.ann-meta-row i{color:var(--ocean)}

/* Cover image */
.ann-cover{border-radius:16px;overflow:hidden;margin-bottom:32px;border:1px solid rgba(255,255,255,.06)}
.ann-cover img{width:100%;max-height:460px;object-fit:cover;display:block}

/* Content */
.ann-content{line-height:1.9;color:rgba(255,255,255,.75);font-size:1rem;background:var(--surface);border:1px solid rgba(255,255,255,.06);border-radius:16px;padding:32px}

/* Attachment */
.ann-attachment{margin-top:24px;display:flex;align-items:center;gap:12px;background:var(--surface);padding:16px 24px;border-radius:12px;border:1px solid rgba(255,255,255,.08)}
.ann-attachment i{color:var(--ocean);font-size:1.1rem}
.ann-attachment a{color:var(--ocean);text-decoration:none;font-size:.95rem;transition:opacity .2s}
.ann-attachment a:hover{opacity:.8}

/* Sidebar */
.ann-sidebar{position:sticky;top:100px}
.sidebar-block{background:var(--surface);border:1px solid rgba(255,255,255,.08);border-radius:16px;padding:24px;margin-bottom:20px}
.sidebar-title{font-size:.75rem;text-transform:uppercase;letter-spacing:1.5px;color:var(--text-muted);margin:0 0 16px;font-weight:600}

.sidebar-item{display:block;text-decoration:none;padding:12px 0;border-bottom:1px solid rgba(255,255,255,.06);transition:opacity .2s}
.sidebar-item:last-child{border-bottom:none;padding-bottom:0}
.sidebar-item:hover{opacity:.8}
.sidebar-item-type{font-size:.65rem;font-weight:700;text-transform:uppercase;color:#fff;padding:2px 10px;border-radius:50px;display:inline-block;margin-bottom:6px}
.sidebar-item-title{font-size:.9rem;color:#fff;margin-bottom:4px;line-height:1.4}
.sidebar-item-date{font-size:.8rem;color:var(--text-muted)}

.sidebar-link{display:flex;align-items:center;gap:10px;padding:11px 0;border-bottom:1px solid rgba(255,255,255,.06);text-decoration:none;color:rgba(255,255,255,.6);font-size:.9rem;transition:color .2s}
.sidebar-link:last-child{border-bottom:none;padding-bottom:0}
.sidebar-link:hover{color:#fff}
.sidebar-link i{color:var(--ocean);width:16px;text-align:center}

@media(max-width:900px){
    .ann-layout{grid-template-columns:1fr}
    .ann-sidebar{position:static}
}
</style>
@endsection
