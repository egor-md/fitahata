@extends('layouts.shop')

@section('title', 'Каталог микрозелени — FITAHATA')
@section('meta_description', 'Каталог микрозелени FITAHATA: свежие культуры с доставкой по Гомелю.')

@section('content')
{{-- ═══════════ HERO BANNER ═══════════ --}}
<div class="bg-white border-b border-[#F0EDE4]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-10">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-[#5C5F58] mb-3">
                    <a href="{{ route('home') }}" class="text-[#5C5F58] hover:text-[#2D5016] transition-colors">Главная</a>
                    <i class="ri-arrow-right-s-line text-[#5C5F58]" aria-hidden="true"></i>
                    <span class="text-[#2D5016] font-medium">Каталог</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-[#1A1A1A]">Каталог микрозелени</h1>
                <p class="text-[#525852] mt-2 text-base">Свежий сбор каждое утро · Доставка по Гомелю</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <div class="flex items-center gap-2 bg-[#F5F1E8] rounded-full px-3.5 py-2">
                    <i class="ri-truck-line text-sm text-[#2D5016]"></i>
                    <span class="text-xs font-medium text-[#3A5A20]">Бесплатная доставка</span>
                </div>
                <div class="flex items-center gap-2 bg-[#F5F1E8] rounded-full px-3.5 py-2">
                    <i class="ri-time-line text-sm text-[#2D5016]"></i>
                    <span class="text-xs font-medium text-[#3A5A20]">Сбор утром, доставка днём</span>
                </div>
                <div class="flex items-center gap-2 bg-[#F5F1E8] rounded-full px-3.5 py-2">
                    <i class="ri-leaf-line text-sm text-[#2D5016]"></i>
                    <span class="text-xs font-medium text-[#3A5A20]">100% натуральное</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════ FILTERS + SORT ═══════════ --}}
