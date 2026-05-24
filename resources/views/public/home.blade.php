@extends('layouts.public')

@section('title', 'Pasir Putih Parparean — Surga di Tepian Danau Toba')

@section('content')

{{-- HERO CAROUSEL --}}
<section class="hero" id="heroCarousel">
    @forelse($heroBanners as $i => $banner)
    <div class="hero-slide {{ $i === 0 ? 'active' : '' }}"
        style="background-image:url('{{ $banner->image_path && file_exists(storage_path('app/public/'.$banner->image_path))
            ? asset('storage/'.$banner->image_path)
            : 'https://tourismdanautoba.site/image/Pantai%20Pasir%20Putih%20Parparean.jpg' }}')">
    </div>
    @empty
    <div class="hero-slide active"
        style="background-image:url('https://tourismdanautoba.site/image/Pantai%20Pasir%20Putih%20Parparean.jpg')">
    </div>
    @endforelse

    <div class="hero-bg-overlay"></div>

    <div class="hero-content">
        @forelse($heroBanners as $i => $banner)
        <div class="hero-text {{ $i === 0 ? 'active' : '' }}">
            <div class="hero-center">
                <div class="hero-eyebrow">Danau Toba, Sumatera Utara</div>
                <h1>{{ $banner->title }}</h1>
                @if($banner->subtitle)
                <p>{{ $banner->subtitle }}</p>
                @endif
            </div>
            <div class="hero-btns-corner">
                <a href="{{ $banner->url ?? '#gallery' }}" class="btn-primary-hero">Jelajahi Sekarang</a>
                <a href="#facilities" class="btn-outline-hero">Lihat Fasilitas</a>
            </div>
        </div>
        @empty
        <div class="hero-text active">
            <div class="hero-center">
                <div class="hero-eyebrow">Danau Toba, Sumatera Utara</div>
                <h1>{{ $profile->name ?? 'Surga Tersembunyi di' }} <em>Tepian Toba</em></h1>
                <p>{{ $profile->description ?? 'Rasakan keindahan Pasir Putih Parparean.' }}</p>
            </div>
            <div class="hero-btns-corner">
                <a href="#gallery" class="btn-primary-hero">Jelajahi Sekarang</a>
                <a href="#facilities" class="btn-outline-hero">Lihat Fasilitas</a>
            </div>
        </div>
        @endforelse
    </div>

    @if($heroBanners->count() > 1)
    <div class="hero-dots">
        @foreach($heroBanners as $i => $banner)
        <button class="hero-dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}"></button>
        @endforeach
    </div>
    <button class="hero-arrow hero-prev" id="heroPrev"><i class="fas fa-chevron-left"></i></button>
    <button class="hero-arrow hero-next" id="heroNext"><i class="fas fa-chevron-right"></i></button>
    @endif

    <div class="hero-scroll">Scroll</div>
</section>

{{-- FEATURES --}}
<section class="features">
    <div class="features-grid">
        <div class="feature-item reveal">
            <div class="feature-icon"><i class="fas fa-umbrella-beach"></i></div>
            <h4>Pantai Bersih</h4>
            <p>Pasir putih bersih dengan pemandangan Danau Toba yang memukau setiap pengunjung.</p>
        </div>
        <div class="feature-item reveal">
            <div class="feature-icon"><i class="fas fa-ship"></i></div>
            <h4>Wisata Air</h4>
            <p>Nikmati berbagai aktivitas air seperti berenang, perahu, dan snorkeling di danau terbesar.</p>
        </div>
        <div class="feature-item reveal">
            <div class="feature-icon"><i class="fas fa-camera"></i></div>
            <h4>Spot Foto</h4>
            <p>Nikmati berbagai spot foto instagramable dengan latar pemandangan Danau Toba yang memukau.</p>
        </div>
        <div class="feature-item reveal">
            <div class="feature-icon"><i class="fas fa-home"></i></div>
            <h4>Budaya Batak</h4>
            <p>Rasakan kekayaan budaya dan tradisi Batak yang autentik di kawasan wisata Danau Toba.</p>
        </div>
    </div>
</section>

{{-- ABOUT --}}
<section class="about" id="about">
    <div class="about-image">
        <img src="https://zjglidcehtsqqqhbdxyp.supabase.co/storage/v1/object/public/atourin/images/destination/toba/pantai-pasir-putih-parparean-profile1670997298.jpeg?x-image-process=image/resize,p_100,limit_1/imageslim" alt="{{ $profile->name ?? 'Pasir Putih Parparean' }}">
    </div>
    <div class="about-content">
        <div class="section-label">Tentang Kami</div>
        <h2>Destinasi Wisata Terbaik di Kawasan Danau Toba</h2>
        @if($profile)
            <p>{{ $profile->history }}</p>
            <p>{{ $profile->vision }}</p>
        @else
            <p>Pasir Putih Parparean adalah destinasi wisata alam yang menawarkan keindahan tepi Danau Toba dengan hamparan pasir putih yang bersih dan pemandangan yang memukau.</p>
        @endif
        <div class="about-stats">
            <div class="stat-item">
                <h3>5K+</h3>
                <p>Pengunjung / Bulan</p>
            </div>
            <div class="stat-item">
                <h3>{{ number_format($avgRating, 1) }}</h3>
                <p>Rating Rata-rata</p>
            </div>
            <div class="stat-item">
                <h3>{{ $totalFacilities }}+</h3>
                <p>Fasilitas</p>
            </div>
        </div>
    </div>
</section>

