import { Head, Link } from '@inertiajs/react';
import { Form } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/input-error';
import AppLayout from '@/layouts/app-layout';
import { index, store } from '@/routes/admin/categories';
import type { BreadcrumbItem } from '@/types';
import { ArrowLeft } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Админка', href: '/dashboard' },
    { title: 'Категории', href: index.url() },
    { title: 'Создать', href: store.url() },
];

export default function AdminCategoriesCreate() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Создать категорию" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center gap-4">
                    <Button variant="ghost" size="icon" asChild>
                        <Link href={index.url()}>
                            <ArrowLeft className="size-4" />
                        </Link>
                    </Button>
                    <h1 className="text-xl font-semibold">Создать категорию</h1>
                </div>

                <Form
                    action={store.url()}
                    method="post"
                    className="max-w-md space-y-6"
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
                                    placeholder="Название категории"
                                />
                                <InputError message={errors.name} />
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="slug">Slug (необязательно)</Label>
                                <Input
                                    id="slug"
                                    name="slug"
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
                                    defaultChecked
                                    className="size-4 rounded border-input"
                                />
                                <Label htmlFor="show_in_menu">Показывать в меню</Label>
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="sort_order">Порядок</Label>
                                <Input
                                    id="sort_order"
                                    name="sort_order"
                                    type="number"
                                    min={0}
                                    defaultValue={0}
                                />
                                <InputError message={errors.sort_order} />
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
            </div>
        </AppLayout>
    );
}
