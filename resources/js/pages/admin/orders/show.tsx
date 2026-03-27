import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { index, status as orderStatus } from '@/routes/admin/orders';
import type { BreadcrumbItem } from '@/types';
import { ArrowLeft } from 'lucide-react';

type OrderItem = {
    id: number;
    name: string;
    price: string | number;
    qty: number;
    weight: string | null;
};

type Order = {
    id: number;
    order_number: string;
    customer_name: string;
    customer_phone: string;
    status: string;
    total: string | number;
    created_at: string;
    items: OrderItem[];
};

function statusLabel(status: string): string {
    if (status === 'confirmed') return 'Подтверждён';
    if (status === 'completed') return 'Завершён';
    if (status === 'cancelled') return 'Отменён';
    return 'Новый';
}

function statusClass(status: string): string {
    if (status === 'confirmed') return 'bg-blue-100 text-blue-800';
    if (status === 'completed') return 'bg-emerald-100 text-emerald-800';
    if (status === 'cancelled') return 'bg-rose-100 text-rose-800';
    return 'bg-amber-100 text-amber-800';
}

function formatPrice(value: string | number): string {
    return `${Number(value).toFixed(2).replace('.', ',')} BYN`;
}

function formatDate(value: string): string {
    return new Date(value).toLocaleString('ru-RU');
}

export default function AdminOrdersShow({ order }: { order: Order }) {
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Админка', href: '/dashboard' },
        { title: 'Заказы', href: index.url() },
        { title: order.order_number, href: '#' },
    ];

    function updateStatus(status: string) {
        router.patch(orderStatus.url({ order: order.id }), { status });
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={order.order_number} />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center gap-4">
                    <Button variant="ghost" size="icon" asChild>
                        <Link href={index.url()}>
                            <ArrowLeft className="size-4" />
                        </Link>
                    </Button>
                    <div>
                        <h1 className="text-xl font-semibold">{order.order_number}</h1>
                        <p className="text-sm text-muted-foreground">
                            Создан: {formatDate(order.created_at)}
                        </p>
                    </div>
                </div>

                <div className="grid gap-4 lg:grid-cols-[minmax(0,1fr)_280px]">
                    <div className="rounded-md border">
                        <table className="w-full text-sm">
                            <thead>
                                <tr className="border-b bg-muted/50">
                                    <th className="px-4 py-3 text-left font-medium">Товар</th>
                                    <th className="px-4 py-3 text-left font-medium">Количество</th>
                                    <th className="px-4 py-3 text-left font-medium">Цена</th>
                                    <th className="px-4 py-3 text-left font-medium">Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                {order.items.map((item) => (
                                    <tr key={item.id} className="border-b">
                                        <td className="px-4 py-3">
                                            <div className="font-medium">{item.name}</div>
                                            {item.weight ? (
                                                <div className="text-xs text-muted-foreground">{item.weight}</div>
                                            ) : null}
                                        </td>
                                        <td className="px-4 py-3">{item.qty}</td>
                                        <td className="px-4 py-3">{formatPrice(item.price)}</td>
                                        <td className="px-4 py-3">
                                            {formatPrice(Number(item.price) * item.qty)}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    <div className="space-y-4">
                        <div className="rounded-md border p-4">
                            <div className="space-y-3 text-sm">
                                <div>
                                    <div className="text-muted-foreground">Клиент</div>
                                    <div className="font-medium">{order.customer_name}</div>
                                </div>
                                <div>
                                    <div className="text-muted-foreground">Телефон</div>
                                    <div className="font-medium">{order.customer_phone}</div>
                                </div>
                                <div>
                                    <div className="text-muted-foreground">Статус</div>
                                    <span className={`mt-1 inline-flex rounded-full px-2.5 py-1 text-xs font-medium ${statusClass(order.status)}`}>
                                        {statusLabel(order.status)}
                                    </span>
                                </div>
                                <div>
                                    <div className="text-muted-foreground">Итого</div>
                                    <div className="text-lg font-semibold">{formatPrice(order.total)}</div>
                                </div>
                            </div>
                        </div>

                        <div className="rounded-md border p-4">
                            <div className="mb-3 text-sm font-medium">Изменить статус</div>
                            <div className="flex flex-col gap-2">
                                <Button type="button" variant="outline" onClick={() => updateStatus('confirmed')}>
                                    Подтвердить
                                </Button>
                                <Button type="button" variant="outline" onClick={() => updateStatus('completed')}>
                                    Завершить
                                </Button>
                                <Button type="button" variant="outline" onClick={() => updateStatus('cancelled')}>
                                    Отменить
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
