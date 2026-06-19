@extends('layouts.public')
@section('title', 'Pasir Putih Parparean')
@section('content')

{{-- HERO --}}
<section class="hero" id="heroCarousel">

    @if($heroBanners->count())
        @foreach($heroBanners as $i => $banner)
            <div class="hero-slide {{ $i === 0 ? 'active' : '' }}"
                style="background-image:url('{{ $banner->media?->url ?? 'https://tourismdanautoba.site/image/Pantai%20Pasir%20Putih%20Parparean.jpg' }}')">
            </div>
        @endforeach
    @else
        <div class="hero-slide active"
            style="background-image:url('https://tourismdanautoba.site/image/Pantai%20Pasir%20Putih%20Parparean.jpg')">
        </div>
    @endif

    <div class="hero-bg-overlay"></div>

    <div class="hero-content">

        @if($heroBanners->count())
            @foreach($heroBanners as $i => $banner)
                <div class="hero-text {{ $i === 0 ? 'active' : '' }}">
                    <div class="hero-center">
                        <div class="hero-eyebrow">Danau Toba, Sumatera Utara</div>
                        <h1>{{ $banner->title }}</h1>
                        @if($banner->subtitle)
                            <p>{{ $banner->subtitle }}</p>
                        @endif
                    </div>
                    <div class="hero-btns-corner">
                        <a href="#gallery" class="btn-primary-hero">Jelajahi Sekarang</a>
                        <a href="#facilities" class="btn-outline-hero">Lihat Fasilitas</a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="hero-text active">
                <div class="hero-center">
                    <div class="hero-eyebrow">Danau Toba, Sumatera Utara</div>
                    <h1>Pantai Pasir Putih <em>Parparean</em></h1>
                    <p>Nikmati hamparan pasir putih yang luas, panorama Danau Toba yang menenangkan, serta berbagai fasilitas wisata yang nyaman untuk keluarga maupun rombongan.</p>
                </div>
                <div class="hero-btns-corner">
                    <a href="#gallery" class="btn-primary-hero">Jelajahi Sekarang</a>
                    <a href="#facilities" class="btn-outline-hero">Lihat Fasilitas</a>
                </div>
            </div>
        @endif

    </div>

    @if($heroBanners->count() > 1)
        <div class="hero-dots">
            @foreach($heroBanners as $i => $banner)
                <button class="hero-dot {{ $i === 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>
        <button class="hero-arrow hero-prev" id="heroPrev">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="hero-arrow hero-next" id="heroNext">
            <i class="fas fa-chevron-right"></i>
        </button>
    @endif

    <div class="hero-scroll">Scroll</div>

</section>

{{-- FEATURES --}}
<section class="features">
    <div class="features-grid">
        <div class="feature-item reveal">
            <div class="feature-icon"><i class="fas fa-umbrella-beach"></i></div>
            <h4>Pantai Bersih</h4>
            <p>Hamparan pasir putih yang selalu terjaga, langsung menghadap birunya Danau Toba.</p>
        </div>
        <div class="feature-item reveal">
            <div class="feature-icon"><i class="fas fa-ship"></i></div>
            <h4>Wisata Air</h4>
            <p>Berenang, naik perahu, sampai banana boat — semua bisa dicoba di tepi danau vulkanik terbesar di dunia ini.</p>
        </div>
        <div class="feature-item reveal">
            <div class="feature-icon"><i class="fas fa-camera"></i></div>
            <h4>Spot Foto</h4>
            <p>Banyak sudut foto kece dengan latar Danau Toba, pas buat konten medsos kamu.</p>
        </div>
        <div class="feature-item reveal">
            <div class="feature-icon"><i class="fas fa-home"></i></div>
            <h4>Budaya Batak</h4>
            <p>Sambil liburan, kamu juga bisa kenalan langsung dengan budaya dan tradisi Batak yang masih kental di sini.</p>
        </div>
    </div>
</section>

{{-- ABOUT --}}
<section class="about" id="about">
    <div class="about-image reveal">
        <img
            src="{{ $profile?->media?->url ?? 'https://zjglidcehtsqqqhbdxyp.supabase.co/storage/v1/object/public/atourin/images/destination/toba/pantai-pasir-putih-parparean-profile1670997298.jpeg' }}"
            alt="{{ $profile->name ?? 'Pasir Putih Parparean' }}">
    </div>
    <div class="about-content reveal">
        <div class="section-label">Tentang Kami</div>
        <h2>Kenalan Lebih Dekat dengan Pasir Putih Parparean</h2>
        @if($profile)
            <p>{{ $profile->history }}</p>
            <p>{{ $profile->vision }}</p>
        @else
            <p>Pasir Putih Parparean jadi salah satu spot favorit di pinggir Danau Toba — pantainya berpasir putih, airnya tenang, dan pemandangannya bikin betah berlama-lama.</p>
        @endif
        <div class="about-stats">
            <div class="stat-item"><h3>5K+</h3><p>Pengunjung / Bulan</p></div>
            <div class="stat-item"><h3>{{ number_format($avgRating, 1) }}</h3><p>Rating Rata-rata</p></div>
            <div class="stat-item"><h3>{{ $totalFacilities }}+</h3><p>Fasilitas</p></div>
        </div>
    </div>
