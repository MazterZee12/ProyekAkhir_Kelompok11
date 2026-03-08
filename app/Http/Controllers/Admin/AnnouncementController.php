<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Services\FileUploadService;

class AnnouncementController extends Controller
{

    protected $upload;

    public function __construct(FileUploadService $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Tampilkan daftar pengumuman.
     */
    public function index()
    {
        Announcement::autoPublish();
        
        $announcements = Announcement::latest()->paginate(15);

        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Tampilkan form buat pengumuman baru.
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Simpan pengumuman baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'type'         => 'required|in:event,promo,info',
            'starts_at'    => 'nullable|date',
            'ends_at'      => 'nullable|date|after:starts_at',
            'photo'        => 'nullable|image|max:10240',
            'attachment'   => 'nullable|file|max:20480',
            'is_active'    => 'nullable|boolean',
            'is_featured'  => 'nullable|boolean'
        ]);

        /**
         * checkbox publish
         * jika tidak dicentang maka otomatis draft
         */
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $this->upload->upload(
                $request->file('photo'),
                'announcements'
            );
        }

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $this->upload->upload(
                $request->file('attachment'),
                'announcements/attachments'
            );
        }

        Announcement::create($data);

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement created.');
    }

    /**
     * Tampilkan pengumuman tertentu.
     */
    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    /**
     * Tampilkan form edit pengumuman.
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update pengumuman.
     */
    public function update(Request $request, Announcement $announcement)
    {

        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'type'         => 'required|in:event,promo,info',
            'starts_at'    => 'nullable|date',
            'ends_at'      => 'nullable|date|after:starts_at',
            'photo'        => 'nullable|image|max:10240',
            'attachment'   => 'nullable|file|max:20480',
            'is_active'    => 'nullable|boolean',
            'is_featured'  => 'nullable|boolean'
        ]);

        /**
         * checkbox publish
         */
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('photo')) {

            $data['photo_path'] = $this->upload->replace(
                $announcement->photo_path,
                $request->file('photo'),
                'announcements'
            );
        }

        if ($request->hasFile('attachment')) {

            $data['attachment_path'] = $this->upload->replace(
                $announcement->attachment_path,
                $request->file('attachment'),
                'announcements/attachments'
            );
        }

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement updated.');
    }

    /**
     * Hapus pengumuman.
     */
    public function destroy(Announcement $announcement)
    {

        $this->upload->delete($announcement->photo_path);

        $this->upload->delete($announcement->attachment_path);

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement deleted.');
    }

    public function toggle(Announcement $announcement)
    {
        $announcement->is_active = !$announcement->is_active;
        $announcement->save();

        return back()->with('success', 'Status updated.');
    }
}
