<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Facility;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Log;

class FacilityController extends Controller
{
    protected $fileService;

    public function __construct(FileUploadService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Tampilkan daftar fasilitas.
     */
    public function index()
    {
        $facilities = Facility::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.facilities.index', compact('facilities'));
    }

    /**
     * Tampilkan form buat fasilitas baru.
     */
    public function create()
    {
        $facility = null;
        return view('admin.facilities.create', compact('facility'));
    }

    /**
     * Simpan fasilitas baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'photo'          => 'nullable|image|max:10240',
        ]);

        try {
            if ($request->hasFile('photo')) {
                // store file
                $data['photo_path'] = $this->fileService->upload($request->file('photo'), 'facilities');
            }

            Facility::create($data);

            return redirect()->route('admin.facilities.index')
                             ->with('success', 'Facility created.');

        } catch (\RuntimeException $e) {
            // error dari FileUploadService
            return back()->withInput()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('FacilityController::store failed', [
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal menyimpan fasilitas.');
        }
    }

    /**
     * Tampilkan fasilitas tertentu.
     */
    public function show(Facility $facility)
    {
        return view('admin.facilities.show', compact('facility'));
    }

    /**
     * Tampilkan form edit fasilitas.
     */
    public function edit(Facility $facility)
    {
            return view('admin.facilities.edit', compact('facility'));
    }

    /**
     * Update fasilitas.
     */
    public function update(Request $request, Facility $facility)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'photo'          => 'nullable|image|max:10240',
        ]);

        try {
            if ($request->hasFile('photo')) {
                // store file
                $data['photo_path'] = $this->fileService->replace($facility->photo_path, $request->file('photo'), 'facilities');
            }

            $facility->update($data);

            return redirect()->route('admin.facilities.index')
                             ->with('success', 'Facility updated.');

        } catch (\RuntimeException $e) {
            // error dari FileUploadService
            return back()->withInput()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('FacilityController::update failed', [
                'id'    => $facility->id,
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui fasilitas.');
        }
    }

    /**
     * Hapus fasilitas.
     */
    public function destroy(Facility $facility)
    {
        try {
            if ($facility->photo_path) {
                $this->fileService->delete($facility->photo_path);
            }

            $facility->delete();

            return redirect()->route('admin.facilities.index')
                            ->with('success', 'Facility deleted.');

        } catch (\Exception $e) {
            Log::error('FacilityController::destroy failed', [
                'id'    => $facility->id,
                'error' => $e->getMessage()
            ]);
            return redirect()->route('admin.facilities.index')
                            ->with('error', 'Gagal menghapus fasilitas.');
        }
    }
}
