import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { create, destroy, edit, index } from '@/routes/admin/recipes';
import type { BreadcrumbItem } from '@/types';
import { Pencil, Plus, Trash2 } from 'lucide-react';

type Recipe = {
    id: number;
    title: string;
    slug: string;
    sort_order: number;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Админка', href: '/dashboard' },
    { title: 'Готовим', href: index.url() },
];

export default function AdminRecipesIndex({ recipes }: { recipes: Recipe[] }) {
    function handleDelete(r: Recipe) {
        if (confirm('Удалить рецепт?')) {
            router.delete(destroy.url({ recipe: r.id }));
        }
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Готовим" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-xl font-semibold">Готовим</h1>
                    <Button asChild>
                        <Link href={create.url()}>
                            <Plus className="size-4" />
                            Добавить рецепт
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
                                    Slug
                                </th>
                                <th className="w-[80px] px-4 py-3 text-left font-medium">
                                    Порядок
                                </th>
                                <th className="w-[120px] px-4 py-3 text-right font-medium">
                                    Действия
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {recipes.length === 0 ? (
                                <tr>
                                    <td
                                        colSpan={4}
                                        className="px-4 py-8 text-center text-muted-foreground"
                                    >
                                        Нет рецептов
                                    </td>
                                </tr>
                            ) : (
                                recipes.map((r) => (
                                    <tr key={r.id} className="border-b">
                                        <td className="px-4 py-3">{r.title}</td>
                                        <td className="px-4 py-3 font-mono text-xs">
                                            {r.slug}
                                        </td>
                                        <td className="px-4 py-3">
                                            {r.sort_order}
                                        </td>
                                        <td className="px-4 py-3 text-right">
                                            <Button
                                                variant="ghost"
                                                size="icon"
                                                asChild
                                            >
                                                <Link
                                                    href={edit.url({
                                                        recipe: r.id,
                                                    })}
                                                >
                                                    <Pencil className="size-4" />
                                                </Link>
                                            </Button>
                                            <Button
                                                variant="ghost"
                                                size="icon"
                                                type="button"
                                                onClick={() => handleDelete(r)}
                                            >
                                                <Trash2 className="size-4 text-destructive" />
                                            </Button>
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
