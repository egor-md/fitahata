<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(): Response
    {
        $orders = Order::query()
            ->withCount('items')
            ->latest()
            ->get();

        return Inertia::render('admin/orders/index', [
            'orders' => $orders,
        ]);
    }

    public function show(Order $order): Response
    {
        $order->load('items');

        return Inertia::render('admin/orders/show', [
            'order' => $order,
        ]);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(Order::statuses())],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return back();
    }
}
