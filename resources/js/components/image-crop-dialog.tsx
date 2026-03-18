import { useCallback, useEffect, useState } from 'react';
import Cropper from 'react-easy-crop';
import type { Area } from 'react-easy-crop';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import {
    getCroppedImageBlob,
    CROP_ASPECT_OPTIONS,
    type CropArea,
} from '@/lib/crop-image';
import type { MediaSize } from 'react-easy-crop';
import 'react-easy-crop/react-easy-crop.css';

type Props = {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    imageFile: File | null;
    onConfirm: (file: File) => void;
    onCancel?: () => void;
};

export function ImageCropDialog({
    open,
    onOpenChange,
    imageFile,
    onConfirm,
    onCancel,
}: Props) {
    const [imageSrc, setImageSrc] = useState('');
    const [aspectIndex, setAspectIndex] = useState(0);
    const [crop, setCrop] = useState({ x: 0, y: 0 });
    const [zoom, setZoom] = useState(1);
    const [croppedAreaPixels, setCroppedAreaPixels] = useState<CropArea | null>(null);
    const [mediaSize, setMediaSize] = useState<MediaSize | null>(null);
    const [busy, setBusy] = useState(false);

    useEffect(() => {
        if (!open || !imageFile) {
            setImageSrc('');
            return;
        }
        const url = URL.createObjectURL(imageFile);
        setImageSrc(url);
        setCroppedAreaPixels(null);
        setMediaSize(null);
        return () => {
            URL.revokeObjectURL(url);
            setImageSrc('');
        };
    }, [open, imageFile]);

    const aspectOpt = CROP_ASPECT_OPTIONS[aspectIndex];
    const aspect: number =
        aspectOpt.value === 'free' && mediaSize
            ? mediaSize.naturalWidth / mediaSize.naturalHeight
            : typeof aspectOpt.value === 'number'
              ? aspectOpt.value
              : 1;

    const onCropComplete = useCallback((_: Area, croppedAreaPx: Area) => {
        setCroppedAreaPixels({
            x: croppedAreaPx.x,
            y: croppedAreaPx.y,
            width: croppedAreaPx.width,
            height: croppedAreaPx.height,
        });
    }, []);

    const onMediaLoaded = useCallback((size: MediaSize) => {
        setMediaSize(size);
    }, []);

    const handleConfirm = async () => {
        if (!imageFile || !croppedAreaPixels) return;
        setBusy(true);
        try {
            const blob = await getCroppedImageBlob(imageSrc, croppedAreaPixels);
            const ext = imageFile.name.split('.').pop()?.toLowerCase() || 'jpg';
            const type = blob.type || (ext === 'png' ? 'image/png' : 'image/jpeg');
            const name = imageFile.name.replace(/\.[^.]+$/, '') + '-cropped.' + (type === 'image/png' ? 'png' : 'jpg');
            const file = new File([blob], name, { type });
            onConfirm(file);
            onOpenChange(false);
        } finally {
            setBusy(false);
        }
    };

    const handleClose = (nextOpen: boolean) => {
        if (!nextOpen) onCancel?.();
        onOpenChange(nextOpen);
    };

    return (
        <Dialog open={open} onOpenChange={handleClose}>
            <DialogContent className="max-h-[90vh] max-w-2xl overflow-hidden p-0">
                <DialogHeader className="p-4 pb-0">
                    <DialogTitle>Обрезка изображения</DialogTitle>
                </DialogHeader>
                <div className="flex flex-col gap-3 p-4">
                    <div className="flex flex-wrap gap-2">
                        <span className="text-muted-foreground flex items-center text-sm">Формат:</span>
                        {CROP_ASPECT_OPTIONS.map((opt, i) => (
                            <Button
                                key={opt.label}
                                type="button"
                                size="sm"
                                variant={aspectIndex === i ? 'default' : 'outline'}
                                onClick={() => {
                                    setAspectIndex(i);
                                    setCroppedAreaPixels(null);
                                }}
                            >
                                {opt.label}
                            </Button>
                        ))}
                    </div>
                    {imageSrc && (
                        <div className="relative h-[min(50vh,400px)] w-full overflow-hidden rounded-md bg-muted">
                            <Cropper
                                image={imageSrc}
                                crop={crop}
                                zoom={zoom}
                                aspect={aspect}
                                onCropChange={setCrop}
                                onCropComplete={onCropComplete}
                                onMediaLoaded={onMediaLoaded}
                                onZoomChange={setZoom}
                            />
                        </div>
                    )}
                </div>
                <DialogFooter className="p-4">
                    <Button
                        type="button"
                        variant="outline"
                        onClick={() => handleClose(false)}
                    >
                        Отмена
                    </Button>
                    <Button
                        type="button"
                        onClick={handleConfirm}
                        disabled={!croppedAreaPixels || busy}
                    >
                        {busy ? 'Сохранение…' : 'Применить'}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}
