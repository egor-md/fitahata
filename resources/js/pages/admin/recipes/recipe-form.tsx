import { FormEventHandler, useMemo } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/input-error';
import AppLayout from '@/layouts/app-layout';
import { ImageCropDialog } from '@/components/image-crop-dialog';
import { uploadImage } from '@/lib/upload-image';
import type { BreadcrumbItem } from '@/types';
import { ArrowLeft, Plus, Trash2, Upload } from 'lucide-react';
import { index as recipesIndex } from '@/routes/admin/recipes';
import { useState } from 'react';

type PlantOpt = { id: number; name: string; slug: string };

type Recipe = {
    id: number;
    title: string;
    slug: string;
    image_url: string;
    time_label: string | null;
    calories_label: string | null;
    difficulty_label: string | null;
    tag_top: string | null;
    tag_bottom: string | null;
    excerpt: string | null;
    body: string | null;
    ingredients: string[] | null;
    cta_label: string | null;
    cta_url: string | null;
    sort_order: number;
    plants?: PlantOpt[];
};

function plainText(value: string | null | undefined): string {
    if (!value) return '';
    return value
        .replace(/<\s*br\s*\/?>/gi, '\n')
        .replace(/<\/p>\s*<p>/gi, '\n\n')
        .replace(/<[^>]*>/g, '')
        .trim();
}

function mapRecipe(r: Recipe) {
    return {
        title: r.title,
        slug: r.slug,
        image_url: r.image_url,
        time_label: r.time_label ?? '',
        calories_label: r.calories_label ?? '',
        difficulty_label: r.difficulty_label ?? '',
        tag_top: r.tag_top ?? '',
        tag_bottom: r.tag_bottom ?? '',
        excerpt: plainText(r.excerpt),
        body: plainText(r.body),
        ingredients:
            r.ingredients && r.ingredients.length > 0 ? r.ingredients : [''],
        cta_label: r.cta_label ?? '',
        cta_url: r.cta_url ?? '',
        sort_order: r.sort_order,
        plant_ids: r.plants?.map((p) => p.id) ?? [],
    };
}

function emptyRecipe() {
    return {
        title: '',
        slug: '',
        image_url: '',
        time_label: '',
        calories_label: '',
        difficulty_label: '',
        tag_top: '',
        tag_bottom: '',
        excerpt: '',
        body: '',
        ingredients: [''],
        cta_label: '',
        cta_url: '',
        sort_order: 0,
        plant_ids: [] as number[],
    };
}

type RecipeFormState = ReturnType<typeof emptyRecipe>;

