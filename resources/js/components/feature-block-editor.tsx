import { useState } from 'react';
import { GripVertical, Trash2, Upload } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { uploadImage } from '@/lib/upload-image';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { ImageCropDialog } from '@/components/image-crop-dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

type LayoutConfig = {
    imageWidth: '1/2' | '1/3';
    order: 'image-first' | 'text-first';
};

type FeatureContent = {
    imageUrl: string;
    imageAlt: string;
    title: string;
    price: string;
    text: string;
    layout: LayoutConfig;
};

type Props = {
    content: Record<string, unknown>;
    onChange: (content: Record<string, unknown>) => void;
    onRemove: () => void;
};

export function FeatureBlockEditor({ content, onChange, onRemove }: Props) {
    const rawLayout = (content.layout ?? {}) as Partial<LayoutConfig>;
    const initial: FeatureContent = {
        imageUrl: String(content.imageUrl ?? ''),
        imageAlt: String(content.imageAlt ?? ''),
        title: String(content.title ?? ''),
        price: String(content.price ?? ''),
        text: String(content.text ?? ''),
        layout: {
            imageWidth: rawLayout.imageWidth === '1/3' ? '1/3' : '1/2',
            order: rawLayout.order === 'text-first' ? 'text-first' : 'image-first',
        },
    };

    const [open, setOpen] = useState(false);
    const [draft, setDraft] = useState<FeatureContent>(initial);
    const [uploading, setUploading] = useState(false);
    const [cropOpen, setCropOpen] = useState(false);
    const [cropFile, setCropFile] = useState<File | null>(null);

    function handleSave() {
        onChange(draft);
        setOpen(false);
    }

    const gridCols =
        draft.layout.imageWidth === '1/3' ? 'md:grid-cols-3' : 'md:grid-cols-2';
    const imageSpan =
        draft.layout.imageWidth === '1/3' ? 'md:col-span-1' : '';
    const textSpan =
        draft.layout.imageWidth === '1/3' ? 'md:col-span-2' : '';
    const imageFirst = draft.layout.order === 'image-first';

    const imageNode = (
        <div
            className={`flex items-center justify-center rounded-md border border-dashed bg-muted/40 p-2 ${imageSpan}`}
        >
            {draft.imageUrl ? (
                <img
                    src={draft.imageUrl}
                    alt={draft.imageAlt}
                    className="aspect-video w-full rounded-md border object-cover"
                />
            ) : (
                <div className="flex aspect-video w-full items-center justify-center text-xs text-muted-foreground">
                    Превью изображения
                </div>
            )}
        </div>
    );

    const textNode = (
        <div className={`flex flex-col gap-1 ${textSpan}`}>
            <span className="text-xs font-medium text-muted-foreground">
                Сложный блок 50/50
            </span>
            <div className="text-base font-semibold">
                {draft.title || 'Заголовок'}
            </div>
            {draft.price && (
                <div className="text-lg font-semibold text-primary">
                    {draft.price}
                </div>
            )}
            {draft.text && (
                <p className="mt-1 line-clamp-3 text-sm text-muted-foreground">
                    {draft.text}
                </p>
            )}
        </div>
    );

    return (
        <div className="flex gap-2 rounded border p-3">
            <GripVertical className="mt-2 size-4 shrink-0 text-muted-foreground" />
            <div className="flex w-full flex-col gap-3">
                <div className={`grid gap-4 ${gridCols}`}>
                    {imageFirst ? (
                        <>
                            {imageNode}
                            {textNode}
                        </>
                    ) : (
                        <>
                            {textNode}
                            {imageNode}
                        </>
                    )}
                </div>
                <div className="flex gap-2">
                    <Dialog open={open} onOpenChange={setOpen}>
                        <DialogTrigger asChild>
                            <Button type="button" variant="outline" size="sm">
                                Редактировать блок
                            </Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle>Сложный блок 50/50</DialogTitle>
                            </DialogHeader>
                            <div className="grid gap-4 md:grid-cols-2">
                                <div className="space-y-3">
                                    <div className="space-y-1">
                                        <Label>Изображение</Label>
                                        <div className="flex flex-wrap items-center gap-2">
                                            <label className="cursor-pointer">
                                                <input
                                                    type="file"
                                                    accept="image/*"
                                                    className="hidden"
                                                    disabled={uploading}
                                                    onChange={(e) => {
                                                        const file = e.target.files?.[0];
                                                        if (!file) return;
                                                        e.target.value = '';
                                                        setCropFile(file);
                                                        setCropOpen(true);
                                                    }}
                                                />
                                                <Button type="button" variant="outline" size="sm" asChild>
                                                    <span>
                                                        <Upload className="mr-1 size-3.5" />
                                                        {uploading ? 'Загрузка…' : 'Загрузить фото'}
                                                    </span>
                                                </Button>
                                            </label>
                                            <span className="text-xs text-muted-foreground">или URL:</span>
                                        </div>
                                        <ImageCropDialog
                                            open={cropOpen}
                                            onOpenChange={setCropOpen}
                                            imageFile={cropFile}
                                            onConfirm={async (croppedFile) => {
                                                setCropFile(null);
                                                setUploading(true);
                                                try {
                                                    const url = await uploadImage(croppedFile);
                                                    setDraft((prev) => ({ ...prev, imageUrl: url }));
                                                } finally {
                                                    setUploading(false);
                                                }
                                            }}
                                            onCancel={() => setCropFile(null)}
                                        />
                                        <Input
                                            id="feature-image-url"
                                            value={draft.imageUrl}
                                            onChange={(e) =>
                                                setDraft((prev) => ({
                                                    ...prev,
                                                    imageUrl: e.target.value,
                                                }))
                                            }
                                            placeholder="https://example.com/image.jpg"
                                            className="mt-1"
                                        />
                                    </div>
                                    <div className="space-y-1">
                                        <Label htmlFor="feature-image-alt">
                                            Alt
                                        </Label>
                                        <Input
                                            id="feature-image-alt"
                                            value={draft.imageAlt}
                                            onChange={(e) =>
                                                setDraft((prev) => ({
                                                    ...prev,
                                                    imageAlt: e.target.value,
                                                }))
                                            }
                                            placeholder="Описание изображения"
                                        />
                                    </div>
                                </div>
                                <div className="space-y-3">
                                    <div className="space-y-1">
                                        <Label htmlFor="feature-title">
                                            Заголовок
                                        </Label>
                                        <Input
                                            id="feature-title"
                                            value={draft.title}
                                            onChange={(e) =>
                                                setDraft((prev) => ({
                                                    ...prev,
                                                    title: e.target.value,
                                                }))
                                            }
                                            placeholder="Заголовок товара"
                                        />
                                    </div>
                                    <div className="space-y-1">
                                        <Label htmlFor="feature-price">
                                            Цена
                                        </Label>
                                        <Input
                                            id="feature-price"
                                            value={draft.price}
                                            onChange={(e) =>
                                                setDraft((prev) => ({
                                                    ...prev,
                                                    price: e.target.value,
                                                }))
                                            }
                                            placeholder="Например: 9 990 ₽"
                                        />
                                    </div>
                                    <div className="space-y-1">
                                        <Label htmlFor="feature-text">
                                            Текст
                                        </Label>
                                        <textarea
                                            id="feature-text"
                                            value={draft.text}
                                            onChange={(e) =>
                                                setDraft((prev) => ({
                                                    ...prev,
                                                    text: e.target.value,
                                                }))
                                            }
                                            rows={4}
                                            className="flex w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]"
                                            placeholder="Описание или преимущества"
                                        />
                                    </div>
                                    <div className="space-y-1">
                                        <Label>Расположение</Label>
                                        <div className="flex flex-wrap gap-2">
                                            <Button
                                                type="button"
                                                size="sm"
                                                variant={
                                                    draft.layout.order ===
                                                    'image-first'
                                                        ? 'default'
                                                        : 'outline'
                                                }
                                                onClick={() =>
                                                    setDraft((prev) => ({
                                                        ...prev,
                                                        layout: {
                                                            ...prev.layout,
                                                            order: 'image-first',
                                                        },
                                                    }))
                                                }
                                            >
                                                Картинка слева
                                            </Button>
                                            <Button
                                                type="button"
                                                size="sm"
                                                variant={
                                                    draft.layout.order ===
                                                    'text-first'
                                                        ? 'default'
                                                        : 'outline'
                                                }
                                                onClick={() =>
                                                    setDraft((prev) => ({
                                                        ...prev,
                                                        layout: {
                                                            ...prev.layout,
                                                            order: 'text-first',
                                                        },
                                                    }))
                                                }
                                            >
                                                Картинка справа
                                            </Button>
                                        </div>
                                    </div>
                                    <div className="space-y-1">
                                        <Label htmlFor="feature-image-width">
                                            Ширина картинки (на десктопе)
                                        </Label>
                                        <select
                                            id="feature-image-width"
                                            value={draft.layout.imageWidth}
                                            onChange={(e) =>
                                                setDraft((prev) => ({
                                                    ...prev,
                                                    layout: {
                                                        ...prev.layout,
                                                        imageWidth:
                                                            e.target.value ===
                                                            '1/3'
                                                                ? '1/3'
                                                                : '1/2',
                                                    },
                                                }))
                                            }
                                            className="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs"
                                        >
                                            <option value="1/2">
                                                1/2 ширины (50%)
                                            </option>
                                            <option value="1/3">
                                                1/3 ширины (33%)
                                            </option>
                                        </select>
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

