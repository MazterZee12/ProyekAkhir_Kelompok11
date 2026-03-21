<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    /**
     * Tampilkan daftar jadwal dan informasi kunjungan.
     */
    public function index()
    {
        $schedules = Schedule::latest()->paginate(15);
        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Tampilkan form tambah jadwal.
     */
    public function create()
    {
        return view('admin.schedules.create');
    }

    /**
     * Simpan jadwal baru.
     */
    public function store(Request $request)
    {
        $weatherEmbed = $request->input('weather_embed');

        if ($weatherEmbed && !str_contains($weatherEmbed, 'weatherwidget.io')) {
            return back()
                ->withInput()
                ->withErrors(['weather_embed' => 'Hanya embed dari weatherwidget.io yang diizinkan.']);
        }

        $data = $request->validate([
            'day'            => 'required|string|max:50',
            'open_time'      => 'required|date_format:H:i',
            'close_time'     => 'required|date_format:H:i|after_or_equal:open_time',
            'capacity'       => 'nullable|integer|min:0',
            'best_time'      => 'nullable|string|max:255',
            'parking_info'   => 'nullable|string',
            'transport_info' => 'nullable|string',
            'route_info'     => 'nullable|string',
        ]);

        // hapus dd($data) dan lanjutkan
        $data['is_active']     = $request->has('is_active');
        $data['weather_embed'] = $weatherEmbed;

        try {
            Schedule::create($data);

            return redirect()
                ->route('admin.schedules.index')
                ->with('success', 'Schedule created.');

        } catch (\Exception $e) {
            Log::error('ScheduleController::store failed', [
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal menyimpan jadwal.');
        }
    }

    /**
     * Tampilkan jadwal tertentu.
     */
    public function show(Schedule $schedule)
    {
        return view('admin.schedules.show', compact('schedule'));
    }

    /**
     * Tampilkan form edit jadwal.
     */
    public function edit(Schedule $schedule)
    {
        return view('admin.schedules.edit', compact('schedule'));
    }

    /**
     * Update jadwal.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $weatherEmbed = $request->input('weather_embed');

        // validasi hanya izinkan embed dari weatherwidget.io
        if ($weatherEmbed && !str_contains($weatherEmbed, 'weatherwidget.io')) {
            return back()
                ->withInput()
                ->withErrors(['weather_embed' => 'Hanya embed dari weatherwidget.io yang diizinkan.']);
        }

        $data = $request->validate([
            'day'            => 'required|string|max:50',
            'open_time'      => 'required|date_format:H:i,H.i',
            'close_time'     => 'required|date_format:H:i,H.i|after:open_time',
            'capacity'       => 'nullable|integer|min:0',
            'best_time'      => 'nullable|string|max:255',
            'parking_info'   => 'nullable|string',
            'transport_info' => 'nullable|string',
            'route_info'     => 'nullable|string',
        ]);

        $data['is_active']     = $request->has('is_active');
        $data['weather_embed'] = $weatherEmbed;

        try {
            $schedule->update($data);

            return redirect()->route('admin.schedules.index')->with('success', 'Schedule updated.');

        } catch (\Exception $e) {
            Log::error('ScheduleController::update failed', [
                'id'    => $schedule->id,
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui jadwal.');
        }
    }

    /**
     * Hapus jadwal.
     */
    public function destroy(Schedule $schedule)
    {
        try {
            $schedule->delete();

            return redirect()
                ->route('admin.schedules.index')
                ->with('success', 'Schedule deleted.');

        } catch (\Exception $e) {
            Log::error('ScheduleController::destroy failed', [
                'id'    => $schedule->id,
                'error' => $e->getMessage()
            ]);
            return redirect()
                ->route('admin.schedules.index')
                ->with('error', 'Gagal menghapus jadwal.');
        }
    }
}
