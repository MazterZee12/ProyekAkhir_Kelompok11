<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageSeederHelper
{
    /**
     * Download gambar dari URL dan simpan ke storage publik.
     * Return path relatif (misal: "galleries/abc123.jpg")
     * atau null kalau gagal.
     */
    protected function downloadImage(string $url, string $folder): ?string
    {
        try {
            $contents = file_get_contents($url);
            if ($contents === false) return null;

            $ext      = 'jpg';
            $filename = Str::random(20) . '.' . $ext;
            $path     = $folder . '/' . $filename;

            Storage::disk('public')->put($path, $contents);
            return $path;
        } catch (\Exception $e) {
            \Log::warning("ImageSeederHelper: gagal download {$url} — " . $e->getMessage());
            return null;
        }
    }
}
