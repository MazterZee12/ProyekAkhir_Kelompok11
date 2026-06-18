<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class AnnouncementController extends Controller
{
    protected MediaService $media;

    public function __construct(MediaService $media)
    {
        $this->media = $media;
    }

    public function index()
    {
        $announcements = Announcement::with('photo')
            ->latest()
            ->paginate(15);

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $announcement = null;

        return view('admin.announcements.create', compact('announcement'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'type'    => ['required', 'in:event,promo,info'],
            'photo'   => ['nullable', 'image', 'max:10240'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        try {
            if ($request->hasFile('photo')) {
                $photo = $this->media->store(
                    $request->file('photo'),
                    'announcements'
                );

                $data['photo_media_id'] = $photo->id;
            }

            Announcement::create($data);

            return redirect()
                ->route('admin.announcements.index')
                ->with('success', 'Pengumuman berhasil disimpan.');
        } catch (Throwable $e) {
            Log::error('AnnouncementController::store failed', [
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan pengumuman.');
        }
    }

    public function show(Announcement $announcement)
    {
        $announcement->load('photo');

        return view('admin.announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        $announcement->load('photo');

        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'type'    => ['required', 'in:event,promo,info'],
            'photo'   => ['nullable', 'image', 'max:10240'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        try {
            if ($request->hasFile('photo')) {
                $photo = $this->media->replace(
                    $announcement->photo,
                    $request->file('photo'),
                    'announcements'
                );

                $data['photo_media_id'] = $photo->id;
            }

            $announcement->update($data);

            return redirect()
                ->route('admin.announcements.index')
                ->with('success', 'Pengumuman berhasil diperbarui.');
        } catch (Throwable $e) {
            Log::error('AnnouncementController::update failed', [
                'id' => $announcement->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui pengumuman.');
        }
    }

    public function destroy(Announcement $announcement)
    {
        try {
            if ($announcement->photo) {
                $this->media->delete($announcement->photo);
            }

            $announcement->delete();

            return redirect()
                ->route('admin.announcements.index')
                ->with('success', 'Pengumuman berhasil dihapus.');
        } catch (Throwable $e) {
            Log::error('AnnouncementController::destroy failed', [
                'id' => $announcement->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.announcements.index')
                ->with('error', 'Gagal menghapus pengumuman.');
        }
    }

    public function toggle(Announcement $announcement)
    {
        try {
            $announcement->is_active = ! $announcement->is_active;
            $announcement->save();

            return back()->with('success', 'Status berhasil diperbarui.');
        } catch (Throwable $e) {
            Log::error('AnnouncementController::toggle failed', [
                'id' => $announcement->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal memperbarui status.');
        }
    }
}
