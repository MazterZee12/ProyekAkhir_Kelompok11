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

    public function index()
    {
        $profiles = Profile::latest()->paginate(15);
        return view('admin.profiles.index', compact('profiles'));
    }

    public function create()
    {
        $profile = null;
        return view('admin.profiles.create', compact('profile'));
    }

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
            'photo_path'       => 'nullable|image|max:10240',
        ]);

        $data['is_active'] = $request->has('is_active');

        try {
            if ($request->hasFile('photo_path')) {
                $data['photo_path'] = $this->upload->upload(
                    $request->file('photo_path'),
                    'profiles'
                );
            }

            Profile::create($data);

            return redirect()
                ->route('admin.profiles.index')
                ->with('success', 'Profile created.');

        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('ProfileController::store failed', [
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal menyimpan profil.');
        }
    }

    public function show(Profile $profile)
    {
        return view('admin.profiles.show', compact('profile'));
    }

    public function edit(Profile $profile)
    {
        return view('admin.profiles.edit', compact('profile'));
    }

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
            'photo_path'       => 'nullable|image|max:10240',
        ]);

        $data['is_active'] = $request->has('is_active');

        try {
            if ($request->hasFile('photo_path')) {
                $data['photo_path'] = $this->upload->replace(
                    $profile->photo_path,
                    $request->file('photo_path'),
                    'profiles'
                );
            }

            $profile->update($data);

            return redirect()
                ->route('admin.profiles.index')
                ->with('success', 'Profile updated.');

        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('ProfileController::update failed', [
                'id'    => $profile->id,
                'error' => $e->getMessage()
            ]);
            return back()->withInput()->with('error', 'Gagal memperbarui profil.');
        }
    }

    public function destroy(Profile $profile)
    {
        try {
            if ($profile->photo_path) {
                $this->upload->delete($profile->photo_path);
            }
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
