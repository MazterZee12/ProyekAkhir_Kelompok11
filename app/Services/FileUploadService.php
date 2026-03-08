<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function upload($file, $folder)
    {
        return $file->store($folder, 'public');
    }

    public function replace($oldPath, $file, $folder)
    {
        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $this->upload($file, $folder);
    }

    public function delete($path)
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
