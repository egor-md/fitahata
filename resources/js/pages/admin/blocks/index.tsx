import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { create, destroy, edit, index } from '@/routes/admin/blocks';
import type { BreadcrumbItem } from '@/types';
import { Pencil, Plus, Trash2 } from 'lucide-react';

type Block = {
    id: number;
    name: string;
    type: string;
    settings: { images?: Array<{ url: string; alt?: string; caption?: string }> } | null;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Админка', href: '/dashboard' },
    { title: 'Блоки', href: index.url() },
];

export default function AdminBlocksIndex({ blocks }: { blocks: Block[] }) {
    function handleDelete(block: Block) {
        if (confirm('Удалить блок?')) {
            router.delete(destroy.url({ block: block.id }));
        }
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Блоки" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-xl font-semibold">Блоки</h1>
                    <Button asChild>
                        <Link href={create.url()}>
                            <Plus className="size-4" />
                            Создать блок
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
                                    Тип
                                </th>
                                <th className="w-[120px] px-4 py-3 text-right font-medium">
                                    Действия
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {blocks.length === 0 ? (
                                <tr>
                                    <td
                                        colSpan={3}
                                        className="px-4 py-8 text-center text-muted-foreground"
                                    >
                                        Нет блоков
                                    </td>
                                </tr>
                            ) : (
                                blocks.map((block) => (
                                    <tr
                                        key={block.id}
                                        className="border-b last:border-0"
                                    >
                                        <td className="px-4 py-3 font-medium">
                                            {block.name}
                                        </td>
                                        <td className="px-4 py-3 capitalize text-muted-foreground">
                                            {block.type}
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
                                                            block: block.id,
                                                        })}
                                                    >
                                                        <Pencil className="size-4" />
                                                    </Link>
                                                </Button>
                                                <Button
                                                    variant="destructive"
                                                    size="icon"
                                                    onClick={() =>
                                                        handleDelete(block)
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
