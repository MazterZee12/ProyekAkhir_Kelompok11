@extends('layouts.public')
@section('title', 'Jadwal Kunjungan — Pasir Putih Parparean')
@section('content')

<section class="page-hero">
    <div class="page-hero-bg" style="background-image:url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRuPxAwSp-id1UkplYjZf32Vw4bg4nzsMTfwg&s')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content reveal">
        <div class="section-label" style="justify-content:center;color:var(--gold)">Jadwal</div>
        <h1>Jam Operasional & <em>Info Kunjungan</em></h1>
        <p>Rencanakan kunjunganmu dengan informasi lengkap di bawah ini</p>
    </div>
</section>

<section style="padding:80px 0">
    <div class="container">
        @forelse($schedules as $schedule)
        <div class="schedule-card reveal">
            <div class="schedule-header">
                <div class="schedule-day">
                    <i class="far fa-calendar-alt"></i>
                    {{ $schedule->day }}
                </div>
                <div class="schedule-time">
                    <i class="far fa-clock"></i>
                    {{ \Carbon\Carbon::parse($schedule->open_time)->format('H:i') }} —
                    {{ \Carbon\Carbon::parse($schedule->close_time)->format('H:i') }} WIB
                </div>
                @if($schedule->capacity)
                <div class="schedule-cap">
                    <i class="fas fa-users"></i> Maks. {{ number_format($schedule->capacity) }} pengunjung
                </div>
                @endif
            </div>

            <div class="schedule-details">
                @if($schedule->best_time)
                <div class="schedule-detail-item">
                    <div class="sdi-icon"><i class="fas fa-sun"></i></div>
                    <div>
                        <div class="sdi-label">Waktu Terbaik Berkunjung</div>
                        <div class="sdi-value">{{ $schedule->best_time }}</div>
                    </div>
                </div>
                @endif

                @if($schedule->parking_info)
                <div class="schedule-detail-item">
                    <div class="sdi-icon"><i class="fas fa-parking"></i></div>
                    <div>
                        <div class="sdi-label">Informasi Parkir</div>
                        <div class="sdi-value">{{ $schedule->parking_info }}</div>
                    </div>
                </div>
                @endif

                @if($schedule->transport_info)
                <div class="schedule-detail-item">
                    <div class="sdi-icon"><i class="fas fa-bus"></i></div>
                    <div>
                        <div class="sdi-label">Transportasi</div>
                        <div class="sdi-value">{{ $schedule->transport_info }}</div>
                    </div>
                </div>
                @endif

                @if($schedule->route_info)
                <div class="schedule-detail-item">
                    <div class="sdi-icon"><i class="fas fa-map-marked-alt"></i></div>
                    <div>
                        <div class="sdi-label">Rute Perjalanan</div>
                        <div class="sdi-value">{{ $schedule->route_info }}</div>
                    </div>
                </div>
                @endif
            </div>

            @if($schedule->weather_embed)
            <div class="schedule-weather">
                <div class="sdi-label" style="margin-bottom:12px"><i class="fas fa-cloud-sun"></i> Prakiraan Cuaca</div>
                {!! $schedule->weather_embed !!}
            </div>
            @endif
        </div>
        @empty
        <p style="text-align:center;color:var(--text-muted);padding:60px 0">Informasi jadwal belum tersedia.</p>
        @endforelse
    </div>
</section>

<style>
.page-hero{position:relative;height:420px;display:flex;align-items:center;justify-content:center;text-align:center;overflow:hidden}
.page-hero-bg{position:absolute;inset:0;background-size:cover;background-position:center}
.page-hero-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,30,60,.6),rgba(0,10,30,.8))}
.page-hero-content{position:relative;z-index:2;color:#fff;padding:0 24px}
.page-hero-content h1{font-size:clamp(2rem,5vw,3.5rem);margin:12px 0}
.page-hero-content p{opacity:.8;font-size:1.1rem}
.container{max-width:900px;margin:0 auto;padding:0 24px}
.schedule-card{background:var(--surface);border:1px solid rgba(255,255,255,.08);border-radius:20px;overflow:hidden;margin-bottom:32px}
.schedule-header{background:linear-gradient(135deg,var(--ocean),#0a5a8a);padding:28px 36px;display:flex;flex-wrap:wrap;gap:24px;align-items:center}
.schedule-day{font-size:1.3rem;font-weight:700;color:#fff;display:flex;align-items:center;gap:10px}
.schedule-time{font-size:1rem;color:rgba(255,255,255,.85);display:flex;align-items:center;gap:8px}
.schedule-cap{font-size:.9rem;color:rgba(255,255,255,.7);display:flex;align-items:center;gap:8px;margin-left:auto}
.schedule-details{padding:32px 36px;display:flex;flex-direction:column;gap:24px}
.schedule-detail-item{display:flex;gap:16px;align-items:flex-start}
.sdi-icon{width:40px;height:40px;background:rgba(255,255,255,.06);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--ocean);flex-shrink:0}
.sdi-label{font-size:.8rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px}
.sdi-value{color:#fff;line-height:1.6;font-size:.95rem}
.schedule-weather{padding:0 36px 32px}
@media(max-width:600px){.schedule-header{flex-direction:column;gap:12px}.schedule-cap{margin-left:0}.schedule-details{padding:24px}.schedule-weather{padding:0 24px 24px}}
</style>
@endsection
