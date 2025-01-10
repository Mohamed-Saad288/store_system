<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public static function upload($file, $directory)
    {
        return $file->store($directory, "uploads");
    }

    public static function delete($path)
    {
        if (Storage::disk("uploads")->exists($path)) {
            Storage::disk("uploads")->delete($path);
        }
    }
}
