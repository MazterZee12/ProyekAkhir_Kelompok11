<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Tampilkan daftar gallery.
     */
    public function index()
    {
        return view('admin.galleries.index');
    }

    /**
     * Tampilkan form buat gallery baru.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Simpan gallery baru.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Tampilkan gallery tertentu.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Tampilkan form edit gallery.
     */
    public function edit(string $id)
    {
        return view('admin.galleries.edit', compact('id'));
    }

    /**
     * Update gallery.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Hapus gallery.
     */
    public function destroy(string $id)
    {
        //
    }
}
