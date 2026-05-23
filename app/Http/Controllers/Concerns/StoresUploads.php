<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\UploadedFile;

trait StoresUploads
{
    protected function uploadImage(?UploadedFile $file): ?string
    {
        if (! $file) {
            return null;
        }

        return $file->store('uploads', 'public');
    }
}
