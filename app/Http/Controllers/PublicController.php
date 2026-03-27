<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plant;
use App\Models\Recipe;
use App\Services\TelegramNotifier;
use App\Support\ImageVariants;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PublicController extends Controller
{
    /** @var list<string> */
    private const CATALOG_BADGE_LABELS = ['Хит', 'Новинка', 'Выгода', 'Редкость'];

    /**
     * Ровно по одной плашке на позицию: четыре типа по кругу, порядок после shuffle — случайный на каждый запрос.
     *
     * @return list<string>
     */
    private function shuffledCatalogBadgeAssignments(int $count): array
    {
        if ($count === 0) {
            return [];
        }

        $pool = [];
        for ($i = 0; $i < $count; $i++) {
            $pool[] = self::CATALOG_BADGE_LABELS[$i % 4];
        }
        shuffle($pool);

        return $pool;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function mapPlantsForCatalog(Collection $plants): array
    {
        $plants = $plants->values();
        $badges = $this->shuffledCatalogBadgeAssignments($plants->count());

        return $plants->map(function (Plant $plant, int $index) use ($badges) {
            $primaryImg = $plant->images->firstWhere('is_primary') ?? $plant->images->first();
            $imageUrl = $primaryImg?->url ?? '';
            $cardImage160 = ImageVariants::squareVariantUrl($imageUrl, 160);
            $cardImage300 = ImageVariants::squareVariantUrl($imageUrl, 300);
            $cardImage640 = ImageVariants::squareVariantUrl($imageUrl, 640);

            $priceDisplay = '';
            if ($plant->price !== null) {
                $priceDisplay = number_format((float) $plant->price, 2, ',', ' ').' BYN';
            }

            $fromDb = trim((string) ($plant->discount_label ?? ''));
            $badge = $fromDb !== '' ? $fromDb : ($badges[$index] ?? null);

            return [
                'id' => $plant->id,
                'title' => $plant->name,
                'slug' => $plant->slug,
                'image_url' => $imageUrl,
                'image_card_src' => $cardImage300 ?? $cardImage640 ?? $imageUrl,
                'image_card_srcset' => $this->buildSrcset([
                    [$cardImage160, '160w'],
                    [$cardImage300, '300w'],
                    [$cardImage640, '640w'],
                ]),
                'subtitle' => $plant->subtitle,
                'description' => Str::limit((string) $plant->description, 110),
                'benefit' => $plant->growing_period_label ?? $plant->category_label ?? '',
                'price' => $priceDisplay,
                'price_raw' => (float) ($plant->price ?? 0),
                'category' => $plant->category_label ?? '',
                'badge' => $badge,
                'rating' => $plant->rating ? (float) $plant->rating : null,
                'reviews_count' => $plant->reviews_count ?? 0,
                'tags' => $plant->relationLoaded('tags')
                    ? $plant->tags->pluck('name')->all()
                    : [],
                'weight' => $plant->price_unit_label ?? '',
            ];
        })->values()->all();
    }

    /**
     * @param  list<array{0:?string, 1:string}>  $sources
     */
    private function buildSrcset(array $sources): ?string
    {
        $srcset = collect($sources)
            ->filter(fn (array $source): bool => filled($source[0]))
            ->map(fn (array $source): string => $source[0].' '.$source[1])
            ->implode(', ');

        return $srcset !== '' ? $srcset : null;
    }

    public function home(): View
    {
        $plants = Plant::query()
            ->where('is_visible', true)
            ->with(['images', 'tags'])
            ->orderBy('name')
            ->take(8)
            ->get();

        $catalogItems = $this->mapPlantsForCatalog($plants);

        $sliderRecipes = collect();
        $recipesPool = Recipe::query()
            ->get([
                'id',
                'title',
                'image_url',
                'time_label',
                'calories_label',
                'difficulty_label',
                'tag_top',
                'tag_bottom',
                'excerpt',
                'ingredients',
                'sort_order',
            ]);

        if ($recipesPool->isNotEmpty()) {
            if ($recipesPool->count() >= 5) {
                $sliderRecipes = $recipesPool->shuffle()->take(5)->values();
            } else {
                for ($i = 0; $i < 5; $i++) {
                    $sliderRecipes->push($recipesPool[$i % $recipesPool->count()]);
                }
            }
        }

        return view('welcome', [
            'catalogItems' => $catalogItems,
            'sliderRecipes' => $sliderRecipes,
        ]);
    }

    public function catalog(): View
    {
        $plants = Plant::query()
            ->where('is_visible', true)
            ->with(['images', 'tags'])
            ->orderBy('name')
            ->get();

        $items = $this->mapPlantsForCatalog($plants);

        $categories = collect($items)
            ->pluck('category')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        return view('catalog', [
            'catalogItems' => $items,
            'categories' => $categories,
        ]);
    }

    public function contacts(): View
    {
        return view('contacts');
    }

    public function placeOrder(Request $request, TelegramNotifier $telegram): JsonResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'integer'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.weight' => ['nullable', 'string', 'max:255'],
        ]);

        $total = collect($validated['items'])->reduce(
            fn (float $sum, array $item): float => $sum + ((float) $item['price'] * (int) $item['qty']),
            0.0
        );

        $order = DB::transaction(function () use ($validated, $total): Order {
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'status' => Order::STATUS_NEW,
                'total' => $total,
            ]);

            $order->items()->createMany(
                collect($validated['items'])->map(fn (array $item): array => [
                    'plant_id' => (int) $item['id'],
                    'name' => $item['name'],
                    'price' => (float) $item['price'],
                    'qty' => (int) $item['qty'],
                    'weight' => $item['weight'] ?? null,
                ])->all()
            );

            return $order->refresh();
        });

        $telegramSent = $telegram->sendMessage($this->formatOrderTelegramMessage($order->load('items')));
        if (! $telegramSent) {
            Log::warning('Telegram order notification failed.', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ]);
        }

        return response()->json([
            'success' => true,
            'order_number' => $order->order_number,
            'telegram_sent' => $telegramSent,
        ]);
    }

    public function submitForm(Request $request, TelegramNotifier $telegram): JsonResponse
    {
        $formType = (string) $request->input('form_type');

        $baseRules = [
            'form_type' => ['required', 'string'],
            'page_url' => ['nullable', 'string', 'max:2048'],
        ];

        $typeRules = match ($formType) {
            'footer', 'footer_shop' => [
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:255'],
                'message' => ['required', 'string', 'max:1000'],
            ],
            'contacts' => [
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:255'],
                'email' => ['nullable', 'email', 'max:255'],
                'topic' => ['nullable', 'string', 'max:255'],
                'message' => ['required', 'string', 'max:1000'],
            ],
            'subscription' => [
                'product' => ['required', 'string', 'max:255'],
                'subscription_frequency' => ['required', 'string', 'in:weekly,biweekly,monthly'],
                'sub_name' => ['required', 'string', 'max:255'],
                'sub_phone' => ['required', 'string', 'max:255'],
                'email' => ['nullable', 'email', 'max:255'],
                'sub_address' => ['nullable', 'string', 'max:255'],
            ],
            default => [],
        };

        if ($typeRules === []) {
            return response()->json([
                'success' => false,
                'message' => 'Неизвестный тип формы.',
            ], 422);
        }

        $validated = $request->validate($baseRules + $typeRules);

        $telegramSent = $telegram->sendMessage($this->formatLeadTelegramMessage($formType, $validated));

        if (! $telegramSent) {
            Log::warning('Telegram lead notification failed.', [
                'form_type' => $formType,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Не удалось отправить заявку в Telegram.',
            ], 502);
        }

        return response()->json([
            'success' => true,
            'message' => 'Заявка отправлена.',
        ]);
    }

    private function formatOrderTelegramMessage(Order $order): string
    {
        $lines = [
            'Новый заказ '.$order->order_number,
            '',
            'Имя: '.$order->customer_name,
            'Телефон: '.$order->customer_phone,
            'Статус: '.$order->status,
            '',
            'Состав заказа:',
        ];

        foreach ($order->items as $item) {
            $line = '- '.$item->name;
            if ($item->weight) {
                $line .= ' ('.$item->weight.')';
            }
            $line .= ' x '.$item->qty.' = '.number_format((float) $item->price * $item->qty, 2, ',', ' ').' BYN';
            $lines[] = $line;
        }

        $lines[] = '';
        $lines[] = 'Итого: '.number_format((float) $order->total, 2, ',', ' ').' BYN';

        return implode("\n", $lines);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function formatLeadTelegramMessage(string $formType, array $payload): string
    {
        $label = match ($formType) {
            'footer' => 'Форма из футера',
            'footer_shop' => 'Форма из футера магазина',
            'contacts' => 'Форма со страницы контактов',
            'subscription' => 'Форма подписки',
            default => 'Заявка с сайта',
        };

        $lines = [$label];

        if (! empty($payload['page_url'])) {
            $lines[] = 'Страница: '.$payload['page_url'];
        }

        $lines[] = '';

        if ($formType === 'subscription') {
            $freqKey = (string) ($payload['subscription_frequency'] ?? '');
            $freqLabel = match ($freqKey) {
                'weekly' => 'Каждую неделю',
                'biweekly' => 'Раз в 2 недели',
                'monthly' => 'Раз в месяц',
                default => $freqKey,
            };
            $lines[] = 'Продукт: '.($payload['product'] ?? '');
            $lines[] = 'Периодичность: '.$freqLabel;
            $lines[] = 'Имя: '.($payload['sub_name'] ?? '');
            $lines[] = 'Телефон: '.($payload['sub_phone'] ?? '');
            if (! empty($payload['email'])) {
                $lines[] = 'Email: '.$payload['email'];
            }
            if (! empty($payload['sub_address'])) {
                $lines[] = 'Адрес: '.$payload['sub_address'];
            }

            return implode("\n", $lines);
        }

        $lines[] = 'Имя: '.($payload['name'] ?? '');
        $lines[] = 'Телефон: '.($payload['phone'] ?? '');

        if (! empty($payload['email'])) {
            $lines[] = 'Email: '.$payload['email'];
        }

        if (! empty($payload['topic'])) {
            $lines[] = 'Тема: '.$payload['topic'];
        }

        if (! empty($payload['message'])) {
            $lines[] = '';
            $lines[] = 'Сообщение:';
            $lines[] = (string) $payload['message'];
        }

        return implode("\n", $lines);
    }

    public function show(string $slug): View
    {
        $plant = Plant::query()
            ->where('slug', $slug)
            ->where('is_visible', true)
            ->with(['images', 'tags', 'nutritionItems', 'recipes'])
            ->firstOrFail();

        return view('microzelen', [
            'plant' => $plant,
        ]);
    }
}
