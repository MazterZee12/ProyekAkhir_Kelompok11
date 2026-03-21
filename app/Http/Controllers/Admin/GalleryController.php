<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    /**
     * Tampilkan daftar gallery
     */
    public function index()
    {
        $galleries = Gallery::orderBy('created_at','desc')->paginate(15);
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Form upload
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Simpan gallery
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4|max:10240',
        ]);

        try {
            $file = $request->file('file');
            $mime = $file->getMimeType();
            $type = str_starts_with($mime, 'image') ? 'photo' : 'video';
            $filename = uniqid().'.'.$file->getClientOriginalExtension();
            $file->storeAs('galleries', $filename, 'public');
            $data['file_path'] = 'galleries/'.$filename;
            $data['type'] = $type;

            Gallery::create($data);

            return redirect()->route('admin.galleries.index')
                ->with('success','Gallery item created.');

        } catch (\Exception $e) {
            Log::error('GalleryController::store failed', [
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal menyimpan item gallery.');
        }
    }

    /**
     * Detail gallery
     */
    public function show(Gallery $gallery)
    {
        return view('admin.galleries.show', compact('gallery'));
    }

    /**
     * Form edit
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update gallery
     */
    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4|max:10240',
        ]);

        try {
            if($request->hasFile('file'))
            {
                if($gallery->file_path)
                {
                    Storage::disk('public')->delete($gallery->file_path);
                }

                $file = $request->file('file');
                $mime = $file->getMimeType();
                $type = str_starts_with($mime, 'image') ? 'photo' : 'video';
                $filename = uniqid().'.'.$file->getClientOriginalExtension();
                $file->storeAs('galleries', $filename, 'public');
                $data['file_path'] = 'galleries/'.$filename;
                $data['type'] = $type;
            }

            $gallery->update($data);

            return redirect()->route('admin.galleries.index')
                ->with('success','Gallery item updated.');

        } catch (\Exception $e) {
            Log::error('GalleryController::update failed', [
                'id'    => $gallery->id,
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui item gallery.');
        }
    }

    /**
     * Hapus gallery
     */
    public function destroy(Gallery $gallery)
    {
        try {
            if($gallery->file_path)
            {
                Storage::disk('public')->delete($gallery->file_path);
            }

            $gallery->delete();

            return redirect()->route('admin.galleries.index')
                ->with('success','Gallery item removed.');

        } catch (\Exception $e) {
            Log::error('GalleryController::destroy failed', [
                'id'    => $gallery->id,
                'error' => $e->getMessage()
            ]);
            return redirect()->route('admin.galleries.index')
                ->with('error', 'Gagal menghapus item gallery.');
        }
    }
}
