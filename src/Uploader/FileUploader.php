<?php

namespace HopekellDev\Core\Uploader;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class FileUploader
{
    public static function upload(
        UploadedFile $file,
        string $path = 'uploads'
    ): string {
        $name = Str::uuid().'.'.$file->getClientOriginalExtension();

        return $file->storeAs($path, $name, 'public');
    }
}
