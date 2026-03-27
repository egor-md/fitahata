<?php

namespace App\Support;

use GdImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageVariants
{
    /**
     * Квадратные превью под вёрстку: миниатюры галереи ~80px, карточки каталога, основное фото ~половина 1280.
     *
     * @var list<int>
     */
    public const CATALOG_SQUARE_SIZES = [160, 300, 640];

    /**
     * @param  list<int>  $sizes
     */
    public static function generateSquareVariants(string $sourcePath, array $sizes, int $quality = 82): void
    {
        foreach ($sizes as $size) {
            if ($size < 1) {
                continue;
            }

            $targetPath = self::squareVariantPath($sourcePath, $size);
            if (! self::generateSquareVariant($sourcePath, $targetPath, $size, $quality)) {
                throw new \RuntimeException('Failed to generate image variant: '.$targetPath);
            }
        }
    }

    /**
     * @param  list<int>  $sizes
     */
    public static function squareSrcset(?string $url, array $sizes): ?string
    {
        $parts = [];
        foreach ($sizes as $w) {
            $u = self::squareVariantUrl($url, $w);
            if ($u !== null && $u !== '') {
                $parts[] = $u.' '.$w.'w';
            }
        }

        return $parts !== [] ? implode(', ', $parts) : null;
    }

    public static function squareVariantUrl(?string $url, int $size): ?string
    {
        $path = self::urlPath($url);
        if (! $path || ! Str::startsWith($path, '/images/')) {
            return null;
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        if ($extension === '') {
            return null;
        }

        $variantPath = Str::beforeLast($path, '.'.$extension).'_'.$size.'.webp';
        if (! is_file(public_path(ltrim($variantPath, '/')))) {
            return null;
        }

        return self::replaceUrlPath($url, $variantPath);
    }

    public static function squareVariantPath(string $sourcePath, int $size): string
    {
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);

        return $extension === ''
            ? $sourcePath.'_'.$size.'.webp'
            : Str::beforeLast($sourcePath, '.'.$extension).'_'.$size.'.webp';
    }

    public static function isVariantFilename(string $filename): bool
    {
        return preg_match('/_\d+\.webp$/i', $filename) === 1;
    }

    private static function generateSquareVariant(string $sourcePath, string $targetPath, int $size, int $quality): bool
    {
        $image = self::createImageResource($sourcePath);
        if (! $image) {
            return false;
        }

        $sourceWidth = imagesx($image);
        $sourceHeight = imagesy($image);
        $cropSize = min($sourceWidth, $sourceHeight);
        $offsetX = max(0, (int) floor(($sourceWidth - $cropSize) / 2));
        $maxOffsetY = max(0, $sourceHeight - $cropSize);
        $offsetY = min($maxOffsetY, (int) round($maxOffsetY * 0.2));

        $square = imagecreatetruecolor($size, $size);
        imagealphablending($square, false);
        imagesavealpha($square, true);

        $transparent = imagecolorallocatealpha($square, 0, 0, 0, 127);
        imagefilledrectangle($square, 0, 0, $size, $size, $transparent);

        imagecopyresampled(
            $square,
            $image,
            0,
            0,
            $offsetX,
            $offsetY,
            $size,
            $size,
            $cropSize,
            $cropSize
        );

        File::ensureDirectoryExists(dirname($targetPath));

        $saved = imagewebp($square, $targetPath, $quality);

        imagedestroy($square);
        imagedestroy($image);

        return $saved;
    }

    private static function createImageResource(string $path): ?GdImage
    {
        $mimeType = File::mimeType($path);

        return match ($mimeType) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($path) ?: null,
            'image/png' => @imagecreatefrompng($path) ?: null,
            'image/gif' => @imagecreatefromgif($path) ?: null,
            'image/webp' => @imagecreatefromwebp($path) ?: null,
            default => null,
        };
    }

    private static function replaceUrlPath(?string $url, string $replacementPath): ?string
    {
        if (! is_string($url) || $url === '') {
            return null;
        }

        $parts = parse_url($url);
        $query = isset($parts['query']) ? '?'.$parts['query'] : '';
        $fragment = isset($parts['fragment']) ? '#'.$parts['fragment'] : '';

        if (isset($parts['scheme'], $parts['host'])) {
            $authority = $parts['scheme'].'://'.$parts['host'];
            if (isset($parts['port'])) {
                $authority .= ':'.$parts['port'];
            }

            return $authority.$replacementPath.$query.$fragment;
        }

        return $replacementPath.$query.$fragment;
    }

    private static function urlPath(?string $url): ?string
    {
        if (! is_string($url) || $url === '') {
            return null;
        }

        $path = parse_url($url, PHP_URL_PATH);

        return is_string($path) && $path !== '' ? $path : null;
    }
}
