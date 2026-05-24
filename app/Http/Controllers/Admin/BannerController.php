<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    protected $upload;

    public function __construct(FileUploadService $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Tampilkan daftar banner.
     */
    public function index()
    {
        $banners = Banner::latest()->paginate(15);
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Tampilkan form tambah banner.
     */
    public function create()
    {
        $banner = null;
        return view('admin.banners.create', compact('banner'));
    }

    /**
     * Simpan banner baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'url'       => 'nullable|url|max:255',
            'image'     => 'required|image|max:10240',
            'order'     => 'nullable|integer|min:0',
        ]);

        /**
         * checkbox aktif
         * jika tidak dicentang maka otomatis nonaktif
         */
        $data['is_active'] = $request->has('is_active');

        try {
            if ($request->hasFile('image')) {
                $data['image_path'] = $this->upload->upload(
                    $request->file('image'),
                    'banners'
                );
            }

            Banner::create($data);

            return redirect()
                ->route('admin.banners.index')
                ->with('success', 'Banner created.');

        } catch (\RuntimeException $e) {
            // error dari FileUploadService
            return back()->withInput()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('BannerController::store failed', [
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal menyimpan banner.');
        }
    }

    /**
     * Tampilkan banner tertentu.
     */
    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    /**
     * Tampilkan form edit banner.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update banner.
     */
    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'url'       => 'nullable|url|max:255',
            'image'     => 'nullable|image|max:10240',
            'order'     => 'nullable|integer|min:0',
        ]);

        /**
         * checkbox aktif
         */
        $data['is_active'] = $request->has('is_active');

        try {
            if ($request->hasFile('image')) {
                $data['image_path'] = $this->upload->replace(
                    $banner->image_path,
                    $request->file('image'),
                    'banners'
                );
            }

            $banner->update($data);

            return redirect()
                ->route('admin.banners.index')
                ->with('success', 'Banner updated.');

        } catch (\RuntimeException $e) {
            // error dari FileUploadService
            return back()->withInput()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('BannerController::update failed', [
                'id'    => $banner->id,
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui banner.');
        }
    }

    /**
     * Hapus banner.
     */
    public function destroy(Banner $banner)
    {
        try {
            $this->upload->delete($banner->image_path);
            $banner->delete();

            return redirect()
                ->route('admin.banners.index')
                ->with('success', 'Banner deleted.');

        } catch (\Exception $e) {
            Log::error('BannerController::destroy failed', [
                'id'    => $banner->id,
                'error' => $e->getMessage()
            ]);
            return redirect()
                ->route('admin.banners.index')
                ->with('error', 'Gagal menghapus banner.');
        }
    }

    /**
     * Toggle status aktif banner.
     */
    public function toggle(Banner $banner)
    {
        try {
            $banner->is_active = !$banner->is_active;
            $banner->save();

            return back()->with('success', 'Status updated.');

        } catch (\Exception $e) {
            Log::error('BannerController::toggle failed', [
                'id'    => $banner->id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Gagal memperbarui status banner.');
        }
    }
}
