/**
 * Crop area in pixels (natural image coordinates).
 */
export type CropArea = { x: number; y: number; width: number; height: number };

/**
 * Produce a blob of the cropped image from image URL and crop area in pixels.
 * Use croppedAreaPixels from react-easy-crop so the canvas draws correctly (no black).
 */
export function getCroppedImageBlob(
    imageSrc: string,
    cropPixels: CropArea,
    mimeType: string = 'image/jpeg',
    quality: number = 0.9
): Promise<Blob> {
    return new Promise((resolve, reject) => {
        const image = new Image();
        if (!imageSrc.startsWith('blob:')) {
            image.crossOrigin = 'anonymous';
        }
        image.onload = () => {
            const { naturalWidth, naturalHeight } = image;
            const x = Math.max(0, Math.min(cropPixels.x, naturalWidth - 1));
            const y = Math.max(0, Math.min(cropPixels.y, naturalHeight - 1));
            const w = Math.max(1, Math.min(cropPixels.width, naturalWidth - x));
            const h = Math.max(1, Math.min(cropPixels.height, naturalHeight - y));

            const canvas = document.createElement('canvas');
            canvas.width = Math.round(w);
            canvas.height = Math.round(h);
            const ctx = canvas.getContext('2d');
            if (!ctx) {
                reject(new Error('Canvas 2d not available'));
                return;
            }
            ctx.drawImage(
                image,
                x, y, w, h,
                0, 0, canvas.width, canvas.height
            );
            canvas.toBlob(
                (blob) => (blob ? resolve(blob) : reject(new Error('toBlob failed'))),
                mimeType,
                quality
            );
        };
        image.onerror = () => reject(new Error('Failed to load image'));
        image.src = imageSrc;
    });
}

export type CropAspectOption = { label: string; value: number | 'free' };
export const CROP_ASPECT_OPTIONS: CropAspectOption[] = [
    { label: '1:1', value: 1 },
    { label: '3:4', value: 3 / 4 },
    { label: '4:3', value: 4 / 3 },
    { label: '16:9', value: 16 / 9 },
    { label: 'Свободный', value: 'free' },
];
