<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    protected MediaService $media;

    public function __construct(MediaService $media)
    {
        $this->media = $media;
    }

    public function index()
    {
        $galleries = Gallery::latest()->paginate(15);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        $gallery = null;
        return view('admin.galleries.create', compact('gallery'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'nullable|string|max:50',
            'file'        => 'required|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        try {
            $data['media_id'] = $this->media->store(
                $request->file('file'),
                'galleries'
            )->id;

            Gallery::create($data);

            return redirect()
                ->route('admin.galleries.index')
                ->with('success', 'Foto galeri berhasil disimpan.');

        } catch (\Exception $e) {
            Log::error('GalleryController::store failed', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal menyimpan foto galeri.');
        }
    }

    public function show(Gallery $gallery)
    {
        return view('admin.galleries.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'nullable|string|max:50',
            'file'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        try {
            if ($request->hasFile('file')) {
                $data['media_id'] = $this->media->replace(
                    $gallery->media,
                    $request->file('file'),
                    'galleries'
                )->id;
            }

            $gallery->update($data);

            return redirect()
                ->route('admin.galleries.index')
                ->with('success', 'Foto galeri berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('GalleryController::update failed', [
                'id'    => $gallery->id,
                'error' => $e->getMessage(),
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui foto galeri.');
        }
    }

    public function destroy(Gallery $gallery)
    {
        try {
            $this->media->delete($gallery->media);
            $gallery->delete();

            return redirect()
                ->route('admin.galleries.index')
                ->with('success', 'Foto galeri berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('GalleryController::destroy failed', [
                'id'    => $gallery->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()
                ->route('admin.galleries.index')
                ->with('error', 'Gagal menghapus foto galeri.');
        }
    }
}
