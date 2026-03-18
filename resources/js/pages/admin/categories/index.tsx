import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import AppLayout from '@/layouts/app-layout';
import { create, edit, destroy, index, update } from '@/routes/admin/categories';
import type { BreadcrumbItem } from '@/types';
import { Pencil, Plus, Trash2 } from 'lucide-react';

type Category = {
    id: number;
    name: string;
    slug: string;
    show_in_menu: boolean;
    sort_order: number;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Админка', href: '/dashboard' },
    { title: 'Категории', href: index.url() },
];

export default function AdminCategoriesIndex({
    categories,
}: {
    categories: Category[];
}) {
    function handleToggleShowInMenu(category: Category) {
        router.put(update.url({ category: category.id }), {
            name: category.name,
            slug: category.slug,
            show_in_menu: !category.show_in_menu,
            sort_order: category.sort_order,
        });
    }

    function handleDelete(category: Category) {
        if (confirm('Удалить категорию?')) {
            router.delete(destroy.url({ category: category.id }));
        }
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Категории" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-xl font-semibold">Категории</h1>
                    <Button asChild>
                        <Link href={create.url()}>
                            <Plus className="size-4" />
                            Создать
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
                                <th className="w-[140px] px-4 py-3 text-left font-medium">
                                    В меню
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
                            {categories.length === 0 ? (
                                <tr>
                                    <td
                                        colSpan={5}
                                        className="px-4 py-8 text-center text-muted-foreground"
                                    >
                                        Нет категорий
                                    </td>
                                </tr>
                            ) : (
                                categories.map((category) => (
                                    <tr
                                        key={category.id}
                                        className="border-b last:border-0"
                                    >
                                        <td className="px-4 py-3 font-medium">
                                            {category.name}
                                        </td>
                                        <td className="px-4 py-3 text-muted-foreground">
                                            {category.slug}
                                        </td>
                                        <td className="px-4 py-3">
                                            <Checkbox
                                                checked={category.show_in_menu}
                                                onCheckedChange={() =>
                                                    handleToggleShowInMenu(
                                                        category
                                                    )
                                                }
                                            />
                                        </td>
                                        <td className="px-4 py-3">
                                            {category.sort_order}
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
                                                            category:
                                                                category.id,
                                                        })}
                                                    >
                                                        <Pencil className="size-4" />
                                                    </Link>
                                                </Button>
                                                <Button
                                                    variant="destructive"
                                                    size="icon"
                                                    onClick={() =>
                                                        handleDelete(category)
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
