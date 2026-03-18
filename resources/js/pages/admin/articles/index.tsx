import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { create, destroy, edit, index } from '@/routes/admin/articles';
import type { BreadcrumbItem } from '@/types';
import { Pencil, Plus, Trash2 } from 'lucide-react';

type Category = { id: number; name: string; slug: string } | null;

type Article = {
    id: number;
    title: string;
    slug: string;
    is_visible: boolean;
    category: Category;
    updated_at: string;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Админка', href: '/dashboard' },
    { title: 'Статьи', href: index.url() },
];

export default function AdminArticlesIndex({
    articles,
}: {
    articles: Article[];
}) {
    function handleToggleVisible(article: Article) {
        router.patch(
            `/admin/articles/${article.id}/visibility`
        );
    }

    function handleDelete(article: Article) {
        if (confirm('Удалить статью?')) {
            router.delete(destroy.url({ article: article.id }));
        }
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Статьи" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-xl font-semibold">Статьи</h1>
                    <Button asChild>
                        <Link href={create.url()}>
                            <Plus className="size-4" />
                            Создать статью
                        </Link>
                    </Button>
                </div>

                <div className="rounded-md border">
                    <table className="w-full text-sm">
                        <thead>
                            <tr className="border-b bg-muted/50">
                                <th className="px-4 py-3 text-left font-medium">
                                    Название
                                </th>
                                <th className="px-4 py-3 text-left font-medium">
                                    Категория
                                </th>
                                <th className="px-4 py-3 text-left font-medium">
                                    Slug
                                </th>
                                <th className="w-[120px] px-4 py-3 text-left font-medium">
                                    Отображать
                                </th>
                                <th className="w-[120px] px-4 py-3 text-right font-medium">
                                    Действия
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {articles.length === 0 ? (
                                <tr>
                                    <td
                                        colSpan={5}
                                        className="px-4 py-8 text-center text-muted-foreground"
                                    >
                                        Нет статей
                                    </td>
                                </tr>
                            ) : (
                                articles.map((article) => (
                                    <tr
                                        key={article.id}
                                        className="border-b last:border-0"
                                    >
                                        <td className="px-4 py-3 font-medium">
                                            {article.title}
                                        </td>
                                        <td className="px-4 py-3 text-muted-foreground">
                                            {article.category?.name ?? '—'}
                                        </td>
                                        <td className="px-4 py-3 text-muted-foreground">
                                            {article.slug}
                                        </td>
                                        <td className="px-4 py-3">
                                            <input
                                                type="checkbox"
                                                checked={article.is_visible}
                                                onChange={() =>
                                                    handleToggleVisible(article)
                                                }
                                                className="size-4 rounded border-input"
                                            />
                                        </td>
                                        <td className="px-4 py-3 text-right">
                                            <div className="flex justify-end gap-2">
                                                <Button
                                                    variant="outline"
                                                    size="icon"
                                                    asChild
                                                >
                                                    <Link
                                                        href={edit.url({
                                                            article: article.id,
                                                        })}
                                                    >
                                                        <Pencil className="size-4" />
                                                    </Link>
                                                </Button>
                                                <Button
                                                    variant="destructive"
                                                    size="icon"
                                                    onClick={() =>
                                                        handleDelete(article)
                                                    }
                                                >
                                                    <Trash2 className="size-4" />
                                                </Button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AppLayout>
    );
}
