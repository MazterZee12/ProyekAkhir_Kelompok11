<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use Illuminate\Support\Facades\Log;

class FaqController extends Controller
{
    /**
     * Tampilkan daftar FAQ.
     */
    public function index()
    {
        $faqs = Faq::latest()->paginate(15);
        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Tampilkan form tambah FAQ.
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Simpan FAQ baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'question'  => 'required|string|max:255',
            'answer'    => 'required|string',
            'order'     => 'nullable|integer|min:0',
        ]);

        /**
         * checkbox aktif
         * jika tidak dicentang maka otomatis nonaktif
         */
        $data['is_active'] = $request->has('is_active');

        try {
            Faq::create($data);

            return redirect()
                ->route('admin.faqs.index')
                ->with('success', 'FAQ created.');

        } catch (\Exception $e) {
            Log::error('FaqController::store failed', [
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal menyimpan FAQ.');
        }
    }

    /**
     * Tampilkan FAQ tertentu.
     */
    public function show(Faq $faq)
    {
        return view('admin.faqs.show', compact('faq'));
    }

    /**
     * Tampilkan form edit FAQ.
     */
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update FAQ.
     */
    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question'  => 'required|string|max:255',
            'answer'    => 'required|string',
            'order'     => 'nullable|integer|min:0',
        ]);

        /**
         * checkbox aktif
         */
        $data['is_active'] = $request->has('is_active');

        try {
            $faq->update($data);

            return redirect()
                ->route('admin.faqs.index')
                ->with('success', 'FAQ updated.');

        } catch (\Exception $e) {
            Log::error('FaqController::update failed', [
                'id'    => $faq->id,
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui FAQ.');
        }
    }

    /**
     * Hapus FAQ.
     */
    public function destroy(Faq $faq)
    {
        try {
            $faq->delete();

            return redirect()
                ->route('admin.faqs.index')
                ->with('success', 'FAQ deleted.');

        } catch (\Exception $e) {
            Log::error('FaqController::destroy failed', [
                'id'    => $faq->id,
                'error' => $e->getMessage()
            ]);
            return redirect()
                ->route('admin.faqs.index')
                ->with('error', 'Gagal menghapus FAQ.');
        }
    }
}
