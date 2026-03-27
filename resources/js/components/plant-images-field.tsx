import { useState } from 'react';
import { GripVertical, Plus, Trash2, Upload } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { ImageCropDialog } from '@/components/image-crop-dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { uploadImage } from '@/lib/upload-image';

export type PlantImageRow = {
    url: string;
    sort_order: number;
    is_primary: boolean;
};

type Props = {
    images: PlantImageRow[];
    onChange: (next: PlantImageRow[]) => void;
};

export function PlantImagesField({ images, onChange }: Props) {
    const [uploadingIndex, setUploadingIndex] = useState<number | null>(null);
    const [cropOpen, setCropOpen] = useState(false);
    const [cropFile, setCropFile] = useState<File | null>(null);
    const [cropForIndex, setCropForIndex] = useState<number | null>(null);

    function setRow(i: number, patch: Partial<PlantImageRow>) {
        onChange(
            images.map((row, idx) => (idx === i ? { ...row, ...patch } : row)),
        );
    }

    function addRow() {
        onChange([
            ...images,
            {
                url: '',
                sort_order: images.length,
                is_primary: images.length === 0,
            },
        ]);
    }

    function removeRow(i: number) {
        const next = images.filter((_, idx) => idx !== i);
        if (next.length && !next.some((r) => r.is_primary)) {
            next[0] = { ...next[0], is_primary: true };
        }
        onChange(next.map((r, idx) => ({ ...r, sort_order: idx })));
    }

    function handleFileSelect(i: number, e: React.ChangeEvent<HTMLInputElement>) {
        const file = e.target.files?.[0];
        if (!file) return;
        e.target.value = '';
        setCropForIndex(i);
        setCropFile(file);
        setCropOpen(true);
    }

    async function handleCropConfirm(croppedFile: File) {
        const i = cropForIndex;
        setCropFile(null);
        setCropForIndex(null);
        if (i === null) return;
        setUploadingIndex(i);
        try {
            const url = await uploadImage(croppedFile, 'catalog');
            setRow(i, { url });
        } finally {
            setUploadingIndex(null);
        }
    }

    function setPrimary(i: number) {
        onChange(
            images.map((row, idx) => ({
                ...row,
                is_primary: idx === i,
            })),
        );
    }

    return (
        <div className="space-y-3 rounded border p-3">
            <div className="flex items-center justify-between">
                <Label>Фото галереи</Label>
                <Button type="button" variant="outline" size="sm" onClick={addRow}>
                    <Plus className="mr-1 size-4" />
                    Добавить
                </Button>
            </div>
            {images.length === 0 ? (
                <p className="text-sm text-muted-foreground">
                    Нет фото — нажмите «Добавить».
                </p>
            ) : (
                <div className="space-y-3">
                    {images.map((row, i) => (
                        <div
                            key={i}
                            className="flex flex-col gap-2 rounded border bg-muted/20 p-3 sm:flex-row"
                        >
                            <GripVertical className="mt-2 hidden size-4 shrink-0 text-muted-foreground sm:block" />
                            <div className="min-w-0 flex-1 space-y-2">
                                <div className="flex flex-wrap items-center gap-2">
                                    <label className="cursor-pointer">
                                        <input
                                            type="file"
                                            accept="image/*"
                                            className="hidden"
                                            disabled={uploadingIndex !== null}
                                            onChange={(e) => handleFileSelect(i, e)}
                                        />
                                        <Button type="button" variant="outline" size="sm" asChild>
                                            <span>
                                                <Upload className="mr-1 size-3.5" />
                                                {uploadingIndex === i
                                                    ? 'Загрузка…'
                                                    : 'Загрузить'}
                                            </span>
                                        </Button>
                                    </label>
                                    <span className="text-xs text-muted-foreground">
                                        или URL:
                                    </span>
                                </div>
                                <Input
                                    value={row.url}
                                    onChange={(e) => setRow(i, { url: e.target.value })}
                                    placeholder="/images/..."
                                />
                                {row.url ? (
                                    <img
                                        src={row.url}
                                        alt=""
                                        className="h-24 max-w-full rounded border object-cover"
                                    />
                                ) : null}
                                <div className="flex flex-wrap items-center gap-3">
                                    <label className="flex items-center gap-2 text-sm">
                                        <input
                                            type="radio"
                                            name="plant_primary_image"
                                            checked={row.is_primary}
                                            onChange={() => setPrimary(i)}
                                        />
                                        Главное в слайдере
                                    </label>
                                    <Button
                                        type="button"
                                        variant="ghost"
                                        size="icon"
                                        onClick={() => removeRow(i)}
                                        disabled={images.length <= 1}
                                    >
                                        <Trash2 className="size-4" />
                                    </Button>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            )}
            <ImageCropDialog
                open={cropOpen}
                onOpenChange={setCropOpen}
                imageFile={cropFile}
                onConfirm={handleCropConfirm}
                onCancel={() => {
                    setCropFile(null);
                    setCropForIndex(null);
                }}
            />
        </div>
    );
}
