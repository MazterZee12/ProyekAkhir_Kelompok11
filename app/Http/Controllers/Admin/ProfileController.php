<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Tampilkan daftar profil.
     */
    public function index()
    {
        return view('admin.profiles.index');
    }

    /**
     * Tampilkan form buat profil baru.
     */
    public function create()
    {
        return view('admin.profiles.create');
    }

    /**
     * Simpan profil baru.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Tampilkan profil tertentu.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Tampilkan form edit profil.
     */
    public function edit(string $id)
    {
        return view('admin.profiles.edit', compact('id'));
    }

    /**
     * Update profil.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Hapus profil.
     */
    public function destroy(string $id)
    {
        //
    }
}
