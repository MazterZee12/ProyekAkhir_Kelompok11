<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    /**
     * Upload file baru dan simpan record ke tabel media.
     * Return: Media model yang baru dibuat.
     */
    public function store(UploadedFile $file, string $folder): Media
    {
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs($folder, $filename, 'public');

        return Media::create([
            'file_name'   => $file->getClientOriginalName(),
            'file_path'   => $path,
            'mime_type'   => $file->getMimeType(),
            'file_size'   => $file->getSize(),
            'uploaded_by' => Auth::id(),
        ]);
    }

    /**
     * Ganti file lama dengan file baru.
     * File lama di storage dihapus, record media lama dihapus,
     * lalu buat record media baru.
     * Return: Media model yang baru dibuat.
     */
    public function replace(?Media $oldMedia, UploadedFile $file, string $folder): Media
    {
        if ($oldMedia) {
            Storage::disk('public')->delete($oldMedia->file_path);
            $oldMedia->delete();
        }

        return $this->store($file, $folder);
    }

    /**
     * Hapus file dari storage dan hapus record media dari database.
     */
    public function delete(?Media $media): void
    {
        if (!$media) {
            return;
        }

        Storage::disk('public')->delete($media->file_path);
        $media->delete();
    }
}
