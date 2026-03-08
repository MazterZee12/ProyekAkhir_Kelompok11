<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Tampilkan daftar kontak.
     */
    public function index()
    {
        $contact = Contact::firstOrCreate([]);
        return view('admin.contacts.index', compact('contact'));
    }

    /**
     * Update kontak.
     */
    public function update(Request $request)
    {
        $contact = Contact::firstOrCreate([]);

        $data = $request->validate([
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'google_maps_embed' => 'nullable|string',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean'
        ]);

        $data['is_active'] = $request->has('is_active');

        $contact->update($data);

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Contact updated successfully');
    }
}
