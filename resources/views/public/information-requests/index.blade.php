@extends('layouts.public')
@section('title', 'Permintaan Informasi Saya — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url(''https://zjglidcehtsqqqhbdxyp.supabase.co/storage/v1/object/public/atourin/images/destination/toba/pantai-pasir-putih-parparean-profile1670997298.jpeg')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center;color:var(--accent-light)">Layanan Pengunjung</div>
        <h1>Permintaan <em>Informasi Saya</em></h1>
        <p>Ajukan pertanyaan dan pantau status jawabannya di sini.</p>
    </div>
</section>

<section class="ir-section">
    <div class="container-md">

        @if(session('success'))
            <div class="alert-success reveal"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error reveal"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        <div class="ir-widgets reveal">
            <div class="ir-widget-card ir-total">
                <div class="ir-widget-label">Total Permintaan</div>
                <div class="ir-widget-value">{{ $total }}</div>
            </div>
            <div class="ir-widget-card ir-pending">
                <div class="ir-widget-label">Menunggu Jawaban</div>
                <div class="ir-widget-value">{{ $pending }}</div>
            </div>
            <div class="ir-widget-card ir-answered">
                <div class="ir-widget-label">Sudah Dijawab</div>
                <div class="ir-widget-value">{{ $answered }}</div>
            </div>
        </div>

        <div class="ir-toolbar reveal">
            <h2>Riwayat Permintaan</h2>
            <a href="{{ route('information-requests.create') }}" class="ir-btn">
                <i class="fas fa-plus"></i> Ajukan Permintaan Baru
            </a>
        </div>

        @forelse($informationRequests as $ir)
            <div class="ir-card reveal">
                <div class="ir-card-top">
                    <div>
                        <div class="ir-card-subject">{{ $ir->subject }}</div>
                        <div class="ir-card-date">{{ $ir->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <span class="ir-badge ir-badge-{{ $ir->status }}">
                        {{ ['pending' => 'Menunggu', 'answered' => 'Dijawab', 'closed' => 'Ditutup'][$ir->status] }}
                    </span>
                </div>
                <div class="ir-card-message">{{ \Illuminate\Support\Str::limit($ir->message, 140) }}</div>
                <div class="ir-card-actions">
                    <a href="{{ route('information-requests.show', $ir) }}" class="ir-btn ir-btn-outline ir-btn-sm">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    @if($ir->isPending())
                        <a href="{{ route('information-requests.edit', $ir) }}" class="ir-btn ir-btn-outline ir-btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('information-requests.destroy', $ir) }}" method="POST"
                            onsubmit="return irConfirmDelete('Hapus permintaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ir-btn ir-btn-danger ir-btn-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="ir-empty reveal">
                <i class="fas fa-inbox"></i>
                <p>Belum ada permintaan informasi. Yuk ajukan pertanyaanmu!</p>
                <a href="{{ route('information-requests.create') }}" class="ir-btn" style="margin-top:14px;">
                    Ajukan Sekarang
                </a>
            </div>
        @endforelse

        <div class="mt-3">{{ $informationRequests->links() }}</div>
    </div>
</section>

@endsection
