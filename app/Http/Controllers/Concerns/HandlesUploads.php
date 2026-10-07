<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait HandlesUploads
{
    /**
     * Store an uploaded file under public/uploads and return its public path.
     */
    protected function storeUpload(UploadedFile $file, string $folder): string
    {
        $directory = 'uploads/portfolio/'.$folder;

        if (! is_dir(public_path($directory))) {
            mkdir(public_path($directory), 0755, true);
        }

        $filename = time().'_'.Str::random(8).'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$file->getClientOriginalExtension();

        $file->move(public_path($directory), $filename);

        return $directory.'/'.$filename;
    }

    /**
     * Delete a previously stored public upload.
     */
    protected function deleteUpload(?string $path): void
    {
        if (! $path || ! str_starts_with($path, 'uploads/portfolio/')) {
            return;
        }

        if (is_file(public_path($path))) {
            unlink(public_path($path));
        }
    }
}
