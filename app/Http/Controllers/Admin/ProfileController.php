<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    protected MediaService $media;

    public function __construct(MediaService $media)
    {
        $this->media = $media;
    }

    public function index()
    {
        $profiles = Profile::with('media')
            ->latest()
            ->paginate(15);

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
            'photo'            => 'nullable|image|max:10240',
        ]);

        $data['is_active'] = $request->has('is_active');

        try {
            if ($request->hasFile('photo')) {
                $media = $this->media->store(
                    $request->file('photo'),
                    'profiles'
                );

                $data['media_id'] = $media->id;
            }

            Profile::create($data);

            return redirect()
                ->route('admin.profiles.index')
                ->with('success', 'Profil berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('ProfileController::store failed', [
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan profil.');
        }
    }

    public function show(Profile $profile)
    {
        $profile->load('media');

        return view('admin.profiles.show', compact('profile'));
    }

    public function edit(Profile $profile)
    {
        $profile->load('media');

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
            'photo'            => 'nullable|image|max:10240',
        ]);

        $data['is_active'] = $request->has('is_active');

        try {
            if ($request->hasFile('photo')) {
                $media = $this->media->replace(
                    $profile->media,
                    $request->file('photo'),
                    'profiles'
                );

                $data['media_id'] = $media->id;
            }

            $profile->update($data);

            return redirect()
                ->route('admin.profiles.index')
                ->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('ProfileController::update failed', [
                'id'    => $profile->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui profil.');
        }
    }

    public function destroy(Profile $profile)
    {
        try {
            if ($profile->media) {
                $this->media->delete($profile->media);
            }

            $profile->delete();

            return redirect()
                ->route('admin.profiles.index')
                ->with('success', 'Profil berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('ProfileController::destroy failed', [
                'id'    => $profile->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.profiles.index')
                ->with('error', 'Gagal menghapus profil.');
        }
    }
}
