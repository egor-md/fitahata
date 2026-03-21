import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { FeatureBlockEditor } from '@/components/feature-block-editor';
import { GalleryBlockEditor } from '@/components/gallery-block-editor';
import { ImageBlockEditor } from '@/components/image-block-editor';
import InputError from '@/components/input-error';
import AppLayout from '@/layouts/app-layout';
import { index, update } from '@/routes/admin/articles';
import type { BreadcrumbItem } from '@/types';
import { uploadImage } from '@/lib/upload-image';
import { ArrowLeft, GripVertical, Trash2 } from 'lucide-react';

type Category = { id: number; name: string; slug: string };
type ArticleBlock = {
    id?: number;
    type: string;
    content: Record<string, unknown> | null;
};
type Article = {
    id: number;
    title: string;
    slug: string;
    is_visible: boolean;
    is_main_for_category: boolean;
    category_id: number | null;
    article_blocks: ArticleBlock[];
};

type BlockItem = {
    type: 'heading' | 'text' | 'image' | 'gallery' | 'carousel' | 'feature' | 'main_info';
    content: Record<string, unknown>;
};

const BLOCK_LABELS: Record<BlockItem['type'], string> = {
    heading: 'Заголовок',
    text: 'Текст',
    image: 'Картинка',
    gallery: 'Галерея',
    carousel: 'Карусель',
    feature: 'Сложный блок 50/50',
    main_info: 'Main info',
};

const defaultContent: Record<BlockItem['type'], Record<string, unknown>> = {
    heading: { level: 1, text: '' },
    text: { body: '' },
    image: { url: '', alt: '', caption: '' },
    gallery: { columns: 2, images: [] as Array<{ url: string; alt?: string; caption?: string }> },
    carousel: { blockId: null as number | null },
    feature: {
        imageUrl: '',
        imageAlt: '',
        title: '',
        price: '',
        text: '',
        layout: { imageWidth: '1/2', order: 'image-first' },
    },
    main_info: {
        imageUrl: '',
        imageAlt: '',
        productName: '',
        price: '',
        benefit: '',
        taste: '',
        description: '',
        badge: '',
    },
};

