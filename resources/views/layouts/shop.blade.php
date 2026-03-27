<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FITAHATA — Свежая микрозелень в Гомеле')</title>
    <meta name="description" content="@yield('meta_description', 'Свежая микрозелень FITAHATA в Гомеле: каталог культур, доставка в день сбора и полезные рецепты.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta property="og:title" content="@yield('title', 'FITAHATA — Свежая микрозелень в Гомеле')">
    <meta property="og:description" content="@yield('meta_description', 'Свежая микрозелень FITAHATA в Гомеле.')">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    @vite(['resources/css/shop-app.css'])
    <style>
        html { scrollbar-gutter: stable; }
        body { font-family: 'Manrope Variable', 'Manrope', ui-sans-serif, system-ui, sans-serif; }
        .slide-panel { transform: translateX(100%); transition: transform .3s cubic-bezier(.4,0,.2,1); }
        .slide-panel.open { transform: translateX(0); }
        .slide-panel-left { transform: translateX(-100%); transition: transform .3s cubic-bezier(.4,0,.2,1); }
        .slide-panel-left.open { transform: translateX(0); }
        .slide-overlay { transition: opacity .3s ease; }
        .slide-overlay.open { opacity: 1 !important; pointer-events: auto !important; }
        .card-add-pulse { animation: addPulse .4s ease; }
        @keyframes addPulse { 0%{transform:scale(1)} 50%{transform:scale(1.08)} 100%{transform:scale(1)} }
    </style>
    @stack('styles')
</head>
<body class="bg-[#FAFAF7] min-h-screen antialiased" style="font-family:'Manrope Variable','Manrope',ui-sans-serif,system-ui,sans-serif">

