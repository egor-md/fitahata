import { Head, Link } from '@inertiajs/react';
import { Form } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/input-error';
import AppLayout from '@/layouts/app-layout';
import { index, update } from '@/routes/admin/categories';
import type { BreadcrumbItem } from '@/types';
import { ArrowLeft } from 'lucide-react';

type Category = {
    id: number;
    name: string;
    slug: string;
    show_in_menu: boolean;
    sort_order: number;
};

export default function AdminCategoriesEdit({
    category,
}: {
    category: Category;
}) {
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Админка', href: '/dashboard' },
        { title: 'Категории', href: index.url() },
        { title: category.name, href: update.url({ category: category.id }) },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Редактировать: ${category.name}`} />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center gap-4">
                    <Button variant="ghost" size="icon" asChild>
                        <Link href={index.url()}>
                            <ArrowLeft className="size-4" />
                        </Link>
                    </Button>
                    <h1 className="text-xl font-semibold">
                        Редактировать категорию
                    </h1>
                </div>

                <Form
                    action={update.url({ category: category.id })}
                    method="post"
                    className="max-w-md space-y-6"
                >
                    <input type="hidden" name="_method" value="PUT" />
                    {({ errors }) => (
                        <>
                            <div className="space-y-2">
                                <Label htmlFor="name">Название</Label>
                                <Input
                                    id="name"
                                    name="name"
                                    required
                                    autoFocus
                                    defaultValue={category.name}
                                    placeholder="Название категории"
                                />
                                <InputError message={errors.name} />
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="slug">Slug (необязательно)</Label>
                                <Input
                                    id="slug"
                                    name="slug"
                                    defaultValue={category.slug}
                                    placeholder="url-slug"
                                />
                                <InputError message={errors.slug} />
                            </div>

                            <div className="flex items-center space-x-2">
                                <input
                                    type="checkbox"
                                    id="show_in_menu"
                                    name="show_in_menu"
                                    value="1"
                                    defaultChecked={category.show_in_menu}
                                    className="size-4 rounded border-input"
                                />
                                <Label htmlFor="show_in_menu">
                                    Показывать в меню
                                </Label>
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="sort_order">Порядок</Label>
                                <Input
                                    id="sort_order"
                                    name="sort_order"
                                    type="number"
                                    min={0}
                                    defaultValue={category.sort_order}
                                />
                                <InputError message={errors.sort_order} />
                            </div>

                            <div className="flex gap-2">
                                <Button type="submit">Сохранить</Button>
                                <Button type="button" variant="outline" asChild>
                                    <Link href={index.url()}>Отмена</Link>
                                </Button>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </AppLayout>
    );
}
