<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Facility;
use App\Services\FileUploadService;

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
        return view('admin.facilities.create');
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

        if ($request->hasFile('photo')) {
            // store file
            $data['photo_path'] = $this->fileService->upload($request->file('photo'), 'facilities');
        }

        Facility::create($data);

        return redirect()->route('admin.facilities.index')
                         ->with('success', 'Facility created.');
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

        if ($request->hasFile('photo')) {
            // store file
            $data['photo_path'] = $this->fileService->replace($facility->photo_path, $request->file('photo'), 'facilities');
        }

        $facility->update($data);

        return redirect()->route('admin.facilities.index')
                         ->with('success', 'Facility updated.');
    }

    /**
     * Hapus fasilitas.
     */
    public function destroy(Facility $facility)
    {
        if ($facility->photo_path) {
            $this->fileService->delete($facility->photo_path);
        }

        $facility->delete();

        return redirect()->route('admin.facilities.index')
                        ->with('success', 'Facility deleted.');
    }
}
