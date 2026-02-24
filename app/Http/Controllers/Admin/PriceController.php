<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Tampilkan daftar harga.
     */
    public function index()
    {
        return view('admin.prices.index');
    }

    /**
     * Tampilkan form buat harga baru.
     */
    public function create()
    {
        return view('admin.prices.create');
    }

    /**
     * Simpan harga baru.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Tampilkan harga tertentu.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Tampilkan form edit harga.
     */
    public function edit(string $id)
    {
        return view('admin.prices.edit', compact('id'));
    }

    /**
     * Update harga.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Hapus harga.
     */
    public function destroy(string $id)
    {
        //
    }
}
