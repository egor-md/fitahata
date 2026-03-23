import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { create, destroy, edit, index } from '@/routes/admin/plants';
import type { BreadcrumbItem } from '@/types';
import { Pencil, Plus, Trash2 } from 'lucide-react';

type Plant = {
    id: number;
    name: string;
    slug: string;
    kind: string;
    is_visible: boolean;
    updated_at: string;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Админка', href: '/dashboard' },
    { title: 'Растения', href: index.url() },
];

export default function AdminPlantsIndex({ plants }: { plants: Plant[] }) {
    function handleDelete(p: Plant) {
        if (confirm('Удалить растение?')) {
            router.delete(destroy.url({ plant: p.id }));
        }
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Растения" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-xl font-semibold">Растения</h1>
                    <Button asChild>
                        <Link href={create.url()}>
                            <Plus className="size-4" />
                            Добавить
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
                                <th className="px-4 py-3 text-left font-medium">
                                    Тип
                                </th>
                                <th className="w-[100px] px-4 py-3 text-left font-medium">
                                    Видимо
                                </th>
                                <th className="w-[120px] px-4 py-3 text-right font-medium">
                                    Действия
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {plants.length === 0 ? (
                                <tr>
                                    <td
                                        colSpan={5}
                                        className="px-4 py-8 text-center text-muted-foreground"
                                    >
                                        Пока нет растений
                                    </td>
                                </tr>
                            ) : (
                                plants.map((p) => (
                                    <tr key={p.id} className="border-b">
                                        <td className="px-4 py-3">{p.name}</td>
                                        <td className="px-4 py-3 font-mono text-xs">
                                            {p.slug}
                                        </td>
                                        <td className="px-4 py-3">{p.kind}</td>
                                        <td className="px-4 py-3">
                                            {p.is_visible ? 'Да' : 'Нет'}
                                        </td>
                                        <td className="px-4 py-3 text-right">
                                            <Button
                                                variant="ghost"
                                                size="icon"
                                                asChild
                                            >
                                                <Link
                                                    href={edit.url({
                                                        plant: p.id,
                                                    })}
                                                >
                                                    <Pencil className="size-4" />
                                                </Link>
                                            </Button>
                                            <Button
                                                variant="ghost"
                                                size="icon"
                                                type="button"
                                                onClick={() => handleDelete(p)}
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
