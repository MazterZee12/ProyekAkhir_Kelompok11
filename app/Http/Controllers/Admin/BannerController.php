<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    protected MediaService $media;

    public function __construct(MediaService $media)
    {
        $this->media = $media;
    }

    public function index()
    {
        $banners = Banner::with('media')->orderBy('order')->paginate(15);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        $banner = null;
        return view('admin.banners.create', compact('banner'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image'    => 'required|image|max:10240',
            'order'    => 'nullable|integer|min:0',
        ]);

        $data['is_active'] = $request->has('is_active');

        try {
            $data['media_id'] = $this->media->store(
                $request->file('image'),
                'banners'
            )->id;

            Banner::create($data);

            return redirect()
                ->route('admin.banners.index')
                ->with('success', 'Banner berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('BannerController::store failed', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal menyimpan banner.');
        }
    }

    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image'    => 'nullable|image|max:10240',
            'order'    => 'nullable|integer|min:0',
        ]);

        $data['is_active'] = $request->has('is_active');

        try {
            if ($request->hasFile('image')) {
                $data['media_id'] = $this->media->replace(
                    $banner->media,
                    $request->file('image'),
                    'banners'
                )->id;
            }

            $banner->update($data);

            return redirect()
                ->route('admin.banners.index')
                ->with('success', 'Banner berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('BannerController::update failed', [
                'id'    => $banner->id,
                'error' => $e->getMessage(),
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui banner.');
        }
    }

    public function destroy(Banner $banner)
    {
        try {
            $this->media->delete($banner->media);
            $banner->delete();

            return redirect()
                ->route('admin.banners.index')
                ->with('success', 'Banner berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('BannerController::destroy failed', [
                'id'    => $banner->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()
                ->route('admin.banners.index')
                ->with('error', 'Gagal menghapus banner.');
        }
    }

    public function toggle(Banner $banner)
    {
        try {
            $banner->is_active = ! $banner->is_active;
            $banner->save();

            return back()->with('success', 'Status berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('BannerController::toggle failed', [
                'id'    => $banner->id,
                'error' => $e->getMessage(),
            ]);
            return back()->with('error', 'Gagal memperbarui status.');
        }
    }
}
