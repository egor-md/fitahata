<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\ImageVariants;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
            'collection' => ['required', 'string', 'in:catalog,recipes,plants'],
        ]);

        $collection = (string) $request->input('collection');
        if ($collection === 'plants') {
            $collection = 'catalog';
        }
        $image = $this->createImageResource($file->getRealPath(), (string) $file->getMimeType());

        if (! $image) {
            return response()->json([
                'message' => 'Unsupported image type.',
                'errors' => ['image' => ['Не удалось обработать изображение.']],
            ], 422);
        }

        $optimized = $this->resizeIfNeeded($image, 2000);
        if ($optimized !== $image) {
            imagedestroy($image);
        }

        $directory = public_path('images/'.$collection);
        File::ensureDirectoryExists($directory);

        $filename = (string) Str::uuid().'.webp';
        $absolutePath = $directory.DIRECTORY_SEPARATOR.$filename;

        if (! imagewebp($optimized, $absolutePath, 82)) {
            imagedestroy($optimized);

            return response()->json([
                'message' => 'Failed to save optimized image.',
                'errors' => ['image' => ['Не удалось сохранить оптимизированное изображение.']],
            ], 500);
        }

        imagedestroy($optimized);

        if ($collection === 'catalog') {
            ImageVariants::generateSquareVariants($absolutePath, ImageVariants::CATALOG_SQUARE_SIZES);
        }

        return response()->json([
            'url' => asset('images/'.$collection.'/'.$filename),
        ]);
    }

    private function createImageResource(string $path, string $mimeType): ?\GdImage
    {
        return match ($mimeType) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($path) ?: null,
            'image/png' => @imagecreatefrompng($path) ?: null,
            'image/gif' => @imagecreatefromgif($path) ?: null,
            'image/webp' => @imagecreatefromwebp($path) ?: null,
            default => null,
        };
    }

    private function resizeIfNeeded(\GdImage $image, int $maxDimension): \GdImage
    {
        $width = imagesx($image);
        $height = imagesy($image);
        $largestSide = max($width, $height);

        if ($largestSide <= $maxDimension) {
            return $image;
        }

        $scale = $maxDimension / $largestSide;
        $targetWidth = max(1, (int) round($width * $scale));
        $targetHeight = max(1, (int) round($height * $scale));

        $resized = imagecreatetruecolor($targetWidth, $targetHeight);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
        imagefilledrectangle($resized, 0, 0, $targetWidth, $targetHeight, $transparent);

        imagecopyresampled($resized, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        return $resized;
    }
}
