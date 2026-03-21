<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    protected $upload;

    public function __construct(FileUploadService $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Tampilkan daftar profil.
     */
    public function index()
    {
        $profiles = Profile::latest()->paginate(15);
        return view('admin.profiles.index', compact('profiles'));
    }

    /**
     * Tampilkan form tambah profil.
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
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'history'          => 'nullable|string',
            'vision'           => 'nullable|string',
            'mission'          => 'nullable|string',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'regulations'      => 'nullable|string',
            'logo_path'        => 'nullable|image|max:10240',
        ]);

        /**
         * checkbox aktif
         * jika tidak dicentang maka otomatis nonaktif
         */
        $data['is_active'] = $request->has('is_active');

        try {
            if ($request->hasFile('logo_path')) {
                $data['logo_path'] = $this->upload->upload(
                    $request->file('logo_path'),
                    'profiles'
                );
            }

            Profile::create($data);

            return redirect()
                ->route('admin.profiles.index')
                ->with('success', 'Profile created.');

        } catch (\RuntimeException $e) {
            // error dari FileUploadService
            return back()->withInput()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('ProfileController::store failed', [
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal menyimpan profil.');
        }
    }

    /**
     * Tampilkan profil tertentu.
     */
    public function show(Profile $profile)
    {
        return view('admin.profiles.show', compact('profile'));
    }

    /**
     * Tampilkan form edit profil.
     */
    public function edit(Profile $profile)
    {
        return view('admin.profiles.edit', compact('profile'));
    }

    /**
     * Update profil.
     */
    public function update(Request $request, Profile $profile)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'history'          => 'nullable|string',
            'vision'           => 'nullable|string',
            'mission'          => 'nullable|string',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'regulations'      => 'nullable|string',
            'logo_path'        => 'nullable|image|max:10240',
        ]);

        /**
         * checkbox aktif
         */
        $data['is_active'] = $request->has('is_active');

        try {
            if ($request->hasFile('logo_path')) {
                $data['logo_path'] = $this->upload->replace(
                    $profile->logo_path,
                    $request->file('logo_path'),
                    'profiles'
                );
            }

            $profile->update($data);

            return redirect()
                ->route('admin.profiles.index')
                ->with('success', 'Profile updated.');

        } catch (\RuntimeException $e) {
            // error dari FileUploadService
            return back()->withInput()->with('error', $e->getMessage());

        } catch (\Exception $e) {
            Log::error('ProfileController::update failed', [
                'id'    => $profile->id,
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui profil.');
        }
    }

    /**
     * Hapus profil.
     */
    public function destroy(Profile $profile)
    {
        try {
            $this->upload->delete($profile->logo_path);
            $profile->delete();

            return redirect()
                ->route('admin.profiles.index')
                ->with('success', 'Profile deleted.');

        } catch (\Exception $e) {
            Log::error('ProfileController::destroy failed', [
                'id'    => $profile->id,
                'error' => $e->getMessage()
            ]);
            return redirect()
                ->route('admin.profiles.index')
                ->with('error', 'Gagal menghapus profil.');
        }
    }
}
