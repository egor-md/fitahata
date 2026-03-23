import { FormEventHandler, useMemo } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/input-error';
import AppLayout from '@/layouts/app-layout';
import {
    PlantImagesField,
    type PlantImageRow,
} from '@/components/plant-images-field';
import type { BreadcrumbItem } from '@/types';
import { ArrowLeft, Plus, Trash2 } from 'lucide-react';
import { index as plantsIndex } from '@/routes/admin/plants';

type Tag = { id: number; name: string; slug: string; group?: string | null };
type KindOpt = { value: string; label: string };

type NutritionRow = {
    section: string;
    label: string;
    meta: string;
    value: string;
    bar_percent: number;
    bar_variant: string;
    sort_order: number;
};

type FactRow = { icon: string; title: string; sub: string };

type Plant = {
    id: number;
    name: string;
    subtitle: string | null;
    slug: string;
    kind: string;
    is_visible: boolean;
    description: string | null;
    dishes_text: string | null;
    price: string | number;
    price_unit_label: string | null;
    compare_at_price: string | number | null;
    discount_label: string | null;
    growing_period_label: string | null;
    category_label: string | null;
    sku: string | null;
    is_bestseller: boolean;
    rating: string | number | null;
    reviews_count: number | null;
    facts: FactRow[] | null;
    nutrition_section_title: string | null;
    nutrition_section_lead: string | null;
    nutrition_tip_text: string | null;
    recipes_section_pill: string | null;
    recipes_section_title: string | null;
    recipes_section_lead: string | null;
    meta_title: string | null;
    meta_description: string | null;
    images?: Array<{
        id?: number;
        url: string;
        sort_order: number;
        is_primary: boolean;
    }>;
    tags?: Tag[];
    nutrition_items?: NutritionRow[];
};

const NUTRITION_SECTIONS = [
    { value: 'energy', label: 'Энергетическая ценность' },
    { value: 'protein', label: 'Белки и аминокислоты' },
    { value: 'vitamins', label: 'Витамины' },
    { value: 'minerals', label: 'Минералы' },
    { value: 'antioxidants', label: 'Антиоксиданты' },
];

function emptyFacts(): FactRow[] {
    return [
        { icon: '', title: '', sub: '' },
        { icon: '', title: '', sub: '' },
        { icon: '', title: '', sub: '' },
    ];
}

function mapPlantToForm(p: Plant) {
    const images: PlantImageRow[] =
        p.images && p.images.length > 0
            ? p.images.map((img, i) => ({
                  url: img.url,
                  sort_order: img.sort_order ?? i,
                  is_primary: Boolean(img.is_primary),
              }))
            : [{ url: '', sort_order: 0, is_primary: true }];

    const facts = p.facts?.length ? p.facts : emptyFacts();
    const nutrition =
        p.nutrition_items?.map((n, i) => ({
            section: n.section,
            label: n.label,
            meta: n.meta ?? '',
            value: n.value,
            bar_percent: Number(n.bar_percent ?? 0),
            bar_variant: n.bar_variant ?? '',
            sort_order: n.sort_order ?? i,
        })) ?? [];

    return {
        name: p.name,
        subtitle: p.subtitle ?? '',
        slug: p.slug,
        kind: p.kind,
        is_visible: p.is_visible,
        description: p.description ?? '',
        dishes_text: p.dishes_text ?? '',
        price: String(p.price),
        price_unit_label: p.price_unit_label ?? 'за 50 г',
        compare_at_price:
            p.compare_at_price !== null && p.compare_at_price !== undefined
                ? String(p.compare_at_price)
                : '',
        discount_label: p.discount_label ?? '',
        growing_period_label: p.growing_period_label ?? '',
        category_label: p.category_label ?? '',
        sku: p.sku ?? '',
        is_bestseller: p.is_bestseller,
        rating: p.rating !== null && p.rating !== undefined ? String(p.rating) : '',
        reviews_count: p.reviews_count ?? 0,
        facts,
        nutrition_section_title: p.nutrition_section_title ?? '',
        nutrition_section_lead: p.nutrition_section_lead ?? '',
        nutrition_tip_text: p.nutrition_tip_text ?? '',
        recipes_section_pill: p.recipes_section_pill ?? '',
        recipes_section_title: p.recipes_section_title ?? '',
        recipes_section_lead: p.recipes_section_lead ?? '',
        meta_title: p.meta_title ?? '',
        meta_description: p.meta_description ?? '',
        images,
        tag_ids: p.tags?.map((t) => t.id) ?? [],
        nutrition_items: nutrition,
    };
}

