@extends('layouts.public')
@section('title', 'Tulis Ulasan — Pasir Putih Parparean')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
@endpush

@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://tobaria.com/wp-content/uploads/2021/04/IMG_20210415_144408-1024x576.jpg')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center">Ulasan</div>
        <h1>Bagikan <em>Pengalamanmu</em></h1>
        <p>Ceritakan kesanmu selama berkunjung ke Pasir Putih Parparean</p>
    </div>
</section>

<section class="review-form-section">
    <div class="review-form-wrap">

        @if(session('success'))
            <div class="page-alert page-alert-success reveal"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        @if(session('info'))
            <div class="page-alert page-alert-info reveal"><i class="fas fa-info-circle"></i> {{ session('info') }}</div>
        @endif

        @if(session('error'))
            <div class="page-alert page-alert-error reveal"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="page-alert page-alert-error reveal"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif

        <div class="review-form-card reveal">

            <div class="rfc-header">
                <div class="review-avatar rfc-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                <div>
                    <div class="review-name rfc-name">{{ auth()->user()->name }}</div>
                    <div class="review-date">Menulis ulasan baru</div>
                </div>
            </div>

            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf

                <div class="form-block">
                    <div class="form-label">
                        <span>Tanggal Kunjungan <span class="required">*</span></span>
                    </div>
                    <input type="date"
                           name="visit_date"
                           id="visit_date"
                           class="date-input {{ $errors->has('visit_date') ? 'has-error' : '' }}"
                           value="{{ old('visit_date') }}"
                           max="{{ now()->format('Y-m-d') }}"
                           required>
                    @error('visit_date')
                        <div class="field-error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-block">
                    <div class="form-label">
                        <span>Rating Pengalamanmu <span class="required">*</span></span>
                    </div>
                    <div class="rating-row">
                        <div class="star-picker" id="starPicker">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="star-wrap" data-value="{{ $i }}">
                                    <span class="star-char">★</span>
                                    <button type="button" class="star-half star-half-left" data-value="{{ $i - 0.5 }}" aria-label="{{ $i - 0.5 }} bintang"></button>
                                    <button type="button" class="star-half star-half-right" data-value="{{ $i }}" aria-label="{{ $i }} bintang"></button>
                                </div>
                            @endfor
                        </div>
                        <span class="star-hint" id="starHint">Pilih rating</span>
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating') }}">
                    @error('rating')
                        <div class="field-error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-block">
                    <div class="form-label">
                        <span>Ceritakan Pengalamanmu <span class="required">*</span></span>
                        <span class="char-count" id="charCount">0 / 1000</span>
                    </div>
                    <textarea name="comment"
                              id="comment"
                              rows="6"
                              maxlength="1000"
                              class="{{ $errors->has('comment') ? 'has-error' : '' }}"
                              placeholder="Bagikan ceritamu tentang Pasir Putih Parparean. Minimal 10 karakter."
                              required>{{ old('comment') }}</textarea>
                    @error('comment')
                        <div class="field-error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('reviews.index') }}" class="btn-outline-hero form-btn">Batal</a>
                    <button type="submit" class="btn-primary-hero form-btn">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>

        @if($userReviews->isNotEmpty())
        <div class="review-history-card reveal">
            <div class="rh-title"><i class="fas fa-clock-rotate-left"></i> Ulasan kamu sebelumnya</div>
            <div class="rh-list">
                @foreach($userReviews as $r)
                    <div class="rh-row">
                        <span>{{ $r->visit_date->format('d M Y') }} — {{ $r->rating }}★</span>
                        @if($r->isEditable())
                            <a href="{{ route('reviews.edit', $r) }}">Edit</a>
                        @else
                            <span class="rh-locked">Terkunci</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

@push('scripts')
    <script src="{{ asset('js/reviews.js') }}" defer></script>
@endpush

@endsection