export function AdminRecipeForm({
    mode,
    recipe,
    plants,
    submitUrl,
}: {
    mode: 'create' | 'edit';
    recipe?: Recipe;
    plants: PlantOpt[];
    submitUrl: string;
}) {
    const initial = useMemo(
        () => (recipe ? mapRecipe(recipe) : emptyRecipe()),
        [recipe],
    );

    const { data, setData, post, patch, processing, errors, transform } =
        useForm<RecipeFormState>(initial);

    const [cropOpen, setCropOpen] = useState(false);
    const [cropFile, setCropFile] = useState<File | null>(null);
    const [uploading, setUploading] = useState(false);

    transform((d) => ({
        ...d,
        sort_order: Number(d.sort_order) || 0,
        ingredients: (d.ingredients || []).map((s) => s.trim()).filter(Boolean),
    }));

    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Админка', href: '/dashboard' },
        { title: 'Готовим', href: recipesIndex.url() },
        {
            title: mode === 'create' ? 'Создать' : 'Редактировать',
            href: '#',
        },
    ];

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        if (mode === 'create') {
            post(submitUrl);
        } else {
            patch(submitUrl);
        }
    };

    function handleFileChange(e: React.ChangeEvent<HTMLInputElement>) {
        const file = e.target.files?.[0];
        if (!file) return;
        e.target.value = '';
        setCropFile(file);
        setCropOpen(true);
    }

    async function handleCropConfirm(croppedFile: File) {
        setCropFile(null);
        setUploading(true);
        try {
            const url = await uploadImage(croppedFile, 'recipes');
            setData('image_url', url);
        } finally {
            setUploading(false);
        }
    }

    function addIngredient() {
        setData('ingredients', [...data.ingredients, '']);
    }

    function setIngredient(i: number, v: string) {
        setData(
            'ingredients',
            data.ingredients.map((x, idx) => (idx === i ? v : x)),
        );
    }

    function removeIngredient(i: number) {
        const next = data.ingredients.filter((_, idx) => idx !== i);
        setData('ingredients', next.length ? next : ['']);
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={mode === 'create' ? 'Новый рецепт' : data.title} />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center gap-4">
                    <Button variant="ghost" size="icon" asChild>
                        <Link href={recipesIndex.url()}>
                            <ArrowLeft className="size-4" />
                        </Link>
                    </Button>
                    <h1 className="text-xl font-semibold">
                        {mode === 'create' ? 'Новый рецепт' : 'Редактировать'}
                    </h1>
                </div>

                <form onSubmit={submit} className="max-w-xl space-y-6 pb-12">
                    <div className="space-y-2">
                        <Label htmlFor="title">Название</Label>
                        <Input
                            id="title"
                            value={data.title}
                            onChange={(e) => setData('title', e.target.value)}
                            required
                        />
                        <InputError message={errors.title} />
                    </div>
                    <div className="space-y-2">
                        <Label htmlFor="slug">Slug</Label>
                        <Input
                            id="slug"
                            value={data.slug}
                            onChange={(e) => setData('slug', e.target.value)}
                        />
                        <InputError message={errors.slug} />
                    </div>

                    <div className="space-y-2">
                        <Label>Фото рецепта</Label>
                        <div className="flex flex-wrap items-center gap-2">
                            <label className="cursor-pointer">
                                <input
                                    type="file"
                                    accept="image/*"
                                    className="hidden"
                                    disabled={uploading}
                                    onChange={handleFileChange}
                                />
                                <Button type="button" variant="outline" size="sm" asChild>
                                    <span>
                                        <Upload className="mr-1 size-3.5" />
                                        {uploading ? 'Загрузка…' : 'Загрузить'}
                                    </span>
                                </Button>
                            </label>
                        </div>
                        <ImageCropDialog
                            open={cropOpen}
                            onOpenChange={setCropOpen}
                            imageFile={cropFile}
                            onConfirm={handleCropConfirm}
                            onCancel={() => setCropFile(null)}
                        />
                        <Input
                            value={data.image_url}
                            onChange={(e) =>
                                setData('image_url', e.target.value)
                            }
                            placeholder="/images/..."
                            required
                        />
                        <InputError message={errors.image_url} />
                        {data.image_url ? (
                            <img
                                src={data.image_url}
                                alt=""
                                className="h-32 max-w-full rounded border object-cover"
                            />
                        ) : null}
                    </div>

                    <div className="grid gap-4 sm:grid-cols-3">
                        <div className="space-y-2">
                            <Label htmlFor="time_label">Время</Label>
                            <Input
                                id="time_label"
                                value={data.time_label}
                                onChange={(e) =>
                                    setData('time_label', e.target.value)
                                }
                                placeholder="25 мин"
                            />
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="calories_label">Ккал</Label>
                            <Input
                                id="calories_label"
                                value={data.calories_label}
                                onChange={(e) =>
                                    setData('calories_label', e.target.value)
                                }
                            />
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="difficulty_label">Сложность</Label>
                            <Input
                                id="difficulty_label"
                                value={data.difficulty_label}
                                onChange={(e) =>
                                    setData('difficulty_label', e.target.value)
                                }
                            />
                        </div>
                    </div>

                    <div className="grid gap-4 sm:grid-cols-2">
                        <div className="space-y-2">
                            <Label htmlFor="tag_top">Тег верх</Label>
                            <Input
                                id="tag_top"
                                value={data.tag_top}
                                onChange={(e) =>
                                    setData('tag_top', e.target.value)
                                }
                            />
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="tag_bottom">Тег низ</Label>
                            <Input
                                id="tag_bottom"
                                value={data.tag_bottom}
                                onChange={(e) =>
                                    setData('tag_bottom', e.target.value)
                                }
                            />
                        </div>
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="excerpt">Кратко</Label>
                        <textarea
                            id="excerpt"
                            value={data.excerpt}
                            onChange={(e) =>
                                setData('excerpt', e.target.value)
                            }
                            rows={2}
                            className="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm"
                        />
                    </div>
                    <div className="space-y-2">
                        <Label htmlFor="body">Текст</Label>
                        <textarea
                            id="body"
                            value={data.body}
                            onChange={(e) => setData('body', e.target.value)}
                            rows={4}
                            className="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm"
                        />
                    </div>

                    <div className="space-y-2">
                        <div className="flex items-center justify-between">
                            <Label>Ингредиенты</Label>
                            <Button
                                type="button"
                                variant="outline"
                                size="sm"
                                onClick={addIngredient}
                            >
                                <Plus className="mr-1 size-4" />
                                Строка
                            </Button>
                        </div>
                        {data.ingredients.map((line, i) => (
                            <div key={i} className="flex gap-2">
                                <Input
                                    value={line}
                                    onChange={(e) =>
                                        setIngredient(i, e.target.value)
                                    }
                                    placeholder="Продукт — количество"
                                />
                                <Button
                                    type="button"
                                    variant="ghost"
                                    size="icon"
                                    onClick={() => removeIngredient(i)}
                                >
                                    <Trash2 className="size-4" />
                                </Button>
                            </div>
                        ))}
                    </div>

                    <div className="grid gap-4 sm:grid-cols-2">
                        <div className="space-y-2">
                            <Label htmlFor="cta_label">Текст кнопки</Label>
                            <Input
                                id="cta_label"
                                value={data.cta_label}
                                onChange={(e) =>
                                    setData('cta_label', e.target.value)
                                }
                            />
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="cta_url">URL кнопки</Label>
                            <Input
                                id="cta_url"
                                value={data.cta_url}
                                onChange={(e) =>
                                    setData('cta_url', e.target.value)
                                }
                            />
                        </div>
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="sort_order">Порядок</Label>
                        <Input
                            id="sort_order"
                            type="number"
                            min={0}
                            value={data.sort_order}
                            onChange={(e) =>
                                setData(
                                    'sort_order',
                                    Number(e.target.value) || 0,
                                )
                            }
                        />
                    </div>

                    <fieldset className="space-y-2 rounded border p-4">
                        <legend className="px-1 text-sm font-medium">
                            Растения
                        </legend>
                        {plants.map((p) => (
                            <label
                                key={p.id}
                                className="flex items-center gap-2 text-sm"
                            >
                                <input
                                    type="checkbox"
                                    checked={data.plant_ids.includes(p.id)}
                                    onChange={(e) => {
                                        if (e.target.checked) {
                                            setData('plant_ids', [
                                                ...data.plant_ids,
                                                p.id,
                                            ]);
                                        } else {
                                            setData(
                                                'plant_ids',
                                                data.plant_ids.filter(
                                                    (id) => id !== p.id,
                                                ),
                                            );
                                        }
                                    }}
                                />
                                {p.name}
                            </label>
                        ))}
                    </fieldset>

                    <div className="flex gap-2">
                        <Button type="submit" disabled={processing}>
                            Сохранить
                        </Button>
                        <Button type="button" variant="outline" asChild>
                            <Link href={recipesIndex.url()}>Отмена</Link>
                        </Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
