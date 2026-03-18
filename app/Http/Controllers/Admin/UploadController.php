<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * Upload a single image. Returns public URL for use in block content.
     * Note: PHP ini upload_max_filesize (and post_max_size) must allow the file size.
     */
    public function image(Request $request): JsonResponse
    {
        if (! $request->hasFile('image')) {
            return response()->json([
                'message' => 'No file received.',
                'errors' => ['image' => ['The image field is required.']],
            ], 422);
        }

        $file = $request->file('image');
        if (! $file->isValid()) {
            $code = $file->getError();
            $msg = $file->getErrorMessage() ?: 'File upload failed (PHP error code: '.$code.').';
            return response()->json([
                'message' => $msg,
                'errors' => ['image' => [$msg]],
            ], 422);
        }

        $request->validate([
            'image' => ['file', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'],
        ]);

        $path = $file->store('uploads', 'public');

        return response()->json([
            'url' => asset('storage/'.$path),
        ]);
    }
}