function defaultForm() {
    return {
        name: '',
        subtitle: '',
        slug: '',
        kind: 'microgreen',
        is_visible: true,
        description: '',
        dishes_text: '',
        price: '',
        price_unit_label: 'за 50 г',
        compare_at_price: '',
        discount_label: '',
        growing_period_label: '',
        category_label: '',
        sku: '',
        is_bestseller: false,
        rating: '',
        reviews_count: 0,
        facts: emptyFacts(),
        nutrition_section_title: '',
        nutrition_section_lead: '',
        nutrition_tip_text: '',
        recipes_section_pill: '',
        recipes_section_title: '',
        recipes_section_lead: '',
        meta_title: '',
        meta_description: '',
        images: [{ url: '', sort_order: 0, is_primary: true }] as PlantImageRow[],
        tag_ids: [] as number[],
        nutrition_items: [] as NutritionRow[],
    };
}

type PlantFormState = ReturnType<typeof defaultForm>;

export function AdminPlantForm({
    mode,
    plant,
    tags,
    plant_kinds,
    submitUrl,
}: {
    mode: 'create' | 'edit';
    plant?: Plant;
    tags: Tag[];
    plant_kinds: KindOpt[];
    submitUrl: string;
}) {
    const initial = useMemo(
        () => (plant ? mapPlantToForm(plant) : defaultForm()),
        [plant],
    );

    const { data, setData, post, patch, processing, errors, transform } =
        useForm<PlantFormState>(initial);

    transform((d) => {
        const facts = (d.facts || []).filter(
            (f) => f.icon.trim() || f.title.trim() || f.sub.trim(),
        );
        const nutrition = (d.nutrition_items || []).map((n, i) => ({
            ...n,
            sort_order: i,
            bar_percent: Number(n.bar_percent) || 0,
        }));
        return {
            ...d,
            price: Number(String(d.price).replace(',', '.')),
            compare_at_price: d.compare_at_price
                ? Number(String(d.compare_at_price).replace(',', '.'))
                : null,
            rating: d.rating
                ? Number(String(d.rating).replace(',', '.'))
                : null,
            reviews_count: Number(d.reviews_count) || 0,
            facts,
            nutrition_items: nutrition,
        };
    });

    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Админка', href: '/dashboard' },
        { title: 'Растения', href: plantsIndex.url() },
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

    function addNutritionRow() {
        setData('nutrition_items', [
            ...data.nutrition_items,
            {
                section: 'energy',
                label: '',
                meta: '',
                value: '',
                bar_percent: 0,
                bar_variant: '',
                sort_order: data.nutrition_items.length,
            },
        ]);
    }

    function removeNutritionRow(i: number) {
        setData(
            'nutrition_items',
            data.nutrition_items.filter((_, idx) => idx !== i),
        );
    }

    function updateNutritionRow(i: number, patchRow: Partial<NutritionRow>) {
        setData(
            'nutrition_items',
            data.nutrition_items.map((row, idx) =>
                idx === i ? { ...row, ...patchRow } : row,
            ),
        );
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={mode === 'create' ? 'Новое растение' : data.name} />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center gap-4">
                    <Button variant="ghost" size="icon" asChild>
                        <Link href={plantsIndex.url()}>
                            <ArrowLeft className="size-4" />
                        </Link>
                    </Button>
                    <h1 className="text-xl font-semibold">
                        {mode === 'create' ? 'Новое растение' : 'Редактировать'}
                    </h1>
                </div>

                <form onSubmit={submit} className="max-w-3xl space-y-8 pb-12">
                    <fieldset className="space-y-4 rounded border p-4">
                        <legend className="px-1 text-sm font-medium">
                            Основное
                        </legend>
                        <div className="grid gap-4 sm:grid-cols-2">
                            <div className="space-y-2">
                                <Label htmlFor="name">Название</Label>
                                <Input
                                    id="name"
                                    value={data.name}
                                    onChange={(e) =>
                                        setData('name', e.target.value)
                                    }
                                    required
                                />
                                <InputError message={errors.name} />
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="subtitle">Подзаголовок</Label>
                                <Input
                                    id="subtitle"
                                    value={data.subtitle}
                                    onChange={(e) =>
                                        setData('subtitle', e.target.value)
                                    }
                                    placeholder="микрозелень"
                                />
                                <InputError message={errors.subtitle} />
                            </div>
                        </div>
                        <div className="grid gap-4 sm:grid-cols-2">
                            <div className="space-y-2">
                                <Label htmlFor="slug">Slug</Label>
                                <Input
                                    id="slug"
                                    value={data.slug}
                                    onChange={(e) =>
                                        setData('slug', e.target.value)
                                    }
                                />
                                <InputError message={errors.slug} />
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="kind">Тип</Label>
                                <select
                                    id="kind"
                                    value={data.kind}
                                    onChange={(e) =>
                                        setData('kind', e.target.value)
                                    }
                                    className="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm"
                                >
                                    {plant_kinds.map((k) => (
                                        <option key={k.value} value={k.value}>
                                            {k.label}
                                        </option>
                                    ))}
                                </select>
                                <InputError message={errors.kind} />
                            </div>
                        </div>
                        <label className="flex items-center gap-2 text-sm">
                            <input
                                type="checkbox"
                                checked={data.is_visible}
                                onChange={(e) =>
                                    setData('is_visible', e.target.checked)
                                }
                            />
                            Показывать на сайте
                        </label>
                        <div className="space-y-2">
                            <Label htmlFor="description">Описание (HTML)</Label>
                            <textarea
                                id="description"
                                value={data.description}
                                onChange={(e) =>
                                    setData('description', e.target.value)
                                }
                                rows={4}
                                className="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm"
                            />
                            <InputError message={errors.description} />
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="dishes_text">Текст «для блюд»</Label>
                            <textarea
                                id="dishes_text"
                                value={data.dishes_text}
                                onChange={(e) =>
                                    setData('dishes_text', e.target.value)
                                }
                                rows={3}
                                className="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm"
                            />
                            <InputError message={errors.dishes_text} />
                        </div>
                    </fieldset>

                    <fieldset className="space-y-4 rounded border p-4">
                        <legend className="px-1 text-sm font-medium">
                            Цена и витрина
                        </legend>
                        <div className="grid gap-4 sm:grid-cols-2">
                            <div className="space-y-2">
                                <Label htmlFor="price">Цена</Label>
                                <Input
                                    id="price"
                                    type="text"
                                    inputMode="decimal"
                                    value={data.price}
                                    onChange={(e) =>
                                        setData('price', e.target.value)
                                    }
                                    required
                                />
                                <InputError message={errors.price} />
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="price_unit_label">
                                    Подпись цены
                                </Label>
                                <Input
                                    id="price_unit_label"
                                    value={data.price_unit_label}
                                    onChange={(e) =>
                                        setData(
                                            'price_unit_label',
                                            e.target.value,
                                        )
                                    }
                                />
                            </div>
                        </div>
                        <div className="grid gap-4 sm:grid-cols-2">
                            <div className="space-y-2">
                                <Label htmlFor="compare_at_price">
                                    Старая цена
                                </Label>
                                <Input
                                    id="compare_at_price"
                                    type="text"
                                    inputMode="decimal"
                                    value={data.compare_at_price}
                                    onChange={(e) =>
                                        setData(
                                            'compare_at_price',
                                            e.target.value,
                                        )
                                    }
                                />
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="discount_label">
                                    Плашка скидки
                                </Label>
                                <Input
                                    id="discount_label"
                                    value={data.discount_label}
                                    onChange={(e) =>
                                        setData(
                                            'discount_label',
                                            e.target.value,
                                        )
                                    }
                                />
                            </div>
                        </div>
                        <div className="grid gap-4 sm:grid-cols-2">
                            <div className="space-y-2">
                                <Label htmlFor="category_label">Категория</Label>
                                <Input
                                    id="category_label"
                                    value={data.category_label}
                                    onChange={(e) =>
                                        setData(
                                            'category_label',
                                            e.target.value,
                                        )
                                    }
                                />
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="sku">Артикул</Label>
                                <Input
                                    id="sku"
                                    value={data.sku}
                                    onChange={(e) =>
                                        setData('sku', e.target.value)
                                    }
                                />
                            </div>
                        </div>
                        <div className="grid gap-4 sm:grid-cols-3">
                            <label className="flex items-center gap-2 text-sm">
                                <input
                                    type="checkbox"
                                    checked={data.is_bestseller}
                                    onChange={(e) =>
                                        setData(
                                            'is_bestseller',
                                            e.target.checked,
                                        )
                                    }
                                />
                                Хит продаж
                            </label>
                            <div className="space-y-2">
                                <Label htmlFor="rating">Рейтинг</Label>
                                <Input
                                    id="rating"
                                    type="text"
                                    inputMode="decimal"
                                    value={data.rating}
                                    onChange={(e) =>
                                        setData('rating', e.target.value)
                                    }
                                />
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="reviews_count">Отзывов</Label>
                                <Input
                                    id="reviews_count"
                                    type="number"
                                    min={0}
                                    value={data.reviews_count}
                                    onChange={(e) =>
                                        setData(
                                            'reviews_count',
                                            Number(e.target.value),
                                        )
                                    }
                                />
                            </div>
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="growing_period_label">
                                Срок выращивания
                            </Label>
                            <Input
                                id="growing_period_label"
                                value={data.growing_period_label}
                                onChange={(e) =>
                                    setData(
                                        'growing_period_label',
                                        e.target.value,
                                    )
                                }
                            />
                        </div>
                    </fieldset>

                    <fieldset className="space-y-4 rounded border p-4">
                        <legend className="px-1 text-sm font-medium">
                            Факты (3 блока)
                        </legend>
                        {data.facts.map((fact, i) => (
                            <div
                                key={i}
                                className="grid gap-2 rounded bg-muted/30 p-3 sm:grid-cols-3"
                            >
                                <Input
                                    placeholder="Иконка Remix (ri-...)"
                                    value={fact.icon}
                                    onChange={(e) => {
                                        const next = [...data.facts];
                                        next[i] = {
                                            ...next[i],
                                            icon: e.target.value,
                                        };
                                        setData('facts', next);
                                    }}
                                />
                                <Input
                                    placeholder="Заголовок"
                                    value={fact.title}
                                    onChange={(e) => {
                                        const next = [...data.facts];
                                        next[i] = {
                                            ...next[i],
                                            title: e.target.value,
                                        };
                                        setData('facts', next);
                                    }}
                                />
                                <Input
                                    placeholder="Подпись"
                                    value={fact.sub}
                                    onChange={(e) => {
                                        const next = [...data.facts];
                                        next[i] = {
                                            ...next[i],
                                            sub: e.target.value,
                                        };
                                        setData('facts', next);
                                    }}
                                />
                            </div>
                        ))}
                    </fieldset>

                    <fieldset className="space-y-4 rounded border p-4">
                        <legend className="px-1 text-sm font-medium">
                            Питательность (шапка)
                        </legend>
                        <div className="space-y-2">
                            <Label htmlFor="nutrition_section_title">
                                Заголовок секции
                            </Label>
                            <Input
                                id="nutrition_section_title"
                                value={data.nutrition_section_title}
                                onChange={(e) =>
                                    setData(
                                        'nutrition_section_title',
                                        e.target.value,
                                    )
                                }
                            />
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="nutrition_section_lead">Лид</Label>
                            <textarea
                                id="nutrition_section_lead"
                                value={data.nutrition_section_lead}
                                onChange={(e) =>
                                    setData(
                                        'nutrition_section_lead',
                                        e.target.value,
                                    )
                                }
                                rows={2}
                                className="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm"
                            />
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="nutrition_tip_text">
                                Блок «Знаете ли вы?»
                            </Label>
                            <textarea
                                id="nutrition_tip_text"
                                value={data.nutrition_tip_text}
                                onChange={(e) =>
                                    setData(
                                        'nutrition_tip_text',
                                        e.target.value,
                                    )
                                }
                                rows={2}
                                className="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm"
                            />
                        </div>
                    </fieldset>

                    <fieldset className="space-y-4 rounded border p-4">
                        <legend className="px-1 text-sm font-medium">
                            Рецепты (заголовок блока)
                        </legend>
                        <Input
                            placeholder="Плашка"
                            value={data.recipes_section_pill}
                            onChange={(e) =>
                                setData('recipes_section_pill', e.target.value)
                            }
                        />
                        <Input
                            placeholder="Заголовок"
                            value={data.recipes_section_title}
                            onChange={(e) =>
                                setData('recipes_section_title', e.target.value)
                            }
                        />
                        <textarea
                            placeholder="Текст под заголовком"
                            value={data.recipes_section_lead}
                            onChange={(e) =>
                                setData('recipes_section_lead', e.target.value)
                            }
                            rows={2}
                            className="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm"
                        />
                    </fieldset>

                    <fieldset className="space-y-4 rounded border p-4">
                        <legend className="px-1 text-sm font-medium">SEO</legend>
                        <div className="space-y-2">
                            <Label htmlFor="meta_title">Meta title</Label>
                            <Input
                                id="meta_title"
                                value={data.meta_title}
                                onChange={(e) =>
                                    setData('meta_title', e.target.value)
                                }
                            />
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="meta_description">
                                Meta description
                            </Label>
                            <textarea
                                id="meta_description"
                                value={data.meta_description}
                                onChange={(e) =>
                                    setData(
                                        'meta_description',
                                        e.target.value,
                                    )
                                }
                                rows={2}
                                className="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm"
                            />
                        </div>
                    </fieldset>

                    <PlantImagesField
                        images={data.images}
                        onChange={(images) => setData('images', images)}
                    />
                    <InputError message={errors.images} />

                    <fieldset className="space-y-3 rounded border p-4">
                        <legend className="px-1 text-sm font-medium">Теги</legend>
                        <div className="flex flex-col gap-2">
                            {tags.map((t) => (
                                <label
                                    key={t.id}
                                    className="flex items-center gap-2 text-sm"
                                >
                                    <input
                                        type="checkbox"
                                        checked={data.tag_ids.includes(t.id)}
                                        onChange={(e) => {
                                            if (e.target.checked) {
                                                setData('tag_ids', [
                                                    ...data.tag_ids,
                                                    t.id,
                                                ]);
                                            } else {
                                                setData(
                                                    'tag_ids',
                                                    data.tag_ids.filter(
                                                        (id) => id !== t.id,
                                                    ),
                                                );
                                            }
                                        }}
                                    />
                                    {t.name}
                                    {t.group ? (
                                        <span className="text-xs text-muted-foreground">
                                            ({t.group})
                                        </span>
                                    ) : null}
                                </label>
                            ))}
                        </div>
                    </fieldset>

                    <fieldset className="space-y-3 rounded border p-4">
                        <div className="flex items-center justify-between">
                            <legend className="px-1 text-sm font-medium">
                                Строки питательности
                            </legend>
                            <Button
                                type="button"
                                variant="outline"
                                size="sm"
                                onClick={addNutritionRow}
                            >
                                <Plus className="mr-1 size-4" />
                                Строка
                            </Button>
                        </div>
                        {data.nutrition_items.length === 0 ? (
                            <p className="text-sm text-muted-foreground">
                                Нет строк — добавьте или оставьте пустым.
                            </p>
                        ) : (
                            <div className="space-y-4">
                                {data.nutrition_items.map((row, i) => (
                                    <div
                                        key={i}
                                        className="space-y-2 rounded border p-3"
                                    >
                                        <div className="flex justify-end">
                                            <Button
                                                type="button"
                                                variant="ghost"
                                                size="icon"
                                                onClick={() =>
                                                    removeNutritionRow(i)
                                                }
                                            >
                                                <Trash2 className="size-4" />
                                            </Button>
                                        </div>
                                        <select
                                            value={row.section}
                                            onChange={(e) =>
                                                updateNutritionRow(i, {
                                                    section: e.target.value,
                                                })
                                            }
                                            className="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm"
                                        >
                                            {NUTRITION_SECTIONS.map((s) => (
                                                <option
                                                    key={s.value}
                                                    value={s.value}
                                                >
                                                    {s.label}
                                                </option>
                                            ))}
                                        </select>
                                        <Input
                                            placeholder="Название"
                                            value={row.label}
                                            onChange={(e) =>
                                                updateNutritionRow(i, {
                                                    label: e.target.value,
                                                })
                                            }
                                        />
                                        <Input
                                            placeholder="Мета (справа)"
                                            value={row.meta}
                                            onChange={(e) =>
                                                updateNutritionRow(i, {
                                                    meta: e.target.value,
                                                })
                                            }
                                        />
                                        <Input
                                            placeholder="Значение"
                                            value={row.value}
                                            onChange={(e) =>
                                                updateNutritionRow(i, {
                                                    value: e.target.value,
                                                })
                                            }
                                        />
                                        <div className="grid grid-cols-2 gap-2">
                                            <Input
                                                type="number"
                                                min={0}
                                                max={100}
                                                placeholder="% полосы"
                                                value={row.bar_percent}
                                                onChange={(e) =>
                                                    updateNutritionRow(i, {
                                                        bar_percent: Number(
                                                            e.target.value,
                                                        ),
                                                    })
                                                }
                                            />
                                            <Input
                                                placeholder="вариант CSS"
                                                value={row.bar_variant}
                                                onChange={(e) =>
                                                    updateNutritionRow(i, {
                                                        bar_variant:
                                                            e.target.value,
                                                    })
                                                }
                                            />
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </fieldset>

                    <div className="flex gap-2">
                        <Button type="submit" disabled={processing}>
                            Сохранить
                        </Button>
                        <Button type="button" variant="outline" asChild>
                            <Link href={plantsIndex.url()}>Отмена</Link>
                        </Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