{{-- GALLERY --}}
<section class="gallery-section" id="gallery">
    <div class="gallery-header reveal">
        <div class="gallery-header-top">
            <div>
                <div class="section-label" style="justify-content:center">Galeri</div>
                <h2>Keindahan yang <em>Tak Terlupakan</em></h2>
            </div>
            <a href="{{ url('/gallery') }}" class="view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
    <div class="bento-grid">
        @foreach($galleries->take(8) as $i => $gallery)
            <div class="bento-item bento-{{ $i + 1 }}">
                <img src="{{ asset('storage/'.$gallery->file_path) }}" alt="{{ $gallery->title ?? 'Galeri' }}">
            </div>
        @endforeach
    </div>
</section>

{{-- FACILITIES --}}
<section class="facilities-section" id="facilities">
    <div class="facilities-header reveal">
        <div>
            <div class="section-label" style="color:var(--ocean)">Fasilitas</div>
            <h2>Semua yang Kamu Butuhkan Ada di Sini</h2>
        </div>
        <a href="{{ url('/facilities') }}" class="view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="facilities-grid">
        @forelse($facilities->take(3) as $facility)
            <div class="facility-card reveal">
                <div class="facility-card-img">
                    @if($facility->photo_path)
                        <img src="{{ asset('storage/'.$facility->photo_path) }}" alt="{{ $facility->name }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600&q=80" alt="">
                    @endif
                </div>
                <div class="facility-card-body">
                    <h4>{{ $facility->name }}</h4>
                    <p>{{ Str::limit($facility->description, 100) }}</p>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada fasilitas.</p>
        @endforelse
    </div>
</section>

{{-- PRICING --}}
<section class="pricing-section" id="pricing">
    <div class="pricing-header reveal">
        <div class="section-label" style="justify-content:center; color:var(--gold)">Tiket Masuk</div>
        <h2>Harga Terjangkau, Pengalaman Tak Ternilai</h2>
        <p>Nikmati keindahan Pasir Putih Parparean dengan harga yang ramah di kantong</p>
    </div>
    <div class="pricing-grid">
        @forelse($prices->take(3) as $i => $price)
            <div class="price-card {{ $i === 1 ? 'featured' : '' }} reveal">
                <h4>{{ $price->unit }}</h4>
                <div class="price-amount">{{ number_format($price->amount / 1000, 0) }}K</div>
                <div class="price-unit">{{ $price->unit ?? 'per orang' }}</div>
                <div class="price-divider"></div>
                <div class="price-desc">{{ $price->notes }}</div>
            </div>
        @empty
            <p class="text-muted" style="color:rgba(255,255,255,0.5)">Belum ada harga.</p>
        @endforelse
    </div>
    <div class="pricing-footer reveal">
        <a href="{{ url('/pricing') }}" class="view-all-light">Lihat Semua Harga <i class="fas fa-arrow-right"></i></a>
    </div>
</section>

{{-- ANNOUNCEMENTS --}}
<section class="announcements-section" id="announcements">
    <div class="announcements-header reveal">
        <div>
            <div class="section-label" style="color:var(--ocean)">Pengumuman</div>
            <h2>Berita & Event Terkini</h2>
        </div>
        <a href="{{ url('/announcements') }}" class="view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="announcements-grid">
        @forelse($announcements->take(3) as $announcement)
            <div class="announcement-card reveal">
                <div class="announcement-img">
                    @if($announcement->photo_path)
                        <img src="{{ asset('storage/'.$announcement->photo_path) }}" alt="{{ $announcement->title }}">
                    @else
                        <i class="fas fa-{{ $announcement->type === 'event' ? 'calendar' : ($announcement->type === 'promo' ? 'tags' : 'info-circle') }}"></i>
                    @endif
                </div>
                <div class="announcement-body">
                    <div class="announcement-type">{{ ucfirst($announcement->type) }}</div>
                    <h4>{{ $announcement->title }}</h4>
                    <p>{{ Str::limit($announcement->content, 100) }}</p>
                    <div class="announcement-date">
                        <i class="far fa-calendar"></i>
                        {{ $announcement->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada pengumuman.</p>
        @endforelse
    </div>
</section>

{{-- REVIEWS --}}
<section class="reviews-section" id="reviews">
    <div class="reviews-header reveal">
        <div class="section-label" style="justify-content:center; color:var(--gold)">Ulasan</div>
        <h2>Apa Kata Pengunjung Kami</h2>
    </div>
    <div class="reviews-grid">
        @forelse($reviews->take(3) as $review)
            <div class="review-card reveal">
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
            </div>
        @empty
            <p style="color:rgba(255,255,255,0.5)">Belum ada ulasan.</p>
        @endforelse
    </div>
    <div class="reviews-footer reveal">
        <a href="{{ url('/reviews') }}" class="view-all-light">Lihat Semua Ulasan <i class="fas fa-arrow-right"></i></a>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="cta-bg" style="background-image: url('https://www.itrip.id/wp-content/uploads/2023/10/Alamat-Pantai-Pasir-Putih-Parparean.webp')"></div>
    <div class="cta-content reveal">
        <div class="section-label" style="justify-content:center; color:var(--gold)">Kunjungi Kami</div>
        <h2>Siap Merasakan <em>Keajaiban</em> Danau Toba?</h2>
        <p>Rencanakan kunjunganmu sekarang dan ciptakan kenangan indah bersama orang-orang tersayang.</p>
        <a href="{{ url('/contact') }}" class="btn-primary-hero">Hubungi Kami</a>
    </div>
</section>

@endsection
