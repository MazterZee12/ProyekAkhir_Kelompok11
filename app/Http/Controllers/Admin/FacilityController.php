<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Tampilkan daftar fasilitas.
     */
    public function index()
    {
        return view('admin.facilities.index');
    }

    /**
     * Tampilkan form buat fasilitas baru.
     */
    public function create()
    {
        return view('admin.facilities.create');
    }

    /**
     * Simpan fasilitas baru.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Tampilkan fasilitas tertentu.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Tampilkan form edit fasilitas.
     */
    public function edit(string $id)
    {
        return view('admin.facilities.edit', compact('id'));
    }

    /**
     * Update fasilitas.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Hapus fasilitas.
     */
    public function destroy(string $id)
    {
        //
    }
}