</section>

{{-- GALLERY --}}
<section class="gallery-section" id="gallery">
    <div class="gallery-header-top">
        <div>
            <div class="section-label">Galeri</div>
            <h2>Momen-Momen di <em>Pasir Putih Parparean</em></h2>
        </div>
        <a href="{{ url('/gallery') }}" class="view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="bento-grid">
        @forelse($galleries->take(5) as $i => $gallery)
            <button
                type="button"
                class="bento-item bento-{{ $i + 1 }} reveal js-detail-card"
                data-detail-type="gallery"
                data-title="{{ $gallery->title ?? 'Galeri' }}"
                data-badge="Galeri"
                data-meta="{{ $gallery->title ?? '' }}"
                data-description="{{ e($gallery->description ?? 'Tidak ada deskripsi.') }}"
                data-image="{{ $gallery->media?->url ?? 'https://via.placeholder.com/800x600?text=Galeri' }}"
            >
                <img
                    src="{{ $gallery->media?->url ?? 'https://via.placeholder.com/800x600?text=Galeri' }}"
                    alt="{{ $gallery->title ?? 'Galeri' }}">
            </button>
        @empty
            <div class="reveal" style="color:var(--text-gray);padding:1rem 0;">
                Belum ada foto galeri.
            </div>
        @endforelse
    </div>
</section>

{{-- FACILITIES --}}
<section class="facilities-section" id="facilities">
    <div class="facilities-header reveal">
        <div>
            <div class="section-label">Fasilitas</div>
            <h2>Fasilitas Lengkap, Liburan Jadi Nyaman</h2>
        </div>
        <a href="{{ url('/facilities') }}" class="view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="facilities-grid">
        @forelse($facilities->take(3) as $facility)
            <button
                type="button"
                class="facility-card reveal js-detail-card"
                data-detail-type="facility"
                data-title="{{ $facility->name }}"
                data-badge="Fasilitas"
                data-meta="Klik untuk melihat detail"
                data-description="{{ e($facility->description ?? 'Tidak ada deskripsi.') }}"
                data-image="{{ $facility->media?->url ?? 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600&q=80' }}"
            >
                <div class="facility-card-img">
                    @if($facility->media)
                        <img src="{{ $facility->media->url }}" alt="{{ $facility->name }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600&q=80" alt="{{ $facility->name }}">
                    @endif
                </div>
                <div class="facility-card-body">
                    <h4>{{ $facility->name }}</h4>
                    <p>{{ \Illuminate\Support\Str::limit($facility->description, 100) }}</p>
                </div>
            </button>
        @empty
            <p style="color:var(--text-gray);">Belum ada fasilitas.</p>
        @endforelse
    </div>
</section>

{{-- PRICING --}}
<section class="pricing-section" id="pricing">
    <div class="pricing-header reveal">
        <div class="section-label">Tiket Masuk</div>
        <h2>Tiket Masuk yang <em>Ramah di Kantong</em></h2>
        <p>Nggak perlu mahal buat menikmati keindahan Pasir Putih Parparean.</p>
    </div>

    <div class="pricing-grid">
        @forelse($prices->take(3) as $i => $price)
            <button
                type="button"
                class="price-card {{ $i === 1 ? 'featured' : '' }} reveal js-detail-card"
                data-detail-type="price"
                data-title="{{ $price->unit }}"
                data-badge="Harga Tiket"
                data-meta="{{ $price->formatted_amount }}"
                data-description="{{ e($price->notes ?? 'Tidak ada keterangan tambahan.') }}"
                data-image=""
            >
                <h4>{{ $price->unit }}</h4>
                <div class="price-amount">{{ number_format($price->amount / 1000, 0) }}K</div>
                <div class="price-unit">{{ $price->unit }}</div>
                <div class="price-divider"></div>
                <div class="price-desc">{{ $price->notes }}</div>
            </button>
        @empty
            <p style="color:var(--text-gray);">Belum ada harga.</p>
        @endforelse
    </div>

    <div class="pricing-footer reveal">
        <a href="{{ url('/pricing') }}" class="view-all">Lihat Semua Harga <i class="fas fa-arrow-right"></i></a>
    </div>
</section>

