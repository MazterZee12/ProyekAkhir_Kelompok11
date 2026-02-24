<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Tampilkan daftar pengumuman.
     */
    public function index()
    {
        return view('admin.announcements.index');
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
        //
    }

    /**
     * Tampilkan pengumuman tertentu.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Tampilkan form edit pengumuman.
     */
    public function edit(string $id)
    {
        return view('admin.announcements.edit', compact('id'));
    }

    /**
     * Update pengumuman.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Hapus pengumuman.
     */
    public function destroy(string $id)
    {
        //
    }
}
