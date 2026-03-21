<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FileUploadService
{
    /**
     * Upload file baru.
     */
    public function upload($file, $folder)
    {
        try {
            $path = $file->store($folder, 'public');

            if (!$path) {
                throw new \RuntimeException('File gagal disimpan.');
            }

            return $path;

        } catch (\Exception $e) {
            Log::error('FileUploadService::upload failed', [
                'folder'  => $folder,
                'error'   => $e->getMessage(),
            ]);
            throw new \RuntimeException('Upload file gagal. Silakan coba lagi.');
        }
    }

    /**
     * Ganti file lama dengan file baru.
     */
    public function replace($oldPath, $file, $folder)
    {
        try {
            $newPath = $this->upload($file, $folder);

            // hapus file lama hanya jika upload baru berhasil
            if ($oldPath) {
                $this->delete($oldPath);
            }

            return $newPath;

        } catch (\Exception $e) {
            Log::error('FileUploadService::replace failed', [
                'old_path' => $oldPath,
                'folder'   => $folder,
                'error'    => $e->getMessage(),
            ]);
            throw new \RuntimeException('Gagal mengganti file. Silakan coba lagi.');
        }
    }

    /**
     * Hapus file dari storage.
     */
    public function delete($path)
    {
        try {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        } catch (\Exception $e) {
            // log aja, tidak perlu throw karena delete gagal tidak kritis
            Log::warning('FileUploadService::delete failed', [
                'path'  => $path,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
