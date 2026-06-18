@extends('layouts.public')
@section('title', 'Detail Permintaan Informasi — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&q=80')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center;color:var(--accent-light)">Layanan Pengunjung</div>
        <h1>Detail <em>Permintaan</em></h1>
    </div>
</section>

<section class="ir-section">
    <div class="container-md">

        @if(session('success'))
            <div class="alert-success reveal"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <div class="ir-detail-box reveal">
            <div class="ir-card-top">
                <div>
                    <div class="ir-detail-label">Subjek</div>
                    <div class="ir-detail-value" style="font-weight:700;font-size:1.1rem;margin-bottom:0;">{{ $informationRequest->subject }}</div>
                </div>
                <span class="ir-badge ir-badge-{{ $informationRequest->status }}">
                    {{ ['pending' => 'Menunggu', 'answered' => 'Dijawab', 'closed' => 'Ditutup'][$informationRequest->status] }}
                </span>
            </div>

            <div class="ir-detail-label" style="margin-top:24px;">Pesan</div>
            <div class="ir-detail-value">{{ $informationRequest->message }}</div>

            <div class="ir-detail-label">Diajukan</div>
            <div class="ir-detail-value">{{ $informationRequest->created_at->format('d M Y, H:i') }} WIB</div>

            @if($informationRequest->response)
                <div class="ir-detail-label">Jawaban Admin</div>
                <div class="ir-response-box" style="margin-bottom:10px;">
                    {{ $informationRequest->response }}
                </div>
                <div class="ir-card-date">
                    Dijawab pada {{ $informationRequest->responded_at?->format('d M Y, H:i') }} WIB
                </div>
            @endif

            <div class="ir-card-actions" style="margin-top:28px;">
                <a href="{{ route('information-requests.index') }}" class="ir-btn ir-btn-outline">&larr; Kembali</a>
                @if($informationRequest->isPending())
                    <a href="{{ route('information-requests.edit', $informationRequest) }}" class="ir-btn ir-btn-outline">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('information-requests.destroy', $informationRequest) }}" method="POST"
                        onsubmit="return irConfirmDelete('Hapus permintaan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="ir-btn ir-btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