export default function AdminArticlesEdit({
    article,
    categories,
    blocks,
    errors = {},
}: {
    article: Article;
    categories: Category[];
    blocks: { id: number; name: string; type: string }[];
    errors?: Record<string, string>;
}) {
    const initialBlocks: BlockItem[] = (article.article_blocks ?? []).map(
        (b) => ({
            type: b.type as BlockItem['type'],
            content: (b.content ?? defaultContent[b.type as BlockItem['type']] ?? {}) as Record<string, unknown>,
        })
    );

    const [title, setTitle] = useState(article.title);
    const [slug, setSlug] = useState(article.slug);
    const [categoryId, setCategoryId] = useState<string>(
        article.category_id != null ? String(article.category_id) : ''
    );
    const [isVisible, setIsVisible] = useState(article.is_visible);
    const [isMainForCategory, setIsMainForCategory] = useState(
        article.is_main_for_category ?? false
    );
    const [articleBlocks, setArticleBlocks] = useState<BlockItem[]>(initialBlocks);
    const [showAddBlockChoice, setShowAddBlockChoice] = useState(false);

    function addBlock(type: BlockItem['type']) {
        setArticleBlocks((prev) => [
            ...prev,
            { type, content: { ...defaultContent[type] } },
        ]);
        setShowAddBlockChoice(false);
    }

    function removeBlock(i: number) {
        setArticleBlocks((prev) => prev.filter((_, idx) => idx !== i));
    }

    function updateBlockContent(i: number, content: Record<string, unknown>) {
        setArticleBlocks((prev) => {
            const next = [...prev];
            next[i] = { ...next[i], content };
            return next;
        });
    }

    function handleSubmit(e: React.FormEvent) {
        e.preventDefault();
        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('title', title);
        formData.append('slug', slug);
        formData.append('category_id', categoryId ? String(categoryId) : '');
        formData.append('is_visible', isVisible ? '1' : '0');
        formData.append('is_main_for_category', isMainForCategory && categoryId ? '1' : '0');
        articleBlocks.forEach((b, idx) => {
            formData.append(`blocks[${idx}][type]`, b.type);
            formData.append(
                `blocks[${idx}][content]`,
                JSON.stringify(b.content ?? {})
            );
        });
        router.post(update.url({ article: article.id }), formData, {
            forceFormData: true,
        });
    }

    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Админка', href: '/dashboard' },
        { title: 'Статьи', href: index.url() },
        { title: article.title, href: update.url({ article: article.id }) },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Редактировать: ${article.title}`} />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center gap-4">
                    <Button variant="ghost" size="icon" asChild>
                        <Link href={index.url()}>
                            <ArrowLeft className="size-4" />
                        </Link>
                    </Button>
                    <h1 className="text-xl font-semibold">
                        Редактировать статью
                    </h1>
                </div>

                <form onSubmit={handleSubmit} className="max-w-2xl space-y-6">
                    <div className="space-y-2">
                        <Label htmlFor="title">Название</Label>
                        <Input
                            id="title"
                            value={title}
                            onChange={(e) => setTitle(e.target.value)}
                            name="title"
                            required
                            autoFocus
                            placeholder="Название статьи"
                        />
                        <InputError message={errors.title} />
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="slug">Slug (необязательно)</Label>
                        <Input
                            id="slug"
                            value={slug}
                            onChange={(e) => setSlug(e.target.value)}
                            name="slug"
                            placeholder="url-slug"
                        />
                        <InputError message={errors.slug} />
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="category_id">Категория</Label>
                        <select
                            id="category_id"
                            name="category_id"
                            value={categoryId}
                            onChange={(e) => {
                                const v = e.target.value;
                                setCategoryId(v);
                                if (!v) setIsMainForCategory(false);
                            }}
                            className="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs"
                        >
                            <option value="">— Без категории —</option>
                            {categories.map((c) => (
                                <option key={c.id} value={c.id}>
                                    {c.name}
                                </option>
                            ))}
                        </select>
                        <InputError message={errors.category_id} />
                    </div>

                    <div className="flex items-center space-x-2">
                        <input
                            type="checkbox"
                            id="is_visible"
                            checked={isVisible}
                            onChange={(e) => setIsVisible(e.target.checked)}
                            className="size-4 rounded border-input"
                        />
                        <Label htmlFor="is_visible">Отображать на сайте</Label>
                    </div>

                    {categoryId ? (
                        <div className="flex items-center space-x-2">
                            <input
                                type="checkbox"
                                id="is_main_for_category"
                                checked={isMainForCategory}
                                onChange={(e) => setIsMainForCategory(e.target.checked)}
                                className="size-4 rounded border-input"
                            />
                            <Label htmlFor="is_main_for_category">
                                Главная статья пункта меню
                            </Label>
                        </div>
                    ) : null}

                    <div className="space-y-2">
                        <Label>Блоки статьи</Label>
                        <div className="space-y-3">
                            {articleBlocks.map((block, i) => (
                                <BlockEditor
                                    key={i}
                                    block={block}
                                    blocks={blocks}
                                    onContentChange={(content) =>
                                        updateBlockContent(i, content)
                                    }
                                    onRemove={() => removeBlock(i)}
                                />
                            ))}
                            {!showAddBlockChoice ? (
                                <Button
                                    type="button"
                                    variant="outline"
                                    onClick={() => setShowAddBlockChoice(true)}
                                >
                                    Добавить блок
                                </Button>
                            ) : (
                                <div className="space-y-2 rounded border border-dashed p-3">
                                    <p className="text-sm text-muted-foreground">
                                        Выберите тип блока:
                                    </p>
                                    <div className="flex flex-wrap gap-2">
                                        {(
                                            [
                                                'main_info',
                                                'heading',
                                                'text',
                                                'image',
                                                'gallery',
                                                'carousel',
                                                'feature',
                                            ] as const
                                        ).map((t) => (
                                            <Button
                                                key={t}
                                                type="button"
                                                variant="secondary"
                                                size="sm"
                                                onClick={() => addBlock(t)}
                                            >
                                                {BLOCK_LABELS[t]}
                                            </Button>
                                        ))}
                                    </div>
                                    <Button
                                        type="button"
                                        variant="ghost"
                                        size="sm"
                                        onClick={() =>
                                            setShowAddBlockChoice(false)
                                        }
                                    >
                                        Отмена
                                    </Button>
                                </div>
                            )}
                        </div>
                    </div>

                    <div className="flex gap-2">
                        <Button type="submit">Сохранить</Button>
                        <Button type="button" variant="outline" asChild>
                            <Link href={index.url()}>Отмена</Link>
                        </Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}

function BlockEditor({
    block,
    blocks,
    onContentChange,
    onRemove,
}: {
    block: BlockItem;
    blocks: { id: number; name: string; type: string }[];
    onContentChange: (content: Record<string, unknown>) => void;
    onRemove: () => void;
}) {
    const content = block.content as Record<string, unknown>;
    const [uploadingMainInfo, setUploadingMainInfo] = useState(false);

    if (block.type === 'heading') {
        return (
            <div className="flex gap-2 rounded border p-3">
                <GripVertical className="mt-2 size-4 shrink-0 text-muted-foreground" />
                <div className="min-w-0 flex-1 space-y-2">
                    <span className="text-xs font-medium text-muted-foreground">
                        Заголовок
                    </span>
                    <select
                        value={Number(content.level) || 1}
                        onChange={(e) =>
                            onContentChange({
                                ...content,
                                level: Number(e.target.value),
                                text: content.text,
                            })
                        }
                        className="mr-2 rounded border px-2 py-1 text-sm"
                    >
                        {[1, 2, 3].map((n) => (
                            <option key={n} value={n}>
                                H{n}
                            </option>
                        ))}
                    </select>
                    <Input
                        value={String(content.text ?? '')}
                        onChange={(e) =>
                            onContentChange({
                                ...content,
                                level: content.level,
                                text: e.target.value,
                            })
                        }
                        placeholder="Текст заголовка"
                    />
                </div>
                <Button
                    type="button"
                    variant="ghost"
                    size="icon"
                    onClick={onRemove}
                >
                    <Trash2 className="size-4" />
                </Button>
            </div>
        );
    }

    if (block.type === 'text') {
        return (
            <div className="flex gap-2 rounded border p-3">
                <GripVertical className="mt-2 size-4 shrink-0 text-muted-foreground" />
                <div className="min-w-0 flex-1 space-y-2">
                    <span className="text-xs font-medium text-muted-foreground">
                        Текст
                    </span>
                    <textarea
                        value={String(content.body ?? '')}
                        onChange={(e) =>
                            onContentChange({ ...content, body: e.target.value })
                        }
                        placeholder="Текст"
                        rows={3}
                        className="flex w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm"
                    />
                </div>
                <Button
                    type="button"
                    variant="ghost"
                    size="icon"
                    onClick={onRemove}
                >
                    <Trash2 className="size-4" />
                </Button>
            </div>
        );
    }

    if (block.type === 'main_info') {
        return (
            <div className="flex gap-2 rounded border p-3">
                <GripVertical className="mt-2 size-4 shrink-0 text-muted-foreground" />
                <div className="min-w-0 flex-1 space-y-2">
                    <span className="text-xs font-medium text-muted-foreground">Main info</span>
                    <div className="flex items-center gap-2">
                        <label className="cursor-pointer">
                            <input
                                type="file"
                                accept="image/*"
                                className="hidden"
                                disabled={uploadingMainInfo}
                                onChange={async (e) => {
                                    const file = e.target.files?.[0];
                                    e.target.value = '';
                                    if (!file) return;
                                    setUploadingMainInfo(true);
                                    try {
                                        const url = await uploadImage(file);
                                        onContentChange({ ...content, imageUrl: url });
                                    } finally {
                                        setUploadingMainInfo(false);
                                    }
                                }}
                            />
                            <Button type="button" variant="outline" size="sm" asChild>
                                <span>{uploadingMainInfo ? 'Загрузка…' : 'Upload photo'}</span>
                            </Button>
                        </label>
                    </div>
                    <Input
                        value={String(content.imageUrl ?? '')}
                        onChange={(e) => onContentChange({ ...content, imageUrl: e.target.value })}
                        placeholder="URL изображения"
                    />
                    <Input
                        value={String(content.imageAlt ?? '')}
                        onChange={(e) => onContentChange({ ...content, imageAlt: e.target.value })}
                        placeholder="Alt изображения"
                    />
                    <Input
                        value={String(content.productName ?? '')}
                        onChange={(e) => onContentChange({ ...content, productName: e.target.value })}
                        placeholder="Название продукта"
                    />
                    <Input
                        value={String(content.price ?? '')}
                        onChange={(e) => onContentChange({ ...content, price: e.target.value })}
                        placeholder="Цена (например: от 5,50 BYN)"
                    />
                    <Input
                        value={String(content.benefit ?? '')}
                        onChange={(e) => onContentChange({ ...content, benefit: e.target.value })}
                        placeholder="Польза"
                    />
                    <Input
                        value={String(content.taste ?? '')}
                        onChange={(e) => onContentChange({ ...content, taste: e.target.value })}
                        placeholder="Вкус"
                    />
                    <textarea
                        value={String(content.description ?? '')}
                        onChange={(e) => onContentChange({ ...content, description: e.target.value })}
                        placeholder="Описание"
                        rows={3}
                        className="flex w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm"
                    />
                    <Input
                        value={String(content.badge ?? '')}
                        onChange={(e) => onContentChange({ ...content, badge: e.target.value })}
                        placeholder="Бейдж (необязательно)"
                    />
                </div>
                <Button type="button" variant="ghost" size="icon" onClick={onRemove}>
                    <Trash2 className="size-4" />
                </Button>
            </div>
        );
    }

    if (block.type === 'image') {
        return (
            <ImageBlockEditor
                content={content}
                onChange={onContentChange}
                onRemove={onRemove}
            />
        );
    }

    if (block.type === 'feature') {
        return (
            <FeatureBlockEditor
                content={content}
                onChange={onContentChange}
                onRemove={onRemove}
            />
        );
    }

    if (block.type === 'gallery') {
        return (
            <GalleryBlockEditor
                content={content}
                onChange={onContentChange}
                onRemove={onRemove}
            />
        );
    }

    if (block.type === 'carousel') {
        const blockId = content.blockId as number | null;
        const filteredBlocks = blocks.filter((b) => b.type === 'carousel');
        return (
            <div className="flex gap-2 rounded border p-3">
                <GripVertical className="mt-2 size-4 shrink-0 text-muted-foreground" />
                <div className="min-w-0 flex-1 space-y-2">
                    <span className="text-xs font-medium text-muted-foreground">
                        Карусель
                    </span>
                    <select
                        value={blockId ?? ''}
                        onChange={(e) =>
                            onContentChange({
                                blockId: e.target.value
                                    ? Number(e.target.value)
                                    : null,
                            })
                        }
                        className="flex w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm"
                    >
                        <option value="">— Выберите блок —</option>
                        {filteredBlocks.map((b) => (
                            <option key={b.id} value={b.id}>
                                {b.name}
                            </option>
                        ))}
                    </select>
                </div>
                <Button
                    type="button"
                    variant="ghost"
                    size="icon"
                    onClick={onRemove}
                >
                    <Trash2 className="size-4" />
                </Button>
            </div>
        );
    }

    return null;
}
