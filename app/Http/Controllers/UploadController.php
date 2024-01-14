<?php

namespace App\Http\Controllers;

use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    use Upload;

    public function uploadFile(Request $request)
    {

        if ($request->hasFile('file')) {
            $path = $this->Upload($request->file('file'), 'public/profile');
            return response()->json([
                'path' => $path,
            ], 200);
        }
    }

    public function get(Request $request)
    {
        if ($request->query('path')) {
            $filePath= $request->query('path');
            if (Storage::exists($filePath)) {
            $file = Storage::get($filePath);
            $contentType = Storage::mimeType($filePath);

            return response($file)
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', 'inline');
        }
            return $this->getFile($request->query('path'));
        }
    }
    public function getUrl(Request $request)
    {
        if ($request->query('path')) {
            return $this->getFileUrl($request->query('path'));
        }
    }
    public function getTemporaryPath(Request $request)
    {
        if ($request->query('path')) {
            return $this->getTemporaryFilePath($request->query('path'));
        }
    }

}
