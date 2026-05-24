@extends('layouts.public')
@section('title', 'Tulis Ulasan — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZnjkNXFEsHmn8hQSSkOe0XVmyLx5xMPOD0g&s')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center;color:var(--gold)">Ulasan</div>
        <h1>Bagikan <em>Pengalamanmu</em></h1>
        <p>Ceritakan kesanmu selama berkunjung ke Pasir Putih Parparean</p>
    </div>
</section>

<section style="padding:80px 0">
    <div class="container-sm">

        @if(session('success'))
        <div class="alert-success reveal"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="alert-error reveal"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif

        <div class="create-form reveal">
            <div class="create-form-header">
                <div class="section-label" style="color:var(--ocean)">{{ $userReview ? 'Edit Ulasan' : 'Tulis Ulasan' }}</div>
                <h2>{{ $userReview ? 'Perbarui Ulasanmu' : 'Apa Kesanmu?' }}</h2>
                <p style="color:var(--text-muted)">Ulasanmu membantu pengunjung lain mengetahui lebih lanjut tentang destinasi wisata kami.</p>
            </div>

            <form action="{{ route('reviews.index') }}" method="POST">
                @csrf

                {{-- STAR RATING --}}
                <div class="star-section">
                    <label>Rating Pengalamanmu <span style="color:red">*</span></label>
                    <div class="stars-input" id="starsInput">
                        @for($i = 1; $i <= 5; $i++)
                        <div class="star-wrap" data-value="{{ $i }}">
                            <button type="button" class="star-half left-half" data-value="{{ $i - 0.5 }}"></button>
                            <button type="button" class="star-half right-half" data-value="{{ $i }}"></button>
                            <i class="fas fa-star star-icon" id="star-{{ $i }}"></i>
                            <span class="star-label">{{ ['Buruk','Kurang','Cukup','Bagus','Luar Biasa'][$i-1] }}</span>
                        </div>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="{{ $userReview->rating ?? old('rating') }}">
                    @error('rating')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- KOMENTAR --}}
                <div class="form-group">
                    <label>Ceritakan Pengalamanmu <span style="color:red">*</span></label>
                    <textarea name="comment" rows="6" class="form-input" placeholder="Bagikan ceritamu tentang Pasir Putih Parparean Minimal 10 karakter." required>{{ $userReview->comment ?? old('comment') }}</textarea>
                    @error('comment')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('reviews.index') }}" class="btn-outline-hero">Batal</a>
                    <button type="submit" class="btn-primary-hero">
                        <i class="fas fa-paper-plane"></i>
                        {{ $userReview ? 'Perbarui Ulasan' : 'Kirim Ulasan' }}
                    </button>
                </div>
            </form>
        </div>

        {{-- INFO --}}
        <div class="create-info reveal">
            <div class="create-info-icon"><i class="fas fa-shield-alt"></i></div>
            <div>
                <strong>Ulasan kamu aman</strong>
                <p>Ulasan yang tidak pantas dapat dihapus oleh admin. Harap berikan ulasan yang jujur dan sopan.</p>
            </div>
        </div>
    </div>
</section>

<style>
.page-hero{position:relative;height:360px;display:flex;align-items:center;justify-content:center;text-align:center;overflow:hidden}
.page-hero-bg{position:absolute;inset:0;background-size:cover;background-position:center}
.page-hero-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,30,60,.6),rgba(0,10,30,.8))}
.page-hero-content{position:relative;z-index:2;color:#fff;padding:0 24px}
.page-hero-content h1{font-size:clamp(1.8rem,4vw,3rem);margin:12px 0}
.page-hero-content p{opacity:.8}
.container-sm{max-width:680px;margin:0 auto;padding:0 24px}
.alert-success,.alert-error{padding:14px 20px;border-radius:10px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:.9rem}
.alert-success{background:rgba(0,200,100,.1);border:1px solid rgba(0,200,100,.3);color:#00c864}
.alert-error{background:rgba(200,50,50,.1);border:1px solid rgba(200,50,50,.3);color:#e05252}
.create-form{background:var(--surface);border:1px solid rgba(255,255,255,.08);border-radius:20px;padding:40px;margin-bottom:20px}
.create-form-header{margin-bottom:32px}
.create-form-header h2{font-size:1.8rem;margin:8px 0 12px}
.star-section{margin-bottom:28px}
.star-section label{display:block;font-size:.9rem;color:var(--text-muted);margin-bottom:14px}
.stars-input{display:flex;gap:12px}
.star-wrap{position:relative;display:flex;flex-direction:column;align-items:center;cursor:pointer;width:64px}
.star-icon{font-size:2rem;color:rgba(255,255,255,.2);pointer-events:none;transition:color .15s}
.star-icon.half{background:linear-gradient(90deg, var(--gold) 50%, rgba(255,255,255,.2) 50%);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.star-icon.full{color:var(--gold)}
.star-half{position:absolute;top:0;width:50%;height:32px;background:none;border:none;cursor:pointer;z-index:2;padding:0}
.left-half{left:0}
.right-half{right:0}
.star-label{font-size:.6rem; font-weight:600; text-transform:uppercase; letter-spacing:.5px; color:var(--text-muted); margin-top:4px; text-align:center; white-space:nowrap;}
.form-group{margin-bottom:24px}
.form-group label{display:block;font-size:.9rem;color:var(--text-muted);margin-bottom:8px}
.form-input{width:100%;background:var(--bg);border:1px solid rgba(255,255,255,.1);border-radius:12px;padding:14px 18px;color:#fff;font-size:.95rem;font-family:inherit;transition:border-color .2s;box-sizing:border-box;resize:vertical}
.form-input:focus{outline:none;border-color:var(--ocean)}
.field-error{color:#e05252;font-size:.8rem;margin-top:6px}
.form-actions{display:flex;gap:12px;justify-content:flex-end}
.create-info{display:flex;gap:16px;align-items:flex-start;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:20px 24px}
.create-info-icon{color:var(--ocean);font-size:1.2rem;margin-top:2px;flex-shrink:0}
.create-info strong{display:block;margin-bottom:4px;font-size:.9rem}
.create-info p{margin:0;font-size:.85rem;color:var(--text-muted);line-height:1.6}
</style>

<script>
const ratingInput = document.getElementById('ratingInput');
const starIcons = document.querySelectorAll('.star-icon');

function renderStars(value) {
    starIcons.forEach((icon, i) => {
        const starNum = i + 1;
        icon.className = 'fas fa-star star-icon';
        if (value >= starNum) {
            icon.classList.add('full');
        } else if (value >= starNum - 0.5) {
            icon.classList.add('half');
        }
    });
}

document.querySelectorAll('.star-half').forEach(btn => {
    btn.addEventListener('mouseenter', () => renderStars(parseFloat(btn.dataset.value)));
    btn.addEventListener('click', () => {
        ratingInput.value = btn.dataset.value;
        renderStars(parseFloat(btn.dataset.value));
    });
});

document.getElementById('starsInput').addEventListener('mouseleave', () => {
    renderStars(parseFloat(ratingInput.value) || 0);
});

// Init jika ada nilai awal
if (ratingInput.value) renderStars(parseFloat(ratingInput.value));
</script>
@endsection
