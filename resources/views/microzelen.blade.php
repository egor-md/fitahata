@extends('layouts.shop')

@section('title', $plant->meta_title ?? ($plant->name . ' — FITAHATA'))
@section('meta_description', $plant->meta_description ?? '')

@section('content')
    @php
        $primaryImg = $plant->images->firstWhere('is_primary') ?? $plant->images->first();
        $primarySrc = $primaryImg?->url ?? '/images/catalog/placeholder.webp';
        $primarySrcset = \App\Support\ImageVariants::squareSrcset($primarySrc, [160, 300, 640]);
        $primaryDetailSrc = \App\Support\ImageVariants::squareVariantUrl($primarySrc, 640)
            ?? \App\Support\ImageVariants::squareVariantUrl($primarySrc, 300)
            ?? $primarySrc;
        $primaryCardSrc = \App\Support\ImageVariants::squareVariantUrl($primarySrc, 300) ?? $primarySrc;
    @endphp
    {{-- Продукт --}}
    <section id="productSection"
        data-id="{{ $plant->id }}"
        data-name="{{ $plant->name }}"
        data-slug="{{ $plant->slug }}"
        data-price="{{ (float) $plant->price }}"
        data-price-display="{{ number_format((float) $plant->price, 2, ',', ' ') }} BYN"
        data-image="{{ $primaryCardSrc }}"
        data-weight="{{ $plant->price_unit_label }}"
        class="pt-24 sm:pt-24 lg:pt-24 pb-16 bg-[#FAFAF7]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                {{-- Media --}}
                <div>
                    <div class="relative rounded-3xl overflow-hidden bg-white aspect-square">
                        <img id="productMainImg" class="w-full h-full object-cover object-top" src="{{ $primaryDetailSrc }}"
                            @if ($primarySrcset) srcset="{{ $primarySrcset }}" sizes="(min-width: 1024px) min(640px, 50vw), 100vw" @endif
                            alt="{{ $plant->name }}" width="640" height="640" fetchpriority="high" decoding="async">
                        @if ($plant->is_bestseller)
                            <span class="absolute top-4 left-4 inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-[#2D5016] text-white text-xs font-bold">Хит продаж</span>
                        @endif
                        @if ($plant->rating !== null)
                            <div class="absolute bottom-4 right-4 inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-white/90 backdrop-blur text-sm font-semibold shadow">
                                <span class="text-[#E8C547]" aria-hidden="true"><i class="ri-star-fill"></i></span>
                                <span class="text-[#1A1A1A]">{{ number_format((float) $plant->rating, 1, ',', '') }}</span>
                                <span class="text-[#5C5F58]">({{ $plant->reviews_count }})</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex gap-3 mt-4" role="group" aria-label="Галерея фото">
                        @foreach ($plant->images as $img)
                            @php
                                $thumbSrc = \App\Support\ImageVariants::squareVariantUrl($img->url, 160) ?? ($img->url ?? '');
                                $detailSrc = \App\Support\ImageVariants::squareVariantUrl($img->url, 640)
                                    ?? \App\Support\ImageVariants::squareVariantUrl($img->url, 300)
                                    ?? $thumbSrc;
                                $detailSrcset = \App\Support\ImageVariants::squareSrcset($img->url, [160, 300, 640]);
                            @endphp
                            <button type="button"
                                class="product-thumb w-20 h-20 p-0 border-2 rounded-xl overflow-hidden cursor-pointer bg-white flex-shrink-0 hover:border-[#C5D9B0] transition-colors {{ $img->url === $primarySrc ? 'product-thumb-active border-[#2D5016]' : 'border-transparent' }}"
                                data-full-src="{{ $detailSrc }}"
                                data-full-srcset="{{ $detailSrcset }}"
                                aria-label="Фото {{ $loop->iteration }}">
                                <img class="w-full h-full object-cover object-top" src="{{ $thumbSrc }}" alt="" width="80" height="80" loading="lazy">
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Info --}}
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        @if ($plant->category_label)
                            <span class="text-xs font-semibold uppercase tracking-wider text-[#5A6B4A]">{{ $plant->category_label }}</span>
                        @endif
                        @if ($plant->sku)
                            <span class="text-xs text-[#5C5F58]">{{ $plant->sku }}</span>
                        @endif
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1A1A1A] leading-tight mb-3">
                        {{ $plant->name }}@if ($plant->subtitle)<br>
                            <span class="text-lg sm:text-xl font-semibold text-[#5A6B4A]">{{ $plant->subtitle }}</span>
                        @endif
                    </h1>
                    @if ($plant->rating !== null)
                        <div class="flex items-center gap-2 mb-4">
                            <span class="flex items-center gap-0.5 text-[#E8C547]" aria-hidden="true">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="ri-star-fill"></i>
                                @endfor
                            </span>
                            <span class="text-sm text-[#5A6B4A]">{{ number_format((float) $plant->rating, 1, ',', '') }}
                                — {{ $plant->reviews_count }} отзывов</span>
                        </div>
                    @endif
                    <div class="text-sm leading-relaxed text-[#4A5A3A] mb-5">
                        {!! nl2br(e((string) $plant->description)) !!}
                        @if ($plant->dishes_text)
                            {!! nl2br(e((string) $plant->dishes_text)) !!}
                        @endif
                    </div>
                    @if ($plant->tags->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mb-5">
                            @foreach ($plant->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#E8F0E0] text-xs font-medium text-[#2D5016]">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif
                    @if (is_array($plant->facts) && count($plant->facts))
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
                            @foreach ($plant->facts as $fact)
                                <div class="flex flex-col items-center text-center p-3 rounded-2xl bg-[#F5F1E8]">
                                    <span class="text-xl text-[#2D5016] mb-1" aria-hidden="true"><i
                                            class="{{ $fact['icon'] ?? 'ri-seedling-line' }}"></i></span>
                                    <div class="text-sm font-bold text-[#1A1A1A]">{{ $fact['title'] ?? '' }}</div>
                                    <div class="text-xs text-[#5A6B4A]">{{ $fact['sub'] ?? '' }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="bg-white border border-[#EDE8DC] rounded-2xl p-5">
                        <div class="flex items-end justify-between mb-4">
                            <div>
                                <div class="text-2xl font-extrabold text-[#1A1A1A]">
                                    {{ number_format((float) $plant->price, 2, ',', ' ') }} BYN</div>
                                <div class="text-xs text-[#5C5F58] mt-0.5">{{ $plant->price_unit_label }}</div>
                            </div>
                            @if ($plant->compare_at_price !== null)
                                <div class="flex items-center gap-2">
                                    <div class="text-sm line-through text-[#5C5F58]">
                                        {{ number_format((float) $plant->compare_at_price, 2, ',', ' ') }} BYN</div>
                                    @if ($plant->discount_label)
                                        @php
                                            $discountValue = trim((string) $plant->discount_label);
                                            $discountColors = match ($discountValue) {
                                                'Хит' => 'bg-[#FEF3C7] text-[#B45309]',
                                                'Новинка' => 'bg-[#DBEAFE] text-[#1D4ED8]',
                                                'Выгода' => 'bg-[#D1FAE5] text-[#065F46]',
                                                default => 'bg-[#E8F0E0] text-[#2D5016]',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold {{ $discountColors }}">{{ $plant->discount_label }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center border border-[#E8E3D8] rounded-full overflow-hidden" role="group" aria-label="Количество">
                                <button type="button" id="qtyMinus" class="w-10 h-10 flex items-center justify-center text-[#2D5016] hover:bg-[#F5F1E8] transition-colors cursor-pointer" aria-label="Уменьшить"><i
                                        class="ri-subtract-line"></i></button>
                                <span id="qtyValue" class="w-10 text-center text-sm font-bold text-[#1A1A1A]">1</span>
                                <button type="button" id="qtyPlus" class="w-10 h-10 flex items-center justify-center text-[#2D5016] hover:bg-[#F5F1E8] transition-colors cursor-pointer" aria-label="Увеличить"><i
                                        class="ri-add-line"></i></button>
                            </div>
                            <button type="button" id="addToCartBtn" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-full bg-[#2D5016] text-white text-sm font-bold hover:bg-[#1A3A0F] transition-colors cursor-pointer">
                                <span aria-hidden="true"><i class="ri-shopping-cart-2-line"></i></span>
                                В корзину
                            </button>
                        </div>
                        <p class="flex items-center gap-2 text-xs text-[#5A6B4A] mt-3">
                            <span aria-hidden="true"><i class="ri-truck-line"></i></span>
                            Доставка по Гомелю
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.microzelen_nutrition')

    @if ($plant->recipes->isNotEmpty())
        {{-- Рецепты --}}
        <section class="py-20 bg-[#F5F1E8]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
                <header class="text-center mb-12">
                    @if ($plant->recipes_section_pill)
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-[#2D5016]/10 text-[#2D5016] text-xs font-bold uppercase tracking-wider mb-4">{{ $plant->recipes_section_pill }}</span>
                    @endif
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1A1A1A] mb-3">{{ $plant->recipes_section_title }}</h2>
                    <p class="text-sm sm:text-base text-[#5A6B4A] max-w-2xl mx-auto">{{ $plant->recipes_section_lead }}</p>
                </header>
                <div class="relative">
                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-500 ease-in-out" id="test-card-recipe-track">
                            @foreach ($plant->recipes as $recipe)
                                <div class="recipe-slide w-full flex-shrink-0 px-1">
                                    <div class="grid grid-cols-1 lg:grid-cols-2 rounded-3xl overflow-hidden bg-white">
                                        <div class="relative overflow-hidden aspect-[4/3]">
                                            <img class="w-full h-full object-cover" src="{{ $recipe->image_url }}"
                                                alt="{{ $recipe->title }}" width="800" height="600" loading="lazy">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent" aria-hidden="true"></div>
                                            @if ($recipe->tag_top)
                                                <span class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full bg-white/90 backdrop-blur text-xs font-bold text-[#1A1A1A]">{{ $recipe->tag_top }}</span>
                                            @endif
                                            @if ($recipe->tag_bottom)
                                                <span class="absolute bottom-4 left-4 inline-flex items-center px-3 py-1 rounded-full bg-white/90 backdrop-blur text-xs font-bold text-[#1A1A1A]">{{ $recipe->tag_bottom }}</span>
                                            @endif
                                        </div>
                                        <div class="p-6 sm:p-8 flex flex-col">
                                            <div class="flex items-center flex-wrap gap-3 mb-3">
                                                @if ($recipe->time_label)
                                                    <span class="inline-flex items-center gap-1 text-xs text-[#5A6B4A]"><i class="ri-time-line" aria-hidden="true"></i> {{ $recipe->time_label }}</span>
                                                @endif
                                                @if ($recipe->calories_label)
                                                    <span class="w-1 h-1 rounded-full bg-[#C5D9B0]" aria-hidden="true"></span>
                                                    <span class="inline-flex items-center gap-1 text-xs text-[#5A6B4A]"><i class="ri-fire-line" aria-hidden="true"></i> {{ $recipe->calories_label }}</span>
                                                @endif
                                                @if ($recipe->difficulty_label)
                                                    <span class="w-1 h-1 rounded-full bg-[#C5D9B0]" aria-hidden="true"></span>
                                                    <span class="inline-flex items-center gap-1 text-xs text-[#5A6B4A]"><i class="ri-bar-chart-line" aria-hidden="true"></i> {{ $recipe->difficulty_label }}</span>
                                                @endif
                                            </div>
                                            <h3 class="text-xl font-bold text-[#1A1A1A] mb-2">{{ $recipe->title }}</h3>
                                            <p class="text-sm text-[#4A5A3A] leading-relaxed mb-4">
                                                @if ($recipe->excerpt)
                                                    {{ $recipe->excerpt }}
                                                @else
                                                    {!! nl2br(e($recipe->body)) !!}
                                                @endif
                                            </p>
                                            @if (is_array($recipe->ingredients) && count($recipe->ingredients))
                                                <h4 class="text-sm font-bold text-[#1A1A1A] mb-2">Ингредиенты</h4>
                                                <ul class="flex flex-col gap-1 mb-4">
                                                    @foreach ($recipe->ingredients as $line)
                                                        <li class="flex items-center gap-2 text-sm text-[#4A5A3A]"><i class="ri-leaf-line text-[#4A7C2A]" aria-hidden="true"></i>
                                                            {{ $line }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                            @if ($recipe->cta_label)
                                                <div class="mt-auto pt-2">
                                                    <a class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#2D5016] text-white text-sm font-bold hover:bg-[#1A3A0F] transition-colors"
                                                        href="{{ $recipe->cta_url ?: route('home') . '#catalog' }}">
                                                        <i class="ri-shopping-basket-line" aria-hidden="true"></i>
                                                        {{ $recipe->cta_label }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6 mt-6">
                        <div class="flex items-center gap-1 sm:gap-2" id="test-card-recipe-dots" role="group"
                            aria-label="Выбор рецепта">
                            @foreach ($plant->recipes as $recipe)
                                <button type="button"
                                    class="recipe-dot-btn inline-flex h-11 min-h-[44px] w-11 min-w-[44px] shrink-0 cursor-pointer items-center justify-center rounded-full bg-transparent p-0 touch-manipulation transition-colors duration-300 {{ $loop->first ? 'recipe-dot-active' : '' }}"
                                    data-recipe-index="{{ $loop->index }}"
                                    aria-label="Рецепт {{ $loop->iteration }} из {{ $plant->recipes->count() }}"
                                    @if ($loop->first) aria-current="true" @endif>
                                    <span class="recipe-dot-btn-inner block h-2.5 rounded-full transition-all duration-300 {{ $loop->first ? 'w-8 bg-[#2D5016]' : 'w-2.5 bg-[#C5D9B0]' }}" aria-hidden="true"></span>
                                </button>
                            @endforeach
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" class="w-10 h-10 flex items-center justify-center rounded-full border border-[#E8E3D8] bg-white text-[#2D5016] hover:bg-[#F5F1E8] transition-colors cursor-pointer" id="test-card-recipe-prev"
                                aria-label="Предыдущий рецепт"><i class="ri-arrow-left-line"></i></button>
                            <button type="button" class="w-10 h-10 flex items-center justify-center rounded-full border border-[#E8E3D8] bg-white text-[#2D5016] hover:bg-[#F5F1E8] transition-colors cursor-pointer" id="test-card-recipe-next"
                                aria-label="Следующий рецепт"><i class="ri-arrow-right-line"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @include('partials.shop-subscription-block', [
        'subscriptionTitle' => 'Подписка на доставку '.$plant->name,
        'subscriptionLead' => 'Получайте свежую микрозелень по расписанию — со скидкой до 15% и приоритетной доставкой',
        'subscriptionProduct' => $plant->name.' FITAHATA',
    ])

    <section class="py-16 bg-[#F5F1E8] text-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
            <h3 class="text-xl sm:text-2xl font-extrabold text-[#1A1A1A] mb-3">Хотите попробовать другие культуры?</h3>
            <p class="text-sm sm:text-base text-[#5A6B4A] max-w-xl mx-auto mb-6">В нашем каталоге — 20 культур свежей микрозелени с доставкой по Гомелю</p>
            <div class="flex flex-wrap items-center justify-center gap-3">
                <a class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#2D5016] text-white text-sm font-bold hover:bg-[#1A3A0F] transition-colors" href="{{ route('home') }}#catalog">
                    <i class="ri-apps-2-line" aria-hidden="true"></i> Весь каталог
                </a>
                <a class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-[#2D5016] text-[#2D5016] text-sm font-bold hover:bg-[#2D5016] hover:text-white transition-colors" href="{{ route('contacts') }}">Написать нам</a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (function () {
            var main = document.getElementById('productMainImg');
            var thumbs = document.querySelectorAll('.product-thumb');
            if (main && thumbs.length) {
                thumbs.forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        var src = btn.getAttribute('data-full-src');
                        var srcset = btn.getAttribute('data-full-srcset');
                        if (src) main.src = src;
                        if (srcset) main.setAttribute('srcset', srcset);
                        else main.removeAttribute('srcset');
                        thumbs.forEach(function (b) {
                            b.classList.remove('product-thumb-active', 'border-[#2D5016]');
                            b.classList.add('border-transparent');
                        });
                        btn.classList.remove('border-transparent');
                        btn.classList.add('product-thumb-active', 'border-[#2D5016]');
                    });
                });
            }

            var tablist = document.querySelector('[role="tablist"][aria-label="Разделы питательности"]');
            if (tablist) {
                var tabs = tablist.querySelectorAll('[data-nutrition-panel]');
                var panels = {};
                tabs.forEach(function (t) {
                    var key = t.getAttribute('data-nutrition-panel');
                    if (key) panels[key] = document.getElementById('nutrition-panel-' + key);
                });

                function parseTargetWidth(el) {
                    var s = el.getAttribute('style') || '';
                    var m = s.match(/width\s*:\s*([^;]+)/i);
                    return (m && m[1] ? m[1].trim() : '') || '100%';
                }

                function ensureTargets(panel) {
                    panel.querySelectorAll('.nutrition-fill').forEach(function (el) {
                        if (!el.dataset.targetWidth) el.dataset.targetWidth = parseTargetWidth(el);
                    });
                }

                function resetBars(panel) {
                    if (!panel) return;
                    ensureTargets(panel);
                    panel.querySelectorAll('.nutrition-fill').forEach(function (el) {
                        el.style.transition = 'none';
                        el.style.width = '0%';
                        el.style.opacity = '0.35';
                        void el.offsetWidth;
                        el.style.transition = '';
                    });
                }

                function animateNutritionBars(panel) {
                    if (!panel) return;
                    ensureTargets(panel);
                    var fills = panel.querySelectorAll('.nutrition-fill');
                    fills.forEach(function (el, i) {
                        var target = el.dataset.targetWidth || parseTargetWidth(el);
                        el.dataset.targetWidth = target;
                        el.style.transition = 'none';
                        el.style.width = '0%';
                        el.style.opacity = '0.4';
                        void el.offsetWidth;
                        el.style.transition = '';
                        window.setTimeout(function () {
                            el.style.width = target;
                            el.style.opacity = '1';
                        }, 30 + i * 70);
                    });
                }

                var activeTabClasses = ['bg-[#2D5016]', 'text-white'];
                var inactiveTabClasses = ['bg-[#FAFAF7]', 'text-[#4A4A4A]', 'hover:bg-[#F0EDE4]'];

                function activate(key) {
                    tabs.forEach(function (tab) {
                        var k = tab.getAttribute('data-nutrition-panel');
                        var on = k === key;
                        tab.classList.toggle('nutrition-tab-active', on);
                        if (on) {
                            inactiveTabClasses.forEach(function (c) { tab.classList.remove(c); });
                            activeTabClasses.forEach(function (c) { tab.classList.add(c); });
                        } else {
                            activeTabClasses.forEach(function (c) { tab.classList.remove(c); });
                            inactiveTabClasses.forEach(function (c) { tab.classList.add(c); });
                        }
                        tab.setAttribute('aria-selected', on ? 'true' : 'false');
                        if (!panels[k]) return;
                        if (on) {
                            panels[k].removeAttribute('hidden');
                            animateNutritionBars(panels[k]);
                        } else {
                            panels[k].setAttribute('hidden', '');
                            resetBars(panels[k]);
                        }
                    });
                }

                tabs.forEach(function (tab) {
                    tab.addEventListener('click', function () {
                        var key = tab.getAttribute('data-nutrition-panel');
                        if (key) activate(key);
                    });
                });

                var wrap = document.getElementById('nutritionPanelWrap');
                var firstKey = tabs[0] && tabs[0].getAttribute('data-nutrition-panel');
                var firstPanel = firstKey ? panels[firstKey] : null;
                if (wrap && firstPanel) {
                    ensureTargets(firstPanel);
                    firstPanel.querySelectorAll('.nutrition-fill').forEach(function (el) {
                        el.style.transition = 'none';
                        el.style.width = '0%';
                        el.style.opacity = '0.4';
                    });
                    wrap.removeAttribute('data-nutrition-preload');
                    void wrap.offsetWidth;
                    firstPanel.querySelectorAll('.nutrition-fill').forEach(function (el) {
                        el.style.transition = '';
                    });
                    animateNutritionBars(firstPanel);
                }
            }

            var track = document.getElementById('test-card-recipe-track');
            var dotsWrap = document.getElementById('test-card-recipe-dots');
            var btnPrev = document.getElementById('test-card-recipe-prev');
            var btnNext = document.getElementById('test-card-recipe-next');
            if (track && dotsWrap && btnPrev && btnNext) {
                var slides = track.querySelectorAll('.recipe-slide');
                var n = slides.length;
                if (n > 0) {
                    var idx = 0;
                    var dotBtns = dotsWrap.querySelectorAll('.recipe-dot-btn');

                    function go(i) {
                        idx = (i + n) % n;
                        track.style.transform = 'translateX(-' + (idx * 100) + '%)';
                        dotBtns.forEach(function (d, j) {
                            var on = j === idx;
                            var inner = d.querySelector('.recipe-dot-btn-inner');
                            d.classList.toggle('recipe-dot-active', on);
                            if (on) {
                                d.setAttribute('aria-current', 'true');
                            } else {
                                d.removeAttribute('aria-current');
                            }
                            if (inner) {
                                inner.classList.toggle('w-8', on);
                                inner.classList.toggle('w-2.5', !on);
                                inner.classList.toggle('bg-[#2D5016]', on);
                                inner.classList.toggle('bg-[#C5D9B0]', !on);
                            }
                        });
                    }

                    btnPrev.addEventListener('click', function () { go(idx - 1); });
                    btnNext.addEventListener('click', function () { go(idx + 1); });
                    dotBtns.forEach(function (d) {
                        d.addEventListener('click', function () {
                            var j = parseInt(d.getAttribute('data-recipe-index'), 10);
                            if (!isNaN(j)) go(j);
                        });
                    });
                    go(0);
                }
            }

            var qtyVal = document.getElementById('qtyValue');
            var qtyMinus = document.getElementById('qtyMinus');
            var qtyPlus = document.getElementById('qtyPlus');
            var addToCartBtn = document.getElementById('addToCartBtn');
            var productSection = document.getElementById('productSection');

            if (qtyMinus && qtyPlus && qtyVal) {
                qtyMinus.addEventListener('click', function () {
                    var v = parseInt(qtyVal.textContent, 10);
                    if (v > 1) qtyVal.textContent = v - 1;
                });
                qtyPlus.addEventListener('click', function () {
                    var v = parseInt(qtyVal.textContent, 10);
                    qtyVal.textContent = v + 1;
                });
            }

            if (addToCartBtn && productSection && window.__fitahataCart) {
                addToCartBtn.addEventListener('click', function () {
                    var qty = parseInt(qtyVal.textContent, 10) || 1;
                    var product = {
                        id: Number(productSection.dataset.id),
                        name: productSection.dataset.name,
                        slug: productSection.dataset.slug,
                        price: parseFloat(productSection.dataset.price),
                        priceDisplay: productSection.dataset.priceDisplay,
                        image: productSection.dataset.image,
                        weight: productSection.dataset.weight
                    };
                    window.__fitahataCart.addItem(product, qty);
                    addToCartBtn.classList.add('card-add-pulse');
                    setTimeout(function () { addToCartBtn.classList.remove('card-add-pulse'); }, 400);
                });
            }

        })();
    </script>
@endpush
