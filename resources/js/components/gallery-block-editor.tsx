import { useState } from 'react';
import { GripVertical, Plus, Trash2, Upload } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { ImageCropDialog } from '@/components/image-crop-dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { uploadImage } from '@/lib/upload-image';

type GalleryImage = { url: string; alt?: string; caption?: string };
type GalleryContent = {
    columns: 2 | 3;
    images: GalleryImage[];
};

type Props = {
    content: Record<string, unknown>;
    onChange: (content: Record<string, unknown>) => void;
    onRemove: () => void;
};

export function GalleryBlockEditor({ content, onChange, onRemove }: Props) {
    const rawImages = (content.images ?? []) as GalleryImage[];
    const initial: GalleryContent = {
        columns: content.columns === 3 ? 3 : 2,
        images: Array.isArray(rawImages) && rawImages.length > 0
            ? rawImages.map((img) => ({
                  url: String(img?.url ?? ''),
                  alt: img?.alt ?? '',
                  caption: img?.caption ?? '',
              }))
            : [],
    };

    const [open, setOpen] = useState(false);
    const [draft, setDraft] = useState<GalleryContent>(initial);
    const [uploadingIndex, setUploadingIndex] = useState<number | null>(null);
    const [cropOpen, setCropOpen] = useState(false);
    const [cropFile, setCropFile] = useState<File | null>(null);
    const [cropForIndex, setCropForIndex] = useState<number | null>(null);

    function handleSave() {
        onChange({
            columns: draft.columns,
            images: draft.images.filter((img) => img.url.trim() !== ''),
        });
        setOpen(false);
    }

    function addImage() {
        setDraft((prev) => ({
            ...prev,
            images: [...prev.images, { url: '', alt: '', caption: '' }],
        }));
    }

    function removeImage(i: number) {
        setDraft((prev) => ({
            ...prev,
            images: prev.images.filter((_, idx) => idx !== i),
        }));
    }

    function updateImage(i: number, field: keyof GalleryImage, value: string) {
        setDraft((prev) => {
            const next = [...prev.images];
            next[i] = { ...next[i], [field]: value };
            return { ...prev, images: next };
        });
    }

    async function handleUpload(i: number, e: React.ChangeEvent<HTMLInputElement>) {
        const file = e.target.files?.[0];
        if (!file) return;
        setUploadingIndex(i);
        try {
            const url = await uploadImage(file);
            updateImage(i, 'url', url);
        } finally {
            setUploadingIndex(null);
            e.target.value = '';
        }
    }

    const displayImages = (content.images as GalleryImage[] | undefined) ?? [];
    const displayCols = (content.columns === 3 ? 3 : 2) as 2 | 3;
    const displayGridCols = displayCols === 3 ? 'md:grid-cols-3' : 'md:grid-cols-2';

    return (
        <div className="flex gap-2 rounded border p-3">
            <GripVertical className="mt-2 size-4 shrink-0 text-muted-foreground" />
            <div className="flex w-full flex-col gap-3">
                <span className="text-xs font-medium text-muted-foreground">
                    Галерея
                </span>
                <div className={`grid gap-2 ${displayGridCols}`}>
                    {displayImages.length > 0 ? (
                        displayImages.map((img, idx) => (
                            <div
                                key={idx}
                                className="flex aspect-video w-full items-center justify-center overflow-hidden rounded-md border border-dashed bg-muted/40"
                            >
                                {img.url ? (
                                    <img
                                        src={img.url}
                                        alt={img.alt ?? ''}
                                        className="h-full w-full object-cover"
                                    />
                                ) : (
                                    <span className="text-xs text-muted-foreground">
                                        Фото {idx + 1}
                                    </span>
                                )}
                            </div>
                        ))
                    ) : (
                        <div className="col-span-full flex aspect-video items-center justify-center rounded-md border border-dashed bg-muted/40 text-sm text-muted-foreground">
                            Добавьте фото и нажмите «Редактировать блок»
                        </div>
                    )}
                </div>
                <div className="flex gap-2">
                    <Dialog open={open} onOpenChange={setOpen}>
                        <DialogTrigger asChild>
                            <Button type="button" variant="outline" size="sm">
                                Редактировать блок
                            </Button>
                        </DialogTrigger>
                        <DialogContent className="max-h-[90vh] overflow-y-auto">
                            <DialogHeader>
                                <DialogTitle>Галерея</DialogTitle>
                            </DialogHeader>
                            <div className="space-y-4">
                                <div className="space-y-1">
                                    <Label>Колонок (на десктопе)</Label>
                                    <select
                                        value={draft.columns}
                                        onChange={(e) =>
                                            setDraft((prev) => ({
                                                ...prev,
                                                columns: Number(e.target.value) === 3 ? 3 : 2,
                                            }))
                                        }
                                        className="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm"
                                    >
                                        <option value={2}>2 (50% ширины)</option>
                                        <option value={3}>3 (33% ширины)</option>
                                    </select>
                                </div>
                                <div className="space-y-2">
                                    <div className="flex items-center justify-between">
                                        <Label>Фото</Label>
                                        <Button
                                            type="button"
                                            variant="outline"
                                            size="sm"
                                            onClick={addImage}
                                        >
                                            <Plus className="mr-1 size-4" />
                                            Добавить
                                        </Button>
                                    </div>
                                    <div className="space-y-3">
                                        {draft.images.map((img, i) => (
                                            <div
                                                key={i}
                                                className="flex flex-col gap-2 rounded border p-3"
                                            >
                                                <div className="flex items-center justify-between">
                                                    <span className="text-sm font-medium">
                                                        Фото {i + 1}
                                                    </span>
                                                    <Button
                                                        type="button"
                                                        variant="ghost"
                                                        size="icon"
                                                        onClick={() => removeImage(i)}
                                                        disabled={draft.images.length <= 1}
                                                    >
                                                        <Trash2 className="size-4" />
                                                    </Button>
                                                </div>
                                                <div className="flex flex-wrap items-center gap-2">
                                                    <label className="cursor-pointer">
                                                        <input
                                                            type="file"
                                                            accept="image/*"
                                                            className="hidden"
                                                            disabled={uploadingIndex !== null}
                                                            onChange={(e) => handleFileSelect(i, e)}
                                                        />
                                                        <Button
                                                            type="button"
                                                            variant="outline"
                                                            size="sm"
                                                            asChild
                                                        >
                                                            <span>
                                                                <Upload className="mr-1 size-3.5" />
                                                                {uploadingIndex === i
                                                                    ? 'Загрузка…'
                                                                    : 'Загрузить'}
                                                            </span>
                                                        </Button>
                                                    </label>
                                                    <span className="text-xs text-muted-foreground">или URL:</span>
                                                </div>
                                                <Input
                                                    value={img.url}
                                                    onChange={(e) =>
                                                        updateImage(i, 'url', e.target.value)
                                                    }
                                                    placeholder="https://..."
                                                />
                                                {img.url && (
                                                    <img
                                                        src={img.url}
                                                        alt=""
                                                        className="h-20 w-auto max-w-full rounded border object-cover"
                                                    />
                                                )}
                                                <Input
                                                    value={img.alt}
                                                    onChange={(e) =>
                                                        updateImage(i, 'alt', e.target.value)
                                                    }
                                                    placeholder="Alt"
                                                />
                                                <Input
                                                    value={img.caption}
                                                    onChange={(e) =>
                                                        updateImage(i, 'caption', e.target.value)
                                                    }
                                                    placeholder="Подпись"
                                                />
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            </div>
                            <DialogFooter>
                                <Button type="button" onClick={handleSave}>
                                    Сохранить
                                </Button>
                            </DialogFooter>
                        </DialogContent>
                    </Dialog>
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
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        onClick={onRemove}
                    >
                        <Trash2 className="size-4" />
                    </Button>
                </div>
            </div>
        </div>
    );
}
