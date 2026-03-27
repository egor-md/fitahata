<?php

use App\Models\Order;
use Illuminate\Support\Facades\Http;

test('order submission sends telegram notification', function () {
    Http::fake([
        'https://api.telegram.org/*' => Http::response(['ok' => true], 200),
    ]);

    config()->set('services.telegram.bot_token', 'test-token');
    config()->set('services.telegram.chat_id', '123456');

    $response = $this->postJson(route('orders.place'), [
        'customer_name' => 'Иван',
        'customer_phone' => '+375291112233',
        'items' => [
            [
                'id' => 1,
                'name' => 'Горох',
                'price' => 5.5,
                'qty' => 2,
                'weight' => '50 г',
            ],
        ],
    ]);

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
            'telegram_sent' => true,
        ]);

    expect(Order::query()->count())->toBe(1);

    Http::assertSent(function ($request) {
        return str_contains($request->url(), '/sendMessage')
            && $request['chat_id'] === '123456'
            && str_contains($request['text'], 'Новый заказ FH-');
    });
});

test('contacts form sends telegram notification', function () {
    Http::fake([
        'https://api.telegram.org/*' => Http::response(['ok' => true], 200),
    ]);

    config()->set('services.telegram.bot_token', 'test-token');
    config()->set('services.telegram.chat_id', '123456');

    $response = $this->postJson(route('forms.submit'), [
        'form_type' => 'contacts',
        'name' => 'Анна',
        'phone' => '+375291112244',
        'email' => 'anna@example.com',
        'topic' => 'Оформление заказа',
        'message' => 'Хочу сделать заказ.',
        'page_url' => 'http://localhost:8000/contacts',
    ]);

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ]);

    Http::assertSent(function ($request) {
        return str_contains($request->url(), '/sendMessage')
            && str_contains($request['text'], 'Форма со страницы контактов')
            && str_contains($request['text'], 'Анна');
    });
});
