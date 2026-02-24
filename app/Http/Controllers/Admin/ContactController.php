<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Tampilkan daftar kontak.
     */
    public function index()
    {
        return view('admin.contacts.index');
    }

    /**
     * Tampilkan form buat kontak baru.
     */
    public function create()
    {
        return view('admin.contacts.create');
    }

    /**
     * Simpan kontak baru.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Tampilkan kontak tertentu.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Tampilkan form edit kontak.
     */
    public function edit(string $id)
    {
        return view('admin.contacts.edit', compact('id'));
    }

    /**
     * Update kontak.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Hapus kontak.
     */
    public function destroy(string $id)
    {
        //
    }
}