<div class="bg-white border-b border-[#F0EDE4] sticky top-16 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div id="filterBar" class="flex items-center gap-2 flex-wrap">
                <button data-filter="all" class="filter-btn flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-all duration-200 cursor-pointer bg-[#2D5016] text-white">
                    <i class="ri-apps-line text-sm"></i>Все<span class="filter-count text-xs px-1.5 py-0.5 rounded-full font-semibold bg-white/20 text-white ml-1">{{ count($catalogItems ?? []) }}</span>
                </button>
                @foreach(($categories ?? []) as $cat)
                <button data-filter="{{ $cat }}" class="filter-btn flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-all duration-200 cursor-pointer bg-[#F5F1E8] text-[#4A4D46] hover:bg-[#EAE5D8] hover:text-[#2D5016]">
                    {{ $cat }}<span class="filter-count text-xs px-1.5 py-0.5 rounded-full font-semibold bg-white text-[#2D5016] ml-1">0</span>
                </button>
                @endforeach
            </div>
            <div class="flex items-center gap-3 flex-shrink-0 flex-wrap">
                <span id="itemsCount" class="text-sm text-[#5C5F58] whitespace-nowrap">{{ count($catalogItems ?? []) }} позиций</span>
                <label for="sortSelect" class="text-sm font-medium text-[#5C5F58] whitespace-nowrap">Сортировка</label>
                <select id="sortSelect" name="sort"
                    class="text-sm border border-[#E8E3D8] rounded-full px-4 py-2 bg-white text-[#1A1A1A] cursor-pointer outline-none focus:border-[#2D5016] transition-colors">
                    <option value="default">По популярности</option>
                    <option value="price_asc">Цена: дешевле</option>
                    <option value="price_desc">Цена: дороже</option>
                    <option value="rating">По рейтингу</option>
                    <option value="name">По названию</option>
                </select>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════ PRODUCT GRID ═══════════ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-10">
    <div id="productGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @forelse(($catalogItems ?? []) as $item)
        @php
            $badge = trim((string) ($item['badge'] ?? ''));
            $badgeBg = match($badge) {
                'Хит' => 'bg-[#92400e]',
                'Новинка' => 'bg-[#047857]',
                'Выгода' => 'bg-[#2563eb]',
                'Редкость' => 'bg-[#9333ea]',
                default => 'bg-[#2D5016]',
            };
            $fullStars = $item['rating'] ? (int) floor($item['rating']) : 0;
            $emptyStars = 5 - $fullStars;
        @endphp
        <div class="product-card bg-white rounded-3xl overflow-hidden group transition-all duration-300 hover:-translate-y-1.5 border border-transparent hover:border-[#E8E3D8]"
             data-id="{{ $item['id'] }}"
             data-name="{{ $item['title'] }}"
             data-price="{{ $item['price_raw'] }}"
             data-price-display="{{ $item['price'] }}"
             data-image="{{ $item['image_card_src'] }}"
             data-slug="{{ $item['slug'] }}"
             data-weight="{{ $item['weight'] }}"
             data-category="{{ $item['category'] }}"
             data-rating="{{ $item['rating'] ?? 0 }}"
        >
            <div class="relative overflow-hidden" style="padding-top:100%">
                <a href="{{ route('article.show', $item['slug']) }}" class="absolute inset-0 w-full h-full block">
                    <picture>
                        @if(!empty($item['image_card_srcset']))
                        <source type="image/webp" srcset="{{ $item['image_card_srcset'] }}" sizes="(min-width: 1024px) 283px, (min-width: 768px) 33vw, 50vw">
                        @endif
                        <img alt="{{ $item['title'] }}" class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105" src="{{ $item['image_card_src'] }}" width="300" height="300" loading="lazy">
                    </picture>
                </a>
                @if($badge)
                <span class="absolute top-3 left-3 {{ $badgeBg }} text-white text-xs font-semibold px-3 py-1 rounded-full pointer-events-none">{{ $badge }}</span>
                @endif
                @if($item['rating'])
                <div class="absolute bottom-3 right-3 flex items-center gap-1 bg-white/90 backdrop-blur-sm rounded-full px-2.5 py-1 pointer-events-none">
                    <i class="ri-star-fill text-xs text-[#E8C547]"></i>
                    <span class="text-xs font-semibold text-[#1A1A1A]">{{ number_format($item['rating'], 1) }}</span>
                </div>
                @endif
            </div>
            <div class="p-4 flex flex-col gap-2">
                <div>
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <a href="{{ route('article.show', $item['slug']) }}" class="text-base font-bold text-[#1A1A1A] leading-tight hover:text-[#2D5016] transition-colors">{{ $item['title'] }}</a>
                        @if($item['weight'])
                        <span class="text-xs text-[#5C5F58] whitespace-nowrap mt-0.5">{{ $item['weight'] }}</span>
                        @endif
                    </div>
                    @if($item['subtitle'])
                    <p class="text-xs text-[#525852] leading-relaxed">{{ $item['subtitle'] }}</p>
                    @endif
                    @if($item['benefit'])
                    <p class="text-xs text-[#2D5016] font-medium mt-0.5">{{ $item['benefit'] }}</p>
                    @endif
                </div>
                @if(!empty($item['tags']))
                <div class="flex flex-wrap gap-1">
                    @foreach(array_slice($item['tags'], 0, 3) as $tag)
                    <span class="text-xs bg-[#F5F1E8] text-[#2D4518] px-2 py-0.5 rounded-full">{{ $tag }}</span>
                    @endforeach
                </div>
                @endif
                @if($item['rating'])
                <div class="flex items-center gap-1">
                    @for($i = 0; $i < $fullStars; $i++)
                    <i class="ri-star-fill text-xs text-[#E8C547]"></i>
                    @endfor
                    @for($i = 0; $i < $emptyStars; $i++)
                    <i class="ri-star-line text-xs text-[#D0D0D0]"></i>
                    @endfor
                    @if($item['reviews_count'])
                    <span class="text-xs text-[#5C5F58] ml-1">{{ $item['reviews_count'] }} отзывов</span>
                    @endif
                </div>
                @endif
                <div class="mt-1 pt-3 border-t border-[#F0EDE4]">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-lg font-bold text-[#2D5016]">{{ $item['price'] }}</span>
                        @if($item['price_raw'] > 0)
                        <div class="flex items-center gap-2">
                            <div class="qty-control flex items-center gap-1 border border-[#E8E3D8] rounded-full overflow-hidden">
                                <button type="button" aria-label="Уменьшить количество" class="qty-minus w-7 h-7 flex items-center justify-center text-[#2D5016] hover:bg-[#F5F1E8] transition-colors cursor-pointer"><i class="ri-subtract-line text-sm" aria-hidden="true"></i></button>
                                <span class="qty-value text-sm font-semibold text-[#1A1A1A] w-5 text-center select-none">1</span>
                                <button type="button" aria-label="Увеличить количество" class="qty-plus w-7 h-7 flex items-center justify-center text-[#2D5016] hover:bg-[#F5F1E8] transition-colors cursor-pointer"><i class="ri-add-line text-sm" aria-hidden="true"></i></button>
                            </div>
                            <button type="button" class="add-to-cart flex items-center gap-1.5 px-3 py-2 rounded-full text-xs font-semibold whitespace-nowrap transition-all duration-300 cursor-pointer bg-[#2D5016] text-white hover:bg-[#1A3A0F]">
                                <i class="ri-shopping-cart-2-line text-xs"></i>В корзину
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <p class="col-span-full rounded-xl border border-dashed border-neutral-300 bg-white p-6 text-sm text-neutral-600">
            Каталог пока пуст. Добавьте растения в админке.
        </p>
        @endforelse
    </div>
    <div class="mt-16 bg-white rounded-3xl p-8 flex flex-col md:flex-row items-center gap-6 border border-[#F0EDE4]">
        <div class="flex-shrink-0 w-20 h-20 bg-[#F5F1E8] rounded-full flex items-center justify-center">
            <i class="ri-customer-service-2-line text-3xl text-[#2D5016]"></i>
        </div>
        <div class="text-center md:text-left">
            <h2 class="text-lg font-bold text-[#1A1A1A] mb-1">Не нашли нужную культуру?</h2>
            <p class="text-sm text-[#525852]">Мы выращиваем более 20 видов микрозелени. Напишите нам — вырастим микрозелень под Ваш заказ.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
            <a href="https://t.me/m93458" target="_blank" rel="nofollow noopener noreferrer" aria-label="Написать в Telegram" class="flex items-center gap-2 bg-[#0C6BAE] text-white px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap hover:bg-[#095985] transition-colors"><i class="ri-telegram-line text-sm" aria-hidden="true"></i>Telegram</a>
            <a href="{{ route('contacts') }}" class="flex items-center gap-2 border border-[#2D5016] text-[#2D5016] px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap hover:bg-[#2D5016] hover:text-white transition-all">Написать нам</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';
    var cart = window.__fitahataCart;
    if (!cart) return;

    document.getElementById('productGrid').addEventListener('click', function (e) {
        var card = e.target.closest('.product-card');
        if (!card) return;
        var qtyEl = card.querySelector('.qty-value');
        if (!qtyEl) return;
        var currentQty = parseInt(qtyEl.textContent, 10) || 1;

        if (e.target.closest('.qty-minus')) { qtyEl.textContent = Math.max(1, currentQty - 1); e.preventDefault(); return; }
        if (e.target.closest('.qty-plus')) { qtyEl.textContent = currentQty + 1; e.preventDefault(); return; }

        if (e.target.closest('.add-to-cart')) {
            e.preventDefault();
            cart.addItem({
                id: Number(card.dataset.id), slug: card.dataset.slug, name: card.dataset.name,
                price: parseFloat(card.dataset.price), priceDisplay: card.dataset.priceDisplay,
                image: card.dataset.image, weight: card.dataset.weight
            }, parseInt(qtyEl.textContent, 10) || 1);
            qtyEl.textContent = '1';
            var btn = card.querySelector('.add-to-cart');
            btn.classList.add('card-add-pulse');
            setTimeout(function () { btn.classList.remove('card-add-pulse'); }, 400);
        }
    });

    var allCards = Array.from(document.querySelectorAll('.product-card'));
    var filterBtns = Array.from(document.querySelectorAll('.filter-btn'));
    filterBtns.forEach(function (btn) {
        var cat = btn.dataset.filter;
        if (cat !== 'all') {
            var count = allCards.filter(function (c) { return c.dataset.category === cat; }).length;
            var span = btn.querySelector('.filter-count');
            if (span) span.textContent = count;
        }
    });

    document.getElementById('filterBar').addEventListener('click', function (e) {
        var btn = e.target.closest('.filter-btn');
        if (!btn) return;
        var category = btn.dataset.filter;
        filterBtns.forEach(function (b) {
            var isActive = b.dataset.filter === category;
            b.classList.toggle('bg-[#2D5016]', isActive); b.classList.toggle('text-white', isActive);
            b.classList.toggle('bg-[#F5F1E8]', !isActive); b.classList.toggle('text-[#4A4D46]', !isActive);
            var c = b.querySelector('.filter-count');
            if (c) { c.classList.toggle('bg-white/20', isActive); c.classList.toggle('text-white', isActive); c.classList.toggle('bg-white', !isActive); c.classList.toggle('text-[#2D5016]', !isActive); }
        });
        var visible = 0;
        allCards.forEach(function (c) { var show = category === 'all' || c.dataset.category === category; c.style.display = show ? '' : 'none'; if (show) visible++; });
        document.getElementById('itemsCount').textContent = visible + ' позиций';
    });

    document.getElementById('sortSelect').addEventListener('change', function () {
        var grid = document.getElementById('productGrid');
        var cards = Array.from(grid.querySelectorAll('.product-card'));
        var val = this.value;
        cards.sort(function (a, b) {
            if (val === 'price_asc') return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
            if (val === 'price_desc') return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
            if (val === 'rating') return parseFloat(b.dataset.rating || 0) - parseFloat(a.dataset.rating || 0);
            if (val === 'name') return a.dataset.name.localeCompare(b.dataset.name, 'ru');
            return 0;
        });
        cards.forEach(function (c) { grid.appendChild(c); });
    });
})();
</script>
@endpush
