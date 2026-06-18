@extends('layouts.public')
@section('title', 'Ajukan Permintaan Informasi — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://zjglidcehtsqqqhbdxyp.supabase.co/storage/v1/object/public/atourin/images/destination/toba/pantai-pasir-putih-parparean-profile1670997298.jpeg    ')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center;color:var(--accent-light)">Layanan Pengunjung</div>
        <h1>Ajukan <em>Permintaan Informasi</em></h1>
        <p>Punya pertanyaan seputar Pasir Putih Parparean? Tanyakan langsung di sini.</p>
    </div>
</section>

<section class="ir-section">
    <div class="container-md">

        @if($errors->any())
            <div class="alert-error reveal"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif

        <div class="ir-form reveal">
            <form action="{{ route('information-requests.store') }}" method="POST">
                @csrf
                <div class="ir-form-group">
                    <label>Subjek <span style="color:var(--ir-danger)">*</span></label>
                    <input type="text" name="subject" class="ir-form-control"
                        maxlength="255" value="{{ old('subject') }}"
                        placeholder="Contoh: Jam operasional hari libur" required>
                    @error('subject')<div class="ir-field-error">{{ $message }}</div>@enderror
                </div>

                <div class="ir-form-group">
                    <label>Pertanyaan / Pesan <span style="color:var(--ir-danger)">*</span></label>
                    <textarea name="message" id="irMessageInput" rows="6" class="ir-form-control"
                        placeholder="Tuliskan pertanyaanmu secara detail (minimal 10 karakter)..." required>{{ old('message') }}</textarea>
                    <div class="ir-char-counter" id="irMessageCounter"></div>
                    @error('message')<div class="ir-field-error">{{ $message }}</div>@enderror
                </div>

                <div class="ir-card-actions" style="justify-content:flex-end;">
                    <a href="{{ route('information-requests.index') }}" class="ir-btn ir-btn-outline">Batal</a>
                    <button type="submit" class="ir-btn"><i class="fas fa-paper-plane"></i> Kirim Permintaan</button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    irInitCharCounter('irMessageInput', 'irMessageCounter', 10);
</script>
@endpush
@endsection
