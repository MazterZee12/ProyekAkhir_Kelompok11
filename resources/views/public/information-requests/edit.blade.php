@extends('layouts.public')
@section('title', 'Edit Permintaan Informasi — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&q=80')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center;color:var(--accent-light)">Layanan Pengunjung</div>
        <h1>Edit <em>Permintaan</em></h1>
        <p>Perbarui pertanyaanmu selama belum dijawab admin.</p>
    </div>
</section>

<section class="ir-section">
    <div class="container-md">

        @if($errors->any())
            <div class="alert-error reveal"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif

        <div class="ir-form reveal">
            <form action="{{ route('information-requests.update', $informationRequest) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="ir-form-group">
                    <label>Subjek <span style="color:var(--ir-danger)">*</span></label>
                    <input type="text" name="subject" class="ir-form-control"
                        maxlength="255" value="{{ old('subject', $informationRequest->subject) }}" required>
                    @error('subject')<div class="ir-field-error">{{ $message }}</div>@enderror
                </div>

                <div class="ir-form-group">
                    <label>Pertanyaan / Pesan <span style="color:var(--ir-danger)">*</span></label>
                    <textarea name="message" id="irMessageInput" rows="6" class="ir-form-control" required>{{ old('message', $informationRequest->message) }}</textarea>
                    <div class="ir-char-counter" id="irMessageCounter"></div>
                    @error('message')<div class="ir-field-error">{{ $message }}</div>@enderror
                </div>

                <div class="ir-card-actions" style="justify-content:flex-end;">
                    <a href="{{ route('information-requests.show', $informationRequest) }}" class="ir-btn ir-btn-outline">Batal</a>
                    <button type="submit" class="ir-btn"><i class="fas fa-save"></i> Simpan Perubahan</button>
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
