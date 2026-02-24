<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewModerationController extends Controller
{
    /**
     * Tampilkan daftar review.
     */
    public function index()
    {
        return view('admin.reviews.index');
    }

    /**
     * Tampilkan form buat review baru.
     */
    public function create()
    {
        return view('admin.reviews.create');
    }

    /**
     * Simpan review baru.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Tampilkan review tertentu.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Tampilkan form edit review.
     */
    public function edit(string $id)
    {
        return view('admin.reviews.edit', compact('id'));
    }
    /**
     * Update review.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Hapus review.
     */
    public function destroy(string $id)
    {
        //
    }
}