{{-- ═══════════ NAV ═══════════ --}}
<nav class="sticky top-0 z-50 bg-white border-b border-[#F0EDE4]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 flex items-center justify-between h-16">        
        <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 flex items-center justify-center bg-[#2D5016] rounded-lg"><i class="ri-leaf-fill text-white text-base"></i></div>
                    <span class="text-xl font-extrabold text-[#1A3A0F] tracking-wide">FITAHATA</span>
                </a>
        <ul class="hidden md:flex items-baseline gap-7">
            <li><a href="{{ route('home') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-[#2D5016] font-semibold' : 'text-[#1A1A1A] hover:text-[#2D5016]' }}">Главная</a></li>
            <li class="relative group">
                <button type="button" class="text-sm font-medium transition-colors flex items-center gap-1 cursor-pointer {{ request()->is('article/*') || request()->routeIs('catalog') ? 'text-[#2D5016] font-semibold' : 'text-[#1A1A1A] hover:text-[#2D5016]' }}">
                    Микрозелень
                    <i class="ri-arrow-down-s-line text-xs transition-transform group-hover:rotate-180"></i>
                </button>
                <div class="absolute left-0 top-full pt-2 hidden group-hover:block z-50">
                    <div class="bg-white border border-[#F0EDE4] rounded-2xl shadow-lg py-2 min-w-[200px]">
                        <a href="{{ route('catalog') }}" class="block px-4 py-2 text-sm text-[#1A1A1A] hover:bg-[#F5F1E8] hover:text-[#2D5016] font-medium">Весь каталог</a>
                        <div class="border-t border-[#F0EDE4] my-1"></div>
                        @foreach(($menuPlants ?? collect()) as $mp)
                        <a href="{{ route('article.show', $mp->slug) }}" class="block px-4 py-1.5 text-sm text-[#5A5A5A] hover:bg-[#F5F1E8] hover:text-[#2D5016]">{{ $mp->name }}</a>
                        @endforeach
                    </div>
                </div>
            </li>
            <li><a href="{{ route('contacts') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('contacts') ? 'text-[#2D5016] font-semibold' : 'text-[#1A1A1A] hover:text-[#2D5016]' }}">Контакты</a></li>
        </ul>
        <div class="flex items-center gap-3">
            <button id="cartToggle" class="relative flex items-center gap-2 bg-[#2D5016] text-white px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap hover:bg-[#1A3A0F] transition-all duration-300 cursor-pointer">
                <i class="ri-shopping-cart-2-line text-sm"></i><span class="hidden sm:inline">Корзина</span><span id="cartBadge" class="absolute -top-2 -right-2 bg-[#E8C547] text-[#1A1A1A] text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center hidden">0</span>
            </button>
            <button id="mobileMenuToggle" class="md:hidden p-2 rounded-lg cursor-pointer text-[#1A1A1A]"><i class="ri-menu-line text-2xl"></i></button>
        </div>
    </div>
</nav>

{{-- ═══════════ MAIN CONTENT ═══════════ --}}
<main>
    @yield('content')
</main>

{{-- ═══════════ FOOTER ═══════════ --}}
@unless (View::hasSection('hide_shop_footer'))
    @include('partials.shop-footer')
@endunless

{{-- ═══════════ MOBILE FLOATING CART BTN ═══════════ --}}
<button id="cartToggleMobile" class="fixed bottom-6 right-6 md:hidden flex items-center gap-2 bg-[#2D5016] text-white px-5 py-3.5 rounded-full font-bold text-sm whitespace-nowrap cursor-pointer z-40" style="box-shadow:rgba(45,80,22,.4) 0 8px 24px">
    <i class="ri-shopping-cart-2-line"></i>
    Корзина (<span id="cartBadgeMobile">0</span>)
</button>

{{-- ═══════════ OVERLAY ═══════════ --}}
<div id="slideOverlay" class="slide-overlay fixed inset-0 bg-black/30 z-50 opacity-0 pointer-events-none"></div>

{{-- ═══════════ MOBILE MENU PANEL ═══════════ --}}
<div id="mobileMenuPanel" class="slide-panel-left fixed top-0 left-0 h-full w-full max-w-xs bg-white z-50 flex flex-col" style="box-shadow:8px 0 30px rgba(0,0,0,.08)">
    <div class="flex items-center justify-between px-6 py-5 border-b border-[#F0EDE4]">
        <span class="text-lg font-extrabold tracking-tight text-[#2D5016]">FITAHATA</span>
        <button type="button" id="mobileMenuClose" aria-label="Закрыть меню" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#F5F1E8] transition-colors cursor-pointer text-[#5A5A5A]"><i class="ri-close-line text-lg" aria-hidden="true"></i></button>
    </div>
    <nav class="flex-1 overflow-y-auto px-6 py-6">
        <ul class="flex flex-col gap-1">
            <li><a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#1A1A1A] hover:bg-[#F5F1E8] transition-colors text-base font-medium {{ request()->routeIs('home') ? 'bg-[#F5F1E8] text-[#2D5016] font-semibold' : '' }}"><i class="ri-home-4-line text-lg text-[#2D5016]"></i>Главная</a></li>
            <li><a href="{{ route('catalog') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#1A1A1A] hover:bg-[#F5F1E8] transition-colors text-base font-medium {{ request()->routeIs('catalog') ? 'bg-[#F5F1E8] text-[#2D5016] font-semibold' : '' }}"><i class="ri-leaf-line text-lg text-[#2D5016]"></i>Каталог</a></li>
            <li><a href="{{ route('contacts') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#1A1A1A] hover:bg-[#F5F1E8] transition-colors text-base font-medium {{ request()->routeIs('contacts') ? 'bg-[#F5F1E8] text-[#2D5016] font-semibold' : '' }}"><i class="ri-phone-line text-lg text-[#2D5016]"></i>Контакты</a></li>
        </ul>
        @if(($menuPlants ?? collect())->isNotEmpty())
        <div class="mt-4 pt-4 border-t border-[#F0EDE4]">
            <p class="text-xs text-[#5A5A5A] mb-2 px-4 font-medium uppercase tracking-wide">Культуры</p>
            @foreach(($menuPlants ?? collect()) as $mp)
            <a href="{{ route('article.show', $mp->slug) }}" class="block px-4 py-2 rounded-lg text-sm text-[#5A5A5A] hover:bg-[#F5F1E8] hover:text-[#2D5016] transition-colors">{{ $mp->name }}</a>
            @endforeach
        </div>
        @endif
        <div class="mt-6 pt-6 border-t border-[#F0EDE4]">
            <p class="text-xs text-[#5A5A5A] mb-3 px-4">Доставка по Гомелю</p>
            <a href="https://t.me/m93458" target="_blank" rel="nofollow noopener noreferrer" aria-label="Написать в Telegram" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#1A1A1A] hover:bg-[#F5F1E8] transition-colors text-sm font-medium"><i class="ri-telegram-line text-lg text-[#0C6BAE]" aria-hidden="true"></i>Telegram</a>
            @foreach (config('shop.phones') as $phone)
            <a href="tel:{{ $phone['tel'] }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#1A1A1A] hover:bg-[#F5F1E8] transition-colors text-sm font-medium"><i class="ri-phone-fill text-lg text-[#2D5016]"></i>{{ $phone['display'] }}</a>
            @endforeach
        </div>
    </nav>
</div>

{{-- ═══════════ CART PANEL ═══════════ --}}
<div id="cartPanel" class="slide-panel fixed top-0 right-0 h-full w-full max-w-md bg-white z-50 flex flex-col" style="box-shadow:-8px 0 30px rgba(0,0,0,.08)">
    <div class="flex items-center justify-between px-6 py-5 border-b border-[#F0EDE4]">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-[#F5F1E8] rounded-full flex items-center justify-center"><i class="ri-shopping-cart-2-line text-[#2D5016] text-base"></i></div>
            <div>
                <h2 class="text-base font-bold text-[#1A1A1A]">Моя корзина</h2>
                <p id="cartSubtitle" class="text-xs text-[#5A5A5A]">Пусто</p>
            </div>
        </div>
        <button type="button" id="cartClose" aria-label="Закрыть корзину" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#F5F1E8] transition-colors cursor-pointer text-[#5A5A5A]"><i class="ri-close-line text-lg" aria-hidden="true"></i></button>
    </div>
    <div id="cartItems" class="flex-1 overflow-y-auto px-6 py-4 flex flex-col gap-3">
        <div id="cartEmpty" class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-16 h-16 bg-[#F5F1E8] rounded-full flex items-center justify-center mb-4"><i class="ri-shopping-cart-line text-2xl text-[#6E6E6E]" aria-hidden="true"></i></div>
            <p class="text-sm text-[#5A5A5A]">Корзина пуста</p>
            <p class="text-xs text-[#5C5C5C] mt-1">Добавьте товары из каталога</p>
        </div>
    </div>
    <div id="cartFooter" class="border-t border-[#F0EDE4] px-6 py-5 flex flex-col gap-3 hidden">
        <div class="flex items-center justify-between"><span class="text-sm text-[#666666]">Доставка</span><span class="text-sm font-medium text-[#2D5016]">Бесплатно</span></div>
        <div class="flex items-center justify-between"><span class="text-base font-bold text-[#1A1A1A]">Итого</span><span id="cartTotal" class="text-xl font-bold text-[#2D5016]">0,00 BYN</span></div>
        <div id="cartFormSection" class="flex flex-col gap-3">
            <input id="checkoutName" type="text" placeholder="Ваше имя" class="w-full rounded-xl border border-[#DDD6C8] px-4 py-3 text-sm text-[#1A1A1A] outline-none focus:border-[#2D5016]">
            <input id="checkoutPhone" type="tel" placeholder="+375 (29) ___-__-__" class="w-full rounded-xl border border-[#DDD6C8] px-4 py-3 text-sm text-[#1A1A1A] outline-none focus:border-[#2D5016]">
            <p id="checkoutError" class="hidden rounded-xl bg-[#FDF1F1] px-4 py-3 text-sm text-[#B94A48]"></p>
            <button id="checkoutBtn" class="w-full bg-[#2D5016] text-white py-3.5 rounded-full text-sm font-bold whitespace-nowrap hover:bg-[#1A3A0F] transition-colors cursor-pointer mt-1 flex items-center justify-center gap-2"><i class="ri-check-line text-base"></i>Подтвердить заказ</button>
        </div>
        <div id="cartSuccessSection" class="hidden rounded-2xl bg-[#F5F1E8] p-4">
            <p class="text-sm font-bold text-[#1A1A1A]">Заказ оформлен!</p>
            <p class="mt-2 text-xs text-[#666666]">Код заказа</p>
            <div id="cartOrderNumber" class="mt-3 rounded-xl bg-white px-4 py-3 text-center text-lg font-extrabold tracking-wide text-[#2D5016]"></div>
            <div class="mt-4 flex flex-col gap-2">
                <a id="orderTelegramBtn" href="#" target="_blank" rel="nofollow noopener noreferrer" aria-label="Написать в Telegram" class="flex items-center justify-center gap-2 rounded-full bg-[#0C6BAE] px-4 py-3 text-sm font-bold text-white transition-colors hover:bg-[#095985]"><i class="ri-telegram-line text-base" aria-hidden="true"></i>Написать в Telegram</a>
                <button id="newOrderBtn" type="button" class="rounded-full border border-[#2D5016] px-4 py-3 text-sm font-bold text-[#2D5016] transition-colors hover:bg-white">Новый заказ</button>
            </div>
        </div>
        <button id="clearCartBtn" class="w-full text-center text-xs text-[#B0B0B0] hover:text-[#E08080] transition-colors cursor-pointer py-1">Очистить корзину</button>
    </div>
</div>

<script>
(function () {
    'use strict';

    /* ─── Footer char count ─── */
    var fta = document.getElementById('footer-message');
    var fcc = document.getElementById('footerCharCount');
    if (fta && fcc) { fta.addEventListener('input', function () { fcc.textContent = fta.value.length + '/500'; }); }

    /* ─── Cart localStorage ─── */
    var STORAGE_KEY = 'fitahata_cart';
    var ORDER_KEY = 'fitahata_last_order';
    function getCart() { try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) || []; } catch(e) { return []; } }
    function saveCart(cart) { localStorage.setItem(STORAGE_KEY, JSON.stringify(cart)); }
    function getOrderConfirmation() { try { return JSON.parse(localStorage.getItem(ORDER_KEY)) || null; } catch(e) { return null; } }
    function saveOrderConfirmation(order) { localStorage.setItem(ORDER_KEY, JSON.stringify(order)); }
    function clearOrderConfirmation() { localStorage.removeItem(ORDER_KEY); }
    window.__fitahataCart = { getCart: getCart, saveCart: saveCart, addItem: addItem, refreshUI: refreshUI, clearOrderConfirmation: clearOrderConfirmation };

    function addItem(product, qty) {
        clearOrderConfirmation();
        var cart = getCart();
        var existing = cart.find(function(i){ return i.id === product.id; });
        if (existing) { existing.qty += qty; } else {
            cart.push({ id: product.id, slug: product.slug, name: product.name, price: product.price, priceDisplay: product.priceDisplay, image: product.image, weight: product.weight, qty: qty });
        }
        saveCart(cart); refreshUI();
    }
    function removeItem(id) { saveCart(getCart().filter(function(i){ return i.id !== id; })); refreshUI(); }
    function updateItemQty(id, newQty) { if(newQty<1){removeItem(id);return;} var cart=getCart(); var item=cart.find(function(i){return i.id===id;}); if(item){item.qty=newQty;saveCart(cart);} refreshUI(); }
    function clearCart(options) { saveCart([]); if (!options || !options.preserveConfirmation) { clearOrderConfirmation(); } refreshUI(); }
    function totalItems() { return getCart().reduce(function(s,i){return s+i.qty;},0); }
    function totalPrice() { return getCart().reduce(function(s,i){return s+i.price*i.qty;},0); }
    function formatPrice(n) { return n.toFixed(2).replace('.',',')+' BYN'; }
    function pluralize(n) { var m10=n%10,m100=n%100; if(m100>=11&&m100<=19)return n+' позиций'; if(m10===1)return n+' позиция'; if(m10>=2&&m10<=4)return n+' позиции'; return n+' позиций'; }
    function esc(s) { var d=document.createElement('div');d.textContent=s||'';return d.innerHTML; }
    function telegramOrderUrl() { return 'https://t.me/m93458'; }
    function setCheckoutError(message) {
        var errorEl = document.getElementById('checkoutError');
        if (!errorEl) return;
        errorEl.textContent = message || '';
        errorEl.classList.toggle('hidden', !message);
    }
    function setCheckoutLoading(isLoading) {
        var btn = document.getElementById('checkoutBtn');
        if (!btn) return;
        btn.disabled = isLoading;
        btn.classList.toggle('opacity-70', isLoading);
        btn.classList.toggle('cursor-not-allowed', isLoading);
    }
    function resetCheckoutForm() {
        var nameInput = document.getElementById('checkoutName');
        var phoneInput = document.getElementById('checkoutPhone');
        if (nameInput) nameInput.value = '';
        if (phoneInput) phoneInput.value = '';
        setCheckoutError('');
    }

    function refreshBadge() {
        var count = totalItems();
        var badge = document.getElementById('cartBadge');
        var badgeMob = document.getElementById('cartBadgeMobile');
        if(badge){badge.textContent=count;badge.classList.toggle('hidden',count===0);}
        if(badgeMob)badgeMob.textContent=count;
    }

    function renderCartPanel() {
        var cart = getCart();
        var confirmation = getOrderConfirmation();
        var container = document.getElementById('cartItems');
        var emptyEl = document.getElementById('cartEmpty');
        var footer = document.getElementById('cartFooter');
        var subtitle = document.getElementById('cartSubtitle');
        var totalEl = document.getElementById('cartTotal');
        if(!container)return;
        var existing = {};
        container.querySelectorAll('.cart-line').forEach(function(el){existing[el.dataset.cartItemId]=el;});
        if(cart.length===0 && !confirmation){Object.values(existing).forEach(function(el){el.remove();});if(emptyEl)emptyEl.style.display='';if(footer)footer.classList.add('hidden');if(subtitle)subtitle.textContent='Пусто';return;}
        if(emptyEl)emptyEl.style.display='none';if(footer)footer.classList.remove('hidden');if(subtitle)subtitle.textContent=confirmation ? 'Заказ оформлен' : pluralize(cart.length);if(totalEl)totalEl.textContent=formatPrice(confirmation ? 0 : totalPrice());
        var cartIds={};
        cart.forEach(function(item){
            cartIds[item.id]=true;var lineTotal=item.price*item.qty;var el=existing[item.id];
            if(el){var qtySpan=el.querySelector('.cart-line-qty');var totalSpan=el.querySelector('.cart-line-total');if(qtySpan)qtySpan.textContent=item.qty;if(totalSpan)totalSpan.textContent=formatPrice(lineTotal);}
            else{el=document.createElement('div');el.className='cart-line flex items-start gap-3 bg-[#FAFAF7] rounded-2xl p-3';el.dataset.cartItemId=item.id;el.innerHTML='<div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0"><img alt="'+esc(item.name)+'" class="w-full h-full object-cover object-top" src="'+esc(item.image)+'"></div><div class="flex-1 min-w-0"><div class="flex items-start justify-between gap-2"><div><p class="text-sm font-semibold text-[#1A1A1A] leading-tight">'+esc(item.name)+'</p>'+(item.weight?'<p class="text-xs text-[#5A5A5A] mt-0.5">'+esc(item.weight)+'</p>':'')+'</div><button data-remove="'+item.id+'" class="cart-remove w-6 h-6 flex items-center justify-center rounded-full hover:bg-[#F0E0E0] text-[#C08080] transition-colors cursor-pointer flex-shrink-0"><i class="ri-delete-bin-6-line text-xs"></i></button></div><div class="flex items-center justify-between mt-2"><div class="flex items-center gap-1 border border-[#E8E3D8] rounded-full bg-white overflow-hidden"><button data-cart-minus="'+item.id+'" class="w-6 h-6 flex items-center justify-center text-[#2D5016] hover:bg-[#F5F1E8] transition-colors cursor-pointer"><i class="ri-subtract-line text-xs"></i></button><span class="cart-line-qty text-xs font-bold text-[#1A1A1A] w-5 text-center">'+item.qty+'</span><button data-cart-plus="'+item.id+'" class="w-6 h-6 flex items-center justify-center text-[#2D5016] hover:bg-[#F5F1E8] transition-colors cursor-pointer"><i class="ri-add-line text-xs"></i></button></div><span class="cart-line-total text-sm font-bold text-[#2D5016]">'+formatPrice(lineTotal)+'</span></div></div>';container.appendChild(el);}
        });
        Object.keys(existing).forEach(function(id){if(!cartIds[id])existing[id].remove();});
    }

    function renderCheckoutState() {
        var confirmation = getOrderConfirmation();
        var formSection = document.getElementById('cartFormSection');
        var successSection = document.getElementById('cartSuccessSection');
        var orderNumberEl = document.getElementById('cartOrderNumber');
        var telegramBtn = document.getElementById('orderTelegramBtn');
        var clearBtn = document.getElementById('clearCartBtn');
        var hasCartItems = getCart().length > 0;

        if (formSection) formSection.classList.toggle('hidden', !!confirmation || !hasCartItems);
        if (successSection) successSection.classList.toggle('hidden', !confirmation);
        if (clearBtn) clearBtn.classList.toggle('hidden', !!confirmation || !hasCartItems);
        if (orderNumberEl) orderNumberEl.textContent = confirmation ? confirmation.orderNumber : '';
        if (telegramBtn && confirmation) telegramBtn.setAttribute('href', telegramOrderUrl());
        if (!confirmation) setCheckoutError('');
    }

    function refreshUI(){refreshBadge();renderCartPanel();renderCheckoutState();}

    function wireLeadForms() {
        var forms = document.querySelectorAll('[data-fitahata-form="true"]');
        if (!forms.length) return;

        function setFormStatus(form, message, isError) {
            var status = form.querySelector('[data-form-status]');
            if (!status) return;
            status.textContent = message || '';
            status.className = 'text-sm ' + (isError ? 'text-red-600' : 'text-green-600');
        }

        forms.forEach(function (form) {
            form.addEventListener('submit', async function (event) {
                event.preventDefault();

                var submitButton = form.querySelector('[type="submit"]');
                if (submitButton) submitButton.disabled = true;
                setFormStatus(form, '', false);

                try {
                    var formData = new FormData(form);
                    formData.append('form_type', form.getAttribute('data-form-type') || '');
                    formData.append('page_url', window.location.href);

                    var payload = Object.fromEntries(formData.entries());
                    var response = await fetch('{{ route('forms.submit') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    });
                    var result = await response.json();
                    if (!response.ok) {
                        throw new Error(result.message || 'Не удалось отправить форму.');
                    }

                    form.reset();
                    if (form.id === 'shopFooterForm') {
                        var footerCount = document.getElementById('footerCharCount');
                        if (footerCount) footerCount.textContent = '0/500';
                    }
                    setFormStatus(form, 'Сообщение отправлено в Telegram.', false);
                } catch (error) {
                    setFormStatus(form, error.message || 'Ошибка отправки.', true);
                } finally {
                    if (submitButton) submitButton.disabled = false;
                }
            });
        });
    }

    /* ─── Slide panels ─── */
    var overlay=document.getElementById('slideOverlay');var cartPanel=document.getElementById('cartPanel');var menuPanel=document.getElementById('mobileMenuPanel');var activePanel=null;
    function lockBodyScroll(){document.body.style.overflow='hidden';}
    function unlockBodyScroll(){document.body.style.overflow='';}
    function openPanel(p){if(activePanel)closePanel();activePanel=p;if(overlay)overlay.classList.add('open');if(p)p.classList.add('open');lockBodyScroll();}
    function closePanel(){if(overlay)overlay.classList.remove('open');if(activePanel)activePanel.classList.remove('open');activePanel=null;unlockBodyScroll();}
    function openCart(){openPanel(cartPanel);renderCartPanel();}

    document.getElementById('cartToggle').addEventListener('click',openCart);
    document.getElementById('cartToggleMobile').addEventListener('click',openCart);
    document.getElementById('cartClose').addEventListener('click',closePanel);
    document.getElementById('mobileMenuToggle').addEventListener('click',function(){openPanel(menuPanel);});
    document.getElementById('mobileMenuClose').addEventListener('click',closePanel);
    if(overlay)overlay.addEventListener('click',closePanel);

    document.getElementById('cartItems').addEventListener('click',function(e){
        var btn=e.target.closest('[data-remove]');if(btn){removeItem(Number(btn.dataset.remove));return;}
        var minus=e.target.closest('[data-cart-minus]');if(minus){var id=Number(minus.dataset.cartMinus);var item=getCart().find(function(i){return i.id===id;});if(item)updateItemQty(id,item.qty-1);return;}
        var plus=e.target.closest('[data-cart-plus]');if(plus){var id2=Number(plus.dataset.cartPlus);var item2=getCart().find(function(i){return i.id===id2;});if(item2)updateItemQty(id2,item2.qty+1);}
    });
    document.getElementById('clearCartBtn').addEventListener('click',function(){if(confirm('Очистить корзину?'))clearCart();});
    document.getElementById('checkoutBtn').addEventListener('click',async function(){
        var cart=getCart();if(!cart.length)return;
        var nameInput=document.getElementById('checkoutName');
        var phoneInput=document.getElementById('checkoutPhone');
        var customerName=nameInput ? nameInput.value.trim() : '';
        var customerPhone=phoneInput ? phoneInput.value.trim() : '';
        if(!customerName){setCheckoutError('Укажите имя.');if(nameInput)nameInput.focus();return;}
        if(!customerPhone){setCheckoutError('Укажите телефон.');if(phoneInput)phoneInput.focus();return;}
        setCheckoutLoading(true);
        setCheckoutError('');
        try {
            var response = await fetch('{{ route('orders.place') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    customer_name: customerName,
                    customer_phone: customerPhone,
                    items: cart.map(function(item){
                        return {
                            id: item.id,
                            name: item.name,
                            price: item.price,
                            qty: item.qty,
                            weight: item.weight || null
                        };
                    })
                })
            });
            var payload = await response.json();
            if (!response.ok) {
                var message = payload && payload.message ? payload.message : 'Не удалось оформить заказ.';
                if (payload && payload.errors) {
                    var firstErrorKey = Object.keys(payload.errors)[0];
                    if (firstErrorKey && payload.errors[firstErrorKey] && payload.errors[firstErrorKey][0]) {
                        message = payload.errors[firstErrorKey][0];
                    }
                }
                setCheckoutError(message);
                return;
            }
            saveOrderConfirmation({ orderNumber: payload.order_number });
            clearCart({ preserveConfirmation: true });
            resetCheckoutForm();
        } catch (error) {
            setCheckoutError('Не удалось отправить заказ. Попробуйте ещё раз.');
        } finally {
            setCheckoutLoading(false);
            refreshUI();
        }
    });
    document.getElementById('newOrderBtn').addEventListener('click', function () {
        clearCart();
        resetCheckoutForm();
    });
    document.addEventListener('keydown',function(e){if(e.key==='Escape')closePanel();});
    wireLeadForms();
    refreshUI();
})();
</script>
@stack('scripts')
</body>
</html>
