<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FacilityController extends Controller
{
    protected MediaService $media;

    public function __construct(MediaService $media)
    {
        $this->media = $media;
    }

    public function index()
    {
        $facilities = Facility::latest()->paginate(15);
        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        $facility = null;
        return view('admin.facilities.create', compact('facility'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|max:10240',
        ]);

        try {
            if ($request->hasFile('photo')) {
                $data['media_id'] = $this->media->store(
                    $request->file('photo'),
                    'facilities'
                )->id;
            }

            Facility::create($data);

            return redirect()
                ->route('admin.facilities.index')
                ->with('success', 'Fasilitas berhasil disimpan.');

        } catch (\Exception $e) {
            Log::error('FacilityController::store failed', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal menyimpan fasilitas.');
        }
    }

    public function show(Facility $facility)
    {
        return view('admin.facilities.show', compact('facility'));
    }

    public function edit(Facility $facility)
    {
        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|max:10240',
        ]);

        try {
            if ($request->hasFile('photo')) {
                $data['media_id'] = $this->media->replace(
                    $facility->media,
                    $request->file('photo'),
                    'facilities'
                )->id;
            }

            $facility->update($data);

            return redirect()
                ->route('admin.facilities.index')
                ->with('success', 'Fasilitas berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('FacilityController::update failed', [
                'id'    => $facility->id,
                'error' => $e->getMessage(),
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui fasilitas.');
        }
    }

    public function destroy(Facility $facility)
    {
        try {
            $this->media->delete($facility->media);
            $facility->delete();

            return redirect()
                ->route('admin.facilities.index')
                ->with('success', 'Fasilitas berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('FacilityController::destroy failed', [
                'id'    => $facility->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()
                ->route('admin.facilities.index')
                ->with('error', 'Gagal menghapus fasilitas.');
        }
    }
}
