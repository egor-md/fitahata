import { Head, Link } from '@inertiajs/react';
import { Form } from '@inertiajs/react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/input-error';
import { ImageCropDialog } from '@/components/image-crop-dialog';
import AppLayout from '@/layouts/app-layout';
import { create, index, store } from '@/routes/admin/blocks';
import { uploadImage } from '@/lib/upload-image';
import type { BreadcrumbItem } from '@/types';
import { ArrowLeft, Plus, Trash2, Upload } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Админка', href: '/dashboard' },
    { title: 'Блоки', href: index.url() },
    { title: 'Создать', href: create.url() },
];

export default function AdminBlocksCreate() {
    const [type, setType] = useState<'gallery' | 'carousel'>('gallery');
    const [images, setImages] = useState<Array<{ url: string; alt: string; caption: string }>>([
        { url: '', alt: '', caption: '' },
    ]);
    const [uploadingIndex, setUploadingIndex] = useState<number | null>(null);

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

    function addImage() {
        setImages((prev) => [...prev, { url: '', alt: '', caption: '' }]);
    }

    function removeImage(i: number) {
        setImages((prev) => prev.filter((_, idx) => idx !== i));
    }

    function updateImage(i: number, field: 'url' | 'alt' | 'caption', value: string) {
        setImages((prev) => {
            const next = [...prev];
            next[i] = { ...next[i], [field]: value };
            return next;
        });
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Создать блок" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center gap-4">
                    <Button variant="ghost" size="icon" asChild>
                        <Link href={index.url()}>
                            <ArrowLeft className="size-4" />
                        </Link>
                    </Button>
                    <h1 className="text-xl font-semibold">Создать блок</h1>
                </div>

                <Form
                    action={store.url()}
                    method="post"
                    className="max-w-2xl space-y-6"
                >
                    {({ errors }) => (
                        <>
                            <div className="space-y-2">
                                <Label htmlFor="name">Название</Label>
                                <Input
                                    id="name"
                                    name="name"
                                    required
                                    autoFocus
                                    placeholder="Название блока"
                                />
                                <InputError message={errors.name} />
                            </div>

                            <div className="space-y-2">
                                <Label>Тип</Label>
                                <div className="flex gap-4">
                                    <label className="flex items-center gap-2">
                                        <input
                                            type="radio"
                                            name="type"
                                            value="gallery"
                                            checked={type === 'gallery'}
                                            onChange={() => setType('gallery')}
                                            className="size-4"
                                        />
                                        Галерея
                                    </label>
                                    <label className="flex items-center gap-2">
                                        <input
                                            type="radio"
                                            name="type"
                                            value="carousel"
                                            checked={type === 'carousel'}
                                            onChange={() => setType('carousel')}
                                            className="size-4"
                                        />
                                        Карусель
                                    </label>
                                </div>
                                <InputError message={errors.type} />
                            </div>

                            <div className="space-y-2">
                                <div className="flex items-center justify-between">
                                    <Label>Изображения</Label>
                                    <Button
                                        type="button"
                                        variant="outline"
                                        size="sm"
                                        onClick={addImage}
                                    >
                                        <Plus className="size-4" />
                                        Добавить
                                    </Button>
                                </div>
                                <div className="space-y-4">
                                    {images.map((img, i) => (
                                        <div
                                            key={i}
                                            className="flex flex-col gap-2 rounded border p-3"
                                        >
                                            <div className="flex justify-between">
                                                <span className="text-sm font-medium">
                                                    Изображение {i + 1}
                                                </span>
                                                <Button
                                                    type="button"
                                                    variant="ghost"
                                                    size="icon"
                                                    onClick={() => removeImage(i)}
                                                    disabled={images.length <= 1}
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
                                                name={`settings[images][${i}][url]`}
                                                placeholder="URL изображения"
                                                value={img.url}
                                                onChange={(e) =>
                                                    updateImage(i, 'url', e.target.value)
                                                }
                                                required
                                            />
                                            {img.url && (
                                                <img
                                                    src={img.url}
                                                    alt=""
                                                    className="h-20 w-auto max-w-full rounded border object-cover"
                                                />
                                            )}
                                            <Input
                                                name={`settings[images][${i}][alt]`}
                                                placeholder="Alt (необязательно)"
                                                value={img.alt}
                                                onChange={(e) =>
                                                    updateImage(i, 'alt', e.target.value)
                                                }
                                            />
                                            <Input
                                                name={`settings[images][${i}][caption]`}
                                                placeholder="Подпись (необязательно)"
                                                value={img.caption}
                                                onChange={(e) =>
                                                    updateImage(i, 'caption', e.target.value)
                                                }
                                            />
                                        </div>
                                    ))}
                                </div>
                            </div>

                            <div className="flex gap-2">
                                <Button type="submit">Создать</Button>
                                <Button type="button" variant="outline" asChild>
                                    <Link href={index.url()}>Отмена</Link>
                                </Button>
                            </div>
                        </>
                    )}
                </Form>
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
        </AppLayout>
    );
}
