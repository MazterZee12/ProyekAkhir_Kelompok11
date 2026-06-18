<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Tampilkan daftar kontak.
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(15);
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Tampilkan form tambah kontak.
     */
    public function create()
    {
        $contact = null;
        return view('admin.contacts.create', compact('contact'));
    }

    /**
     * Simpan kontak baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'address'           => 'nullable|string|max:255',
            'email'             => 'nullable|email|max:255',
            'phone'             => 'nullable|string|max:50',
            'google_maps_embed' => 'nullable|string',
            'instagram'         => 'nullable|string|max:255',
            'facebook'          => 'nullable|string|max:255',
            'youtube'           => 'nullable|string|max:255',
            'twitter'           => 'nullable|string|max:255',
            'is_active'         => 'nullable|boolean',
        ]);

        /**
         * checkbox aktif
         * jika tidak dicentang maka otomatis nonaktif
         */
        $data['is_active'] = $request->has('is_active');

        try {
            Contact::create($data);
            return redirect()
                ->route('admin.contacts.index')
                ->with('success', 'Contact created.');
        } catch (\Exception $e) {
            Log::error('ContactController::store failed', [
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal menyimpan kontak.');
        }
    }

    /**
     * Tampilkan kontak tertentu.
     */
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Tampilkan form edit kontak.
     */
    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    /**
     * Update kontak.
     */
    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'address'           => 'nullable|string|max:255',
            'email'             => 'nullable|email|max:255',
            'phone'             => 'nullable|string|max:50',
            'google_maps_embed' => 'nullable|string',
            'instagram'         => 'nullable|string|max:255',
            'facebook'          => 'nullable|string|max:255',
            'youtube'           => 'nullable|string|max:255',
            'twitter'           => 'nullable|string|max:255',
        ]);

        /**
         * checkbox aktif
         */
        $data['is_active'] = $request->has('is_active');

        try {
            $contact->update($data);
            return redirect()
                ->route('admin.contacts.index')
                ->with('success', 'Contact updated.');
        } catch (\Exception $e) {
            Log::error('ContactController::update failed', [
                'id'    => $contact->id,
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui kontak.');
        }
    }

    /**
     * Hapus kontak.
     */
    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            return redirect()
                ->route('admin.contacts.index')
                ->with('success', 'Contact deleted.');
        } catch (\Exception $e) {
            Log::error('ContactController::destroy failed', [
                'id'    => $contact->id,
                'error' => $e->getMessage()
            ]);
            return redirect()
                ->route('admin.contacts.index')
                ->with('error', 'Gagal menghapus kontak.');
        }
    }
}
