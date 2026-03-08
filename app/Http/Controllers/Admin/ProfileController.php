<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Services\FileUploadService;

class ProfileController extends Controller
{
    protected $fileService;

    public function __construct(FileUploadService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Tampilkan daftar profil.
     */
    public function index()
    {
        $profile = Profile::firstOrCreate([]);
        return view('admin.profiles.index', compact('profile'));
    }

    /**
     * Update profil.
     */
    public function update(Request $request)
    {
        $profile = Profile::firstOrCreate([]);

        $data = $request->validate([
            'history'        => 'nullable|string',
            'vision'         => 'nullable|string',
            'mission'        => 'nullable|string',
            'manager_name'   => 'nullable|string|max:255',
            'manager_email'  => 'nullable|email|max:255',
            'manager_phone'  => 'nullable|string|max:50',
            'logo'           => 'nullable|image|max:10240',
            'is_active'      => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        $profile->update($data);

        return redirect()->route('admin.profiles.index')
            ->with('success', 'Profile updated successfully.');
    }
}
