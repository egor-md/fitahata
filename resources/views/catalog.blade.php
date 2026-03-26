<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="/vite.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог микрозелени — FITAHATA</title>
    <meta name="description" content="Каталог микрозелени FITAHATA: свежие культуры с доставкой по Гомелю.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.min.css">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Manrope', sans-serif; }
        .slide-panel { transform: translateX(100%); transition: transform .3s cubic-bezier(.4,0,.2,1); }
        .slide-panel.open { transform: translateX(0); }
        .slide-panel-left { transform: translateX(-100%); transition: transform .3s cubic-bezier(.4,0,.2,1); }
        .slide-panel-left.open { transform: translateX(0); }
        .slide-overlay { transition: opacity .3s ease; }
        .slide-overlay.open { opacity: 1 !important; pointer-events: auto !important; }
        .card-add-pulse { animation: addPulse .4s ease; }
        @keyframes addPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.08); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="bg-[#FAFAF7] min-h-screen" style="font-family:'Manrope',sans-serif">

{{-- ═══════════ NAV ═══════════ --}}
<nav class="sticky top-0 z-50 bg-white border-b border-[#F0EDE4]">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 flex items-center justify-between h-16">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <span class="text-lg font-extrabold tracking-tight text-[#2D5016]">FITAHATA</span>
        </a>
        <ul class="hidden md:flex items-center gap-7">
            <li><a href="{{ route('home') }}" class="text-sm font-medium text-[#1A1A1A] hover:text-[#2D5016] transition-colors">Главная</a></li>
            <li><a href="{{ route('catalog') }}" class="text-sm font-semibold text-[#2D5016] relative">Каталог<span class="absolute -bottom-0.5 left-0 w-full h-0.5 bg-[#2D5016] rounded-full"></span></a></li>
            <li><a href="{{ route('contacts') }}" class="text-sm font-medium text-[#1A1A1A] hover:text-[#2D5016] transition-colors">Контакты</a></li>
        </ul>
        <div class="flex items-center gap-3">
            <button id="cartToggle" class="relative flex items-center gap-2 bg-[#2D5016] text-white px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap hover:bg-[#1A3A0F] transition-all duration-300 cursor-pointer">
                <i class="ri-shopping-cart-2-line text-sm"></i>Корзина<span id="cartBadge" class="absolute -top-2 -right-2 bg-[#E8C547] text-[#1A1A1A] text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center hidden">0</span>
            </button>
            <button id="mobileMenuToggle" class="md:hidden p-2 rounded-lg cursor-pointer text-[#1A1A1A]"><i class="ri-menu-line text-2xl"></i></button>
        </div>
    </div>
</nav>

{{-- ═══════════ HERO BANNER ═══════════ --}}
<div class="bg-white border-b border-[#F0EDE4]">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 py-10">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-[#9A9A9A] mb-3">
                    <a href="{{ route('home') }}" class="hover:text-[#2D5016] transition-colors">Главная</a>
                    <i class="ri-arrow-right-s-line"></i>
                    <span class="text-[#2D5016] font-medium">Каталог</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-[#1A1A1A]">Каталог микрозелени</h1>
                <p class="text-[#7A7A7A] mt-2 text-base">Свежий сбор каждое утро · Доставка по Гомелю</p>
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
    <div class="max-w-7xl mx-auto px-6 lg:px-10 py-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div id="filterBar" class="flex items-center gap-2 flex-wrap">
                <button data-filter="all" class="filter-btn flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-all duration-200 cursor-pointer bg-[#2D5016] text-white">
                    <i class="ri-apps-line text-sm"></i>Все<span class="filter-count text-xs px-1.5 py-0.5 rounded-full font-semibold bg-white/20 text-white ml-1">{{ count($catalogItems ?? []) }}</span>
                </button>
                @foreach(($categories ?? []) as $cat)
                <button data-filter="{{ $cat }}" class="filter-btn flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-all duration-200 cursor-pointer bg-[#F5F1E8] text-[#5A5A5A] hover:bg-[#EAE5D8] hover:text-[#2D5016]">
                    {{ $cat }}<span class="filter-count text-xs px-1.5 py-0.5 rounded-full font-semibold bg-white text-[#2D5016] ml-1">0</span>
                </button>
                @endforeach
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
                <span id="itemsCount" class="text-sm text-[#8A8A8A] whitespace-nowrap">{{ count($catalogItems ?? []) }} позиций</span>
                <select id="sortSelect" class="text-sm border border-[#E8E3D8] rounded-full px-4 py-2 bg-white text-[#1A1A1A] cursor-pointer outline-none focus:border-[#2D5016] transition-colors">
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
<main class="max-w-7xl mx-auto px-6 lg:px-10 py-10">
    <div id="productGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @forelse(($catalogItems ?? []) as $item)
        @php
            $badge = trim((string) ($item['badge'] ?? ''));
            $badgeBg = match($badge) {
                'Хит' => 'bg-amber-500',
                'Новинка' => 'bg-emerald-600',
                'Выгода' => 'bg-blue-600',
                'Редкость' => 'bg-purple-600',
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
             data-image="{{ $item['image_url'] }}"
             data-slug="{{ $item['slug'] }}"
             data-weight="{{ $item['weight'] }}"
             data-category="{{ $item['category'] }}"
             data-rating="{{ $item['rating'] ?? 0 }}"
        >
            <div class="relative overflow-hidden" style="padding-top:100%">
                <a href="{{ route('article.show', $item['slug']) }}" class="absolute inset-0 w-full h-full block">
                    @if(!empty($item['image_webp_srcset']))
                    <picture>
                        <source type="image/webp" srcset="{{ $item['image_webp_srcset'] }}">
                        <img alt="{{ $item['title'] }}" class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105" src="{{ $item['image_url'] }}">
                    </picture>
                    @else
                    <img alt="{{ $item['title'] }}" class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105" src="{{ $item['image_url'] }}">
                    @endif
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
                        <span class="text-xs text-[#9A9A9A] whitespace-nowrap mt-0.5">{{ $item['weight'] }}</span>
                        @endif
                    </div>
                    @if($item['subtitle'])
                    <p class="text-xs text-[#7A7A7A] leading-relaxed">{{ $item['subtitle'] }}</p>
                    @endif
                    @if($item['benefit'])
                    <p class="text-xs text-[#2D5016] font-medium mt-0.5">{{ $item['benefit'] }}</p>
                    @endif
                </div>
                @if(!empty($item['tags']))
                <div class="flex flex-wrap gap-1">
                    @foreach(array_slice($item['tags'], 0, 3) as $tag)
                    <span class="text-xs bg-[#F5F1E8] text-[#5A7A3A] px-2 py-0.5 rounded-full">{{ $tag }}</span>
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
                    <span class="text-xs text-[#9A9A9A] ml-1">{{ $item['reviews_count'] }} отзывов</span>
                    @endif
                </div>
                @endif
                <div class="mt-1 pt-3 border-t border-[#F0EDE4]">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-lg font-bold text-[#2D5016]">{{ $item['price'] }}</span>
                        @if($item['price_raw'] > 0)
                        <div class="flex items-center gap-2">
                            <div class="qty-control flex items-center gap-1 border border-[#E8E3D8] rounded-full overflow-hidden">
                                <button type="button" class="qty-minus w-7 h-7 flex items-center justify-center text-[#2D5016] hover:bg-[#F5F1E8] transition-colors cursor-pointer"><i class="ri-subtract-line text-sm"></i></button>
                                <span class="qty-value text-sm font-semibold text-[#1A1A1A] w-5 text-center select-none">1</span>
                                <button type="button" class="qty-plus w-7 h-7 flex items-center justify-center text-[#2D5016] hover:bg-[#F5F1E8] transition-colors cursor-pointer"><i class="ri-add-line text-sm"></i></button>
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

    {{-- CTA BLOCK --}}
    <div class="mt-16 bg-white rounded-3xl p-8 flex flex-col md:flex-row items-center gap-6 border border-[#F0EDE4]">
        <div class="flex-shrink-0 w-20 h-20 bg-[#F5F1E8] rounded-full flex items-center justify-center">
            <i class="ri-customer-service-2-line text-3xl text-[#2D5016]"></i>
        </div>
        <div class="text-center md:text-left">
            <h3 class="text-lg font-bold text-[#1A1A1A] mb-1">Не нашли нужную культуру?</h3>
            <p class="text-sm text-[#7A7A7A]">Мы выращиваем более 20 видов микрозелени. Напишите нам — подберём под ваши задачи или договоримся о постоянной поставке.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
            <a href="https://wa.me/375291234567" target="_blank" rel="nofollow noopener noreferrer" class="flex items-center gap-2 bg-[#2D5016] text-white px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap hover:bg-[#1A3A0F] transition-colors cursor-pointer">
                <i class="ri-whatsapp-line text-sm"></i>WhatsApp
            </a>
            <a href="{{ route('contacts') }}" class="flex items-center gap-2 border border-[#2D5016] text-[#2D5016] px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap hover:bg-[#2D5016] hover:text-white transition-all cursor-pointer">Написать нам</a>
        </div>
    </div>
</main>

{{-- ═══════════ MOBILE FLOATING CART BTN ═══════════ --}}
<button id="cartToggleMobile" class="fixed bottom-6 right-6 md:hidden flex items-center gap-2 bg-[#2D5016] text-white px-5 py-3.5 rounded-full font-bold text-sm whitespace-nowrap cursor-pointer z-40" style="box-shadow:rgba(45,80,22,.4) 0 8px 24px">
    <i class="ri-shopping-cart-2-line"></i>
    Корзина (<span id="cartBadgeMobile">0</span>)
</button>

{{-- ═══════════ CART OVERLAY ═══════════ --}}
<div id="slideOverlay" class="slide-overlay fixed inset-0 bg-black/30 z-50 opacity-0 pointer-events-none"></div>

{{-- ═══════════ MOBILE MENU PANEL (slide-in left) ═══════════ --}}
<div id="mobileMenuPanel" class="slide-panel-left fixed top-0 left-0 h-full w-full max-w-xs bg-white z-50 flex flex-col" style="box-shadow:8px 0 30px rgba(0,0,0,.08)">
    <div class="flex items-center justify-between px-6 py-5 border-b border-[#F0EDE4]">
        <span class="text-lg font-extrabold tracking-tight text-[#2D5016]">FITAHATA</span>
        <button id="mobileMenuClose" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#F5F1E8] transition-colors cursor-pointer text-[#5A5A5A]"><i class="ri-close-line text-lg"></i></button>
    </div>
    <nav class="flex-1 overflow-y-auto px-6 py-6">
        <ul class="flex flex-col gap-1">
            <li>
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#1A1A1A] hover:bg-[#F5F1E8] transition-colors text-base font-medium">
                    <i class="ri-home-4-line text-lg text-[#2D5016]"></i>Главная
                </a>
            </li>
            <li>
                <a href="{{ route('catalog') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#F5F1E8] text-[#2D5016] text-base font-semibold">
                    <i class="ri-leaf-line text-lg"></i>Каталог
                </a>
            </li>
            <li>
                <a href="{{ route('contacts') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#1A1A1A] hover:bg-[#F5F1E8] transition-colors text-base font-medium">
                    <i class="ri-phone-line text-lg text-[#2D5016]"></i>Контакты
                </a>
            </li>
        </ul>

        <div class="mt-6 pt-6 border-t border-[#F0EDE4]">
            <p class="text-xs text-[#9A9A9A] mb-3 px-4">Доставка по Гомелю</p>
            <a href="https://wa.me/375291234567" target="_blank" rel="nofollow noopener noreferrer" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#1A1A1A] hover:bg-[#F5F1E8] transition-colors text-sm font-medium">
                <i class="ri-whatsapp-line text-lg text-[#25D366]"></i>WhatsApp
            </a>
            <a href="tel:+375291234567" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#1A1A1A] hover:bg-[#F5F1E8] transition-colors text-sm font-medium">
                <i class="ri-phone-fill text-lg text-[#2D5016]"></i>+375 29 123-45-67
            </a>
        </div>
    </nav>
</div>

{{-- ═══════════ CART PANEL (slide-in) ═══════════ --}}
<div id="cartPanel" class="slide-panel fixed top-0 right-0 h-full w-full max-w-md bg-white z-50 flex flex-col" style="box-shadow:-8px 0 30px rgba(0,0,0,.08)">
    <div class="flex items-center justify-between px-6 py-5 border-b border-[#F0EDE4]">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-[#F5F1E8] rounded-full flex items-center justify-center"><i class="ri-shopping-cart-2-line text-[#2D5016] text-base"></i></div>
            <div>
                <h2 class="text-base font-bold text-[#1A1A1A]">Моя корзина</h2>
                <p id="cartSubtitle" class="text-xs text-[#9A9A9A]">Пусто</p>
            </div>
        </div>
        <button id="cartClose" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#F5F1E8] transition-colors cursor-pointer text-[#5A5A5A]"><i class="ri-close-line text-lg"></i></button>
    </div>

    <div id="cartItems" class="flex-1 overflow-y-auto px-6 py-4 flex flex-col gap-3">
        <div id="cartEmpty" class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-16 h-16 bg-[#F5F1E8] rounded-full flex items-center justify-center mb-4"><i class="ri-shopping-cart-line text-2xl text-[#B0B0B0]"></i></div>
            <p class="text-sm text-[#9A9A9A]">Корзина пуста</p>
            <p class="text-xs text-[#C0C0C0] mt-1">Добавьте товары из каталога</p>
        </div>
    </div>

    <div id="cartFooter" class="border-t border-[#F0EDE4] px-6 py-5 flex flex-col gap-3 hidden">
        <div class="flex items-center justify-between">
            <span class="text-sm text-[#7A7A7A]">Доставка</span>
            <span class="text-sm font-medium text-[#2D5016]">Бесплатно</span>
        </div>
        <div class="flex items-center justify-between">
            <span class="text-base font-bold text-[#1A1A1A]">Итого</span>
            <span id="cartTotal" class="text-xl font-bold text-[#2D5016]">0,00 BYN</span>
        </div>
        <button id="checkoutBtn" class="w-full bg-[#2D5016] text-white py-3.5 rounded-full text-sm font-bold whitespace-nowrap hover:bg-[#1A3A0F] transition-colors cursor-pointer mt-1 flex items-center justify-center gap-2">
            <i class="ri-whatsapp-line text-base"></i>Оформить заказ в WhatsApp
        </button>
        <button id="clearCartBtn" class="w-full text-center text-xs text-[#B0B0B0] hover:text-[#E08080] transition-colors cursor-pointer py-1">Очистить корзину</button>
    </div>
</div>

<script>
(function () {
    'use strict';

    var STORAGE_KEY = 'fitahata_cart';

    function getCart() {
        try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) || []; }
        catch (e) { return []; }
    }
    function saveCart(cart) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(cart));
    }

    function addItem(product, qty) {
        var cart = getCart();
        var existing = cart.find(function (i) { return i.id === product.id; });
        if (existing) {
            existing.qty += qty;
        } else {
            cart.push({
                id: product.id,
                slug: product.slug,
                name: product.name,
                price: product.price,
                priceDisplay: product.priceDisplay,
                image: product.image,
                weight: product.weight,
                qty: qty
            });
        }
        saveCart(cart);
        refreshUI();
    }

    function removeItem(id) {
        var cart = getCart().filter(function (i) { return i.id !== id; });
        saveCart(cart);
        refreshUI();
    }

    function updateItemQty(id, newQty) {
        if (newQty < 1) { removeItem(id); return; }
        var cart = getCart();
        var item = cart.find(function (i) { return i.id === id; });
        if (item) { item.qty = newQty; saveCart(cart); }
        refreshUI();
    }

    function clearCart() {
        saveCart([]);
        refreshUI();
    }

    function totalItems() {
        return getCart().reduce(function (s, i) { return s + i.qty; }, 0);
    }

    function totalPrice() {
        return getCart().reduce(function (s, i) { return s + i.price * i.qty; }, 0);
    }

    function formatPrice(n) {
        return n.toFixed(2).replace('.', ',') + ' BYN';
    }

    function pluralize(n) {
        var mod10 = n % 10;
        var mod100 = n % 100;
        if (mod100 >= 11 && mod100 <= 19) return n + ' позиций';
        if (mod10 === 1) return n + ' позиция';
        if (mod10 >= 2 && mod10 <= 4) return n + ' позиции';
        return n + ' позиций';
    }

    /* ─── Badge ─── */
    function refreshBadge() {
        var count = totalItems();
        var badge = document.getElementById('cartBadge');
        var badgeMob = document.getElementById('cartBadgeMobile');
        if (badge) {
            badge.textContent = count;
            badge.classList.toggle('hidden', count === 0);
        }
        if (badgeMob) badgeMob.textContent = count;
    }

    /* ─── Cart panel rendering (patch-in-place to avoid image flicker) ─── */
    function renderCartPanel() {
        var cart = getCart();
        var container = document.getElementById('cartItems');
        var emptyEl = document.getElementById('cartEmpty');
        var footer = document.getElementById('cartFooter');
        var subtitle = document.getElementById('cartSubtitle');
        var totalEl = document.getElementById('cartTotal');

        if (!container) return;

        var existing = {};
        container.querySelectorAll('.cart-line').forEach(function (el) {
            existing[el.dataset.cartItemId] = el;
        });

        if (cart.length === 0) {
            Object.values(existing).forEach(function (el) { el.remove(); });
            if (emptyEl) emptyEl.style.display = '';
            if (footer) footer.classList.add('hidden');
            if (subtitle) subtitle.textContent = 'Пусто';
            return;
        }

        if (emptyEl) emptyEl.style.display = 'none';
        if (footer) footer.classList.remove('hidden');
        if (subtitle) subtitle.textContent = pluralize(cart.length);
        if (totalEl) totalEl.textContent = formatPrice(totalPrice());

        var cartIds = {};
        cart.forEach(function (item) {
            cartIds[item.id] = true;
            var lineTotal = item.price * item.qty;
            var el = existing[item.id];

            if (el) {
                var qtySpan = el.querySelector('.cart-line-qty');
                var totalSpan = el.querySelector('.cart-line-total');
                if (qtySpan) qtySpan.textContent = item.qty;
                if (totalSpan) totalSpan.textContent = formatPrice(lineTotal);
            } else {
                el = document.createElement('div');
                el.className = 'cart-line flex items-start gap-3 bg-[#FAFAF7] rounded-2xl p-3';
                el.dataset.cartItemId = item.id;
                el.innerHTML =
                    '<div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">' +
                        '<img alt="' + esc(item.name) + '" class="w-full h-full object-cover object-top" src="' + esc(item.image) + '">' +
                    '</div>' +
                    '<div class="flex-1 min-w-0">' +
                        '<div class="flex items-start justify-between gap-2">' +
                            '<div>' +
                                '<p class="text-sm font-semibold text-[#1A1A1A] leading-tight">' + esc(item.name) + '</p>' +
                                (item.weight ? '<p class="text-xs text-[#9A9A9A] mt-0.5">' + esc(item.weight) + '</p>' : '') +
                            '</div>' +
                            '<button data-remove="' + item.id + '" class="cart-remove w-6 h-6 flex items-center justify-center rounded-full hover:bg-[#F0E0E0] text-[#C08080] transition-colors cursor-pointer flex-shrink-0"><i class="ri-delete-bin-6-line text-xs"></i></button>' +
                        '</div>' +
                        '<div class="flex items-center justify-between mt-2">' +
                            '<div class="flex items-center gap-1 border border-[#E8E3D8] rounded-full bg-white overflow-hidden">' +
                                '<button data-cart-minus="' + item.id + '" class="w-6 h-6 flex items-center justify-center text-[#2D5016] hover:bg-[#F5F1E8] transition-colors cursor-pointer"><i class="ri-subtract-line text-xs"></i></button>' +
                                '<span class="cart-line-qty text-xs font-bold text-[#1A1A1A] w-5 text-center">' + item.qty + '</span>' +
                                '<button data-cart-plus="' + item.id + '" class="w-6 h-6 flex items-center justify-center text-[#2D5016] hover:bg-[#F5F1E8] transition-colors cursor-pointer"><i class="ri-add-line text-xs"></i></button>' +
                            '</div>' +
                            '<span class="cart-line-total text-sm font-bold text-[#2D5016]">' + formatPrice(lineTotal) + '</span>' +
                        '</div>' +
                    '</div>';
                container.appendChild(el);
            }
        });

        Object.keys(existing).forEach(function (id) {
            if (!cartIds[id]) existing[id].remove();
        });
    }

    function esc(s) {
        var d = document.createElement('div');
        d.textContent = s || '';
        return d.innerHTML;
    }

    function refreshUI() {
        refreshBadge();
        renderCartPanel();
    }

    /* ─── Shared overlay + slide panels ─── */
    var overlay = document.getElementById('slideOverlay');
    var cartPanel = document.getElementById('cartPanel');
    var menuPanel = document.getElementById('mobileMenuPanel');
    var activePanel = null;

    function openPanel(panel) {
        if (activePanel) closePanel();
        activePanel = panel;
        if (overlay) overlay.classList.add('open');
        if (panel) panel.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closePanel() {
        if (overlay) overlay.classList.remove('open');
        if (activePanel) activePanel.classList.remove('open');
        activePanel = null;
        document.body.style.overflow = '';
    }

    function openCart() { openPanel(cartPanel); renderCartPanel(); }
    function closeCart() { closePanel(); }

    function openMobileMenu() { openPanel(menuPanel); }
    function closeMobileMenu() { closePanel(); }

    document.getElementById('cartToggle').addEventListener('click', openCart);
    document.getElementById('cartToggleMobile').addEventListener('click', openCart);
    document.getElementById('cartClose').addEventListener('click', closeCart);
    document.getElementById('mobileMenuToggle').addEventListener('click', openMobileMenu);
    document.getElementById('mobileMenuClose').addEventListener('click', closeMobileMenu);
    if (overlay) overlay.addEventListener('click', closePanel);

    /* ─── Cart panel delegated events ─── */
    document.getElementById('cartItems').addEventListener('click', function (e) {
        var btn = e.target.closest('[data-remove]');
        if (btn) { removeItem(Number(btn.dataset.remove)); return; }

        var minus = e.target.closest('[data-cart-minus]');
        if (minus) {
            var id = Number(minus.dataset.cartMinus);
            var item = getCart().find(function (i) { return i.id === id; });
            if (item) updateItemQty(id, item.qty - 1);
            return;
        }

        var plus = e.target.closest('[data-cart-plus]');
        if (plus) {
            var id2 = Number(plus.dataset.cartPlus);
            var item2 = getCart().find(function (i) { return i.id === id2; });
            if (item2) updateItemQty(id2, item2.qty + 1);
        }
    });

    document.getElementById('clearCartBtn').addEventListener('click', function () {
        if (confirm('Очистить корзину?')) clearCart();
    });

    /* ─── WhatsApp checkout ─── */
    document.getElementById('checkoutBtn').addEventListener('click', function () {
        var cart = getCart();
        if (!cart.length) return;
        var lines = cart.map(function (i) {
            return '• ' + i.name + (i.weight ? ' (' + i.weight + ')' : '') + ' × ' + i.qty + ' = ' + formatPrice(i.price * i.qty);
        });
        var msg = 'Здравствуйте! Хочу заказать:\n\n' + lines.join('\n') + '\n\nИтого: ' + formatPrice(totalPrice());
        window.open('https://wa.me/375291234567?text=' + encodeURIComponent(msg), '_blank');
    });

    /* ─── Product card: qty +/- and add to cart ─── */
    document.getElementById('productGrid').addEventListener('click', function (e) {
        var card = e.target.closest('.product-card');
        if (!card) return;

        var qtyEl = card.querySelector('.qty-value');
        if (!qtyEl) return;
        var currentQty = parseInt(qtyEl.textContent, 10) || 1;

        if (e.target.closest('.qty-minus')) {
            var newQty = Math.max(1, currentQty - 1);
            qtyEl.textContent = newQty;
            e.preventDefault();
            return;
        }

        if (e.target.closest('.qty-plus')) {
            qtyEl.textContent = currentQty + 1;
            e.preventDefault();
            return;
        }

        if (e.target.closest('.add-to-cart')) {
            e.preventDefault();
            var product = {
                id: Number(card.dataset.id),
                slug: card.dataset.slug,
                name: card.dataset.name,
                price: parseFloat(card.dataset.price),
                priceDisplay: card.dataset.priceDisplay,
                image: card.dataset.image,
                weight: card.dataset.weight
            };
            addItem(product, parseInt(qtyEl.textContent, 10) || 1);
            qtyEl.textContent = '1';

            var cartBtn = card.querySelector('.add-to-cart');
            cartBtn.classList.add('card-add-pulse');
            setTimeout(function () { cartBtn.classList.remove('card-add-pulse'); }, 400);
        }
    });

    /* ─── Filtering ─── */
    var allCards = Array.from(document.querySelectorAll('.product-card'));
    var filterBtns = Array.from(document.querySelectorAll('.filter-btn'));
    var activeFilter = 'all';

    filterBtns.forEach(function (btn) {
        var cat = btn.dataset.filter;
        if (cat !== 'all') {
            var count = allCards.filter(function (c) { return c.dataset.category === cat; }).length;
            var span = btn.querySelector('.filter-count');
            if (span) span.textContent = count;
        }
    });

    function applyFilter(category) {
        activeFilter = category;
        filterBtns.forEach(function (btn) {
            var isActive = btn.dataset.filter === category;
            btn.classList.toggle('bg-[#2D5016]', isActive);
            btn.classList.toggle('text-white', isActive);
            btn.classList.toggle('bg-[#F5F1E8]', !isActive);
            btn.classList.toggle('text-[#5A5A5A]', !isActive);
            var countEl = btn.querySelector('.filter-count');
            if (countEl) {
                countEl.classList.toggle('bg-white/20', isActive);
                countEl.classList.toggle('text-white', isActive);
                countEl.classList.toggle('bg-white', !isActive);
                countEl.classList.toggle('text-[#2D5016]', !isActive);
            }
        });
        var visible = 0;
        allCards.forEach(function (card) {
            var show = category === 'all' || card.dataset.category === category;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        document.getElementById('itemsCount').textContent = visible + ' позиций';
    }

    document.getElementById('filterBar').addEventListener('click', function (e) {
        var btn = e.target.closest('.filter-btn');
        if (btn) applyFilter(btn.dataset.filter);
    });

    /* ─── Sorting ─── */
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

        cards.forEach(function (card) { grid.appendChild(card); });
    });

    /* ─── Escape key closes any open panel ─── */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closePanel();
    });

    /* ─── Initial render ─── */
    refreshUI();
})();
</script>
</body>
</html>
