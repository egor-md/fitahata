import { useMemo, useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { index, show } from '@/routes/admin/orders';
import type { BreadcrumbItem } from '@/types';
import { Eye } from 'lucide-react';

type Order = {
    id: number;
    order_number: string;
    customer_name: string;
    customer_phone: string;
    status: string;
    total: string | number;
    items_count: number;
    created_at: string;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Админка', href: '/dashboard' },
    { title: 'Заказы', href: index.url() },
];

const filters = [
    { label: 'Все', value: 'all' },
    { label: 'Новые', value: 'new' },
    { label: 'Подтверждённые', value: 'confirmed' },
    { label: 'Завершённые', value: 'completed' },
    { label: 'Отменённые', value: 'cancelled' },
] as const;

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

export default function AdminOrdersIndex({ orders }: { orders: Order[] }) {
    const [activeFilter, setActiveFilter] = useState<(typeof filters)[number]['value']>('all');

    const filteredOrders = useMemo(() => {
        if (activeFilter === 'all') {
            return orders;
        }

        return orders.filter((order) => order.status === activeFilter);
    }, [activeFilter, orders]);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Заказы" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-xl font-semibold">Заказы</h1>
                    <div className="text-sm text-muted-foreground">
                        Всего: {orders.length}
                    </div>
                </div>

                <div className="flex flex-wrap gap-2">
                    {filters.map((filter) => (
                        <button
                            key={filter.value}
                            type="button"
                            onClick={() => setActiveFilter(filter.value)}
                            className={`rounded-full px-4 py-2 text-sm transition ${
                                activeFilter === filter.value
                                    ? 'bg-primary text-primary-foreground'
                                    : 'border bg-background hover:bg-muted'
                            }`}
                        >
                            {filter.label}
                        </button>
                    ))}
                </div>

                <div className="rounded-md border">
                    <table className="w-full text-sm">
                        <thead>
                            <tr className="border-b bg-muted/50">
                                <th className="px-4 py-3 text-left font-medium">Номер</th>
                                <th className="px-4 py-3 text-left font-medium">Клиент</th>
                                <th className="px-4 py-3 text-left font-medium">Телефон</th>
                                <th className="px-4 py-3 text-left font-medium">Сумма</th>
                                <th className="px-4 py-3 text-left font-medium">Статус</th>
                                <th className="px-4 py-3 text-left font-medium">Дата</th>
                                <th className="w-[120px] px-4 py-3 text-right font-medium">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            {filteredOrders.length === 0 ? (
                                <tr>
                                    <td
                                        colSpan={7}
                                        className="px-4 py-8 text-center text-muted-foreground"
                                    >
                                        Заказов пока нет
                                    </td>
                                </tr>
                            ) : (
                                filteredOrders.map((order) => (
                                    <tr key={order.id} className="border-b">
                                        <td className="px-4 py-3 font-mono text-xs">
                                            {order.order_number}
                                        </td>
                                        <td className="px-4 py-3">
                                            <div className="font-medium">{order.customer_name}</div>
                                            <div className="text-xs text-muted-foreground">
                                                {order.items_count} поз.
                                            </div>
                                        </td>
                                        <td className="px-4 py-3">{order.customer_phone}</td>
                                        <td className="px-4 py-3">{formatPrice(order.total)}</td>
                                        <td className="px-4 py-3">
                                            <span className={`inline-flex rounded-full px-2.5 py-1 text-xs font-medium ${statusClass(order.status)}`}>
                                                {statusLabel(order.status)}
                                            </span>
                                        </td>
                                        <td className="px-4 py-3 text-xs text-muted-foreground">
                                            {formatDate(order.created_at)}
                                        </td>
                                        <td className="px-4 py-3 text-right">
                                            <Button variant="ghost" size="icon" asChild>
                                                <Link href={show.url({ order: order.id })}>
                                                    <Eye className="size-4" />
                                                </Link>
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