{{-- ANNOUNCEMENTS --}}
<section class="announcements-section" id="announcements">
    <div class="announcements-header reveal">
        <div>
            <div class="section-label">Pengumuman</div>
            <h2>Berita & Event Terkini</h2>
        </div>
        <a href="{{ url('/announcements') }}" class="view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="announcements-grid">
        @forelse($announcements->take(3) as $announcement)
            <a href="{{ route('public.announcements.show', $announcement->id) }}"
               class="ann-card reveal">
                <div class="ann-img">
                    @if($announcement->photo)
                        <img src="{{ $announcement->photo->url }}" alt="{{ $announcement->title }}">
                    @else
                        <i class="fas fa-{{ $announcement->type === 'event' ? 'calendar' : ($announcement->type === 'promo' ? 'tags' : 'info-circle') }}" style="font-size:2.5rem;opacity:0.4;"></i>
                    @endif
                    <span class="ann-type-badge ann-type-{{ $announcement->type }}">
                        {{ ucfirst($announcement->type) }}
                    </span>
                </div>
                <div class="ann-body">
                    <div class="ann-meta" style="font-size:0.72rem;color:var(--text-light);margin-bottom:8px;display:flex;align-items:center;gap:6px;">
                        <i class="far fa-calendar" style="color:var(--accent);"></i>
                        {{ $announcement->created_at->format('d M Y') }}
                    </div>
                    <h4>{{ $announcement->title }}</h4>
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 100) }}</p>
                </div>
            </a>
        @empty
            <p style="color:var(--text-gray);">Belum ada pengumuman.</p>
        @endforelse
    </div>
</section>

{{-- REVIEWS --}}
<section class="reviews-section" id="reviews">
    <div class="reviews-header reveal">
        <div class="section-label">Ulasan</div>
        <h2>Apa Kata <em>Pengunjung</em> Kami</h2>
    </div>

    <div class="reviews-grid">
        @forelse($reviews->take(3) as $review)
            <button
                type="button"
                class="review-card reveal js-detail-card"
                data-detail-type="review"
                data-title="{{ $review->user->name ?? 'Anonim' }}"
                data-badge="{{ number_format($review->rating, 1) }} / 5"
                data-meta="{{ $review->created_at->format('d M Y') }}"
                data-description="{{ e($review->comment ?? 'Tidak ada komentar.') }}"
                data-image=""
            >
                <div class="review-stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($review->rating >= $i)
                            <i class="fas fa-star"></i>
                        @elseif($review->rating >= $i - 0.5)
                            <i class="fas fa-star-half-alt"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <div class="review-text">"{{ $review->comment }}"</div>
                <div class="review-author">
                    <div class="review-avatar">{{ strtoupper(substr($review->user->name ?? 'A', 0, 2)) }}</div>
                    <div>
                        <div class="review-name">{{ $review->user->name ?? 'Anonim' }}</div>
                        <div class="review-date">{{ $review->created_at->format('F Y') }}</div>
                    </div>
                </div>
            </button>
        @empty
            <p style="color:var(--text-gray);">Belum ada ulasan.</p>
        @endforelse
    </div>

    <div class="reviews-footer reveal">
        <a href="{{ url('/reviews') }}" class="view-all">Lihat Semua Ulasan <i class="fas fa-arrow-right"></i></a>
    </div>
</section>

{{-- INFORMATION REQUEST CTA --}}
<section class="ir-cta-section reveal">
    <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.85);">Butuh Bantuan?</div>
    <h3>Punya Pertanyaan Tentang Pasir Putih Parparean?</h3>
    <p>Tim kami siap menjawab pertanyaanmu seputar fasilitas, harga, hingga jadwal kunjungan.</p>
    @auth
        <a href="{{ route('information-requests.create') }}" class="ir-btn">
            <i class="fas fa-question-circle"></i> Ajukan Permintaan Informasi
        </a>
    @else
        <a href="{{ route('login') }}" class="ir-btn">
            <i class="fas fa-lock"></i> Login untuk Mengajukan Pertanyaan
        </a>
    @endauth
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="cta-bg" style="background-image:url('https://www.itrip.id/wp-content/uploads/2023/10/Alamat-Pantai-Pasir-Putih-Parparean.webp')"></div>
    <div class="cta-content reveal">
        <div class="section-label" style="justify-content:center;color:var(--accent-light);">Kunjungi Kami</div>
        <h2>Sudah Siap ke <em>Pasir Putih Parparean</em>?</h2>
        <p>Atur jadwal liburanmu dari sekarang, dan buat kenangan baru bersama keluarga atau teman-teman.</p>
        <a href="{{ url('/contact') }}" class="btn-primary-hero">Hubungi Kami</a>
    </div>
</section>

{{-- LIGHTBOX GALERI --}}
<div class="lightbox" id="lightbox">
    <button class="lightbox-close" id="lightboxClose">
        <i class="fas fa-times"></i>
    </button>
    <div class="lightbox-inner">
        <img id="lightbox-img" src="" alt="" style="display:none;">
        <p id="lightbox-caption"></p>
    </div>
</div>

{{-- UNIVERSAL DETAIL MODAL --}}
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
