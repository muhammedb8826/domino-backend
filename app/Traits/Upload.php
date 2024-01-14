<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait Upload
{
    public function Upload(UploadedFile $file, $folder = null)
    {
        return Storage::put($folder, $file);
    }
    public function getFile($path)
    {
        return Storage::download($path);
    }
    public function getTemporaryFilePath($path)
    {
        return Storage::temporaryUrl($path,now()->addMinute(1));
    }

    public function deleteFile($path)
    {
        Storage::delete($path);
    }
    public function getFileUrl($path){
        return Storage::url($path);
    }
}