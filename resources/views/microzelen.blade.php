@extends('layouts.site')

@section('title', $plant->meta_title ?? ($plant->name . ' — FITAHATA'))
@section('meta_description', $plant->meta_description ?? '')

@section('content')
    @php
        $primaryImg = $plant->images->firstWhere('is_primary') ?? $plant->images->first();
        $primarySrc = $primaryImg?->url ?? '/images/test-card/phero3.jpg';
    @endphp
    {{-- Продукт --}}
    <section class="test-card-product">
        <div class="site-container test-card-product__inner">
            <div class="test-card-product__grid">
                <div class="test-card-product__media">
                    <div class="test-card-product__stage">
                        <img class="test-card-product__main-img" src="{{ $primarySrc }}"
                            alt="{{ $plant->name }}" width="800" height="800">
                        @if ($plant->is_bestseller)
                            <span class="test-card-product__hit">Хит продаж</span>
                        @endif
                        @if ($plant->rating !== null)
                            <div class="test-card-product__rating-pill">
                                <span class="test-card-product__rating-pill-star" aria-hidden="true"><i
                                        class="ri-star-fill"></i></span>
                                <span class="test-card-product__rating-pill-score">{{ number_format((float) $plant->rating, 1, ',', '') }}</span>
                                <span class="test-card-product__rating-pill-count">({{ $plant->reviews_count }})</span>
                            </div>
                        @endif
                    </div>
                    <div class="test-card-product__thumbs" role="group" aria-label="Галерея фото">
                        @foreach ($plant->images as $img)
                            <button type="button"
                                class="test-card-product__thumb {{ $img->url === $primarySrc ? 'test-card-product__thumb--active' : '' }}"
                                data-full-src="{{ $img->url }}"
                                aria-label="Фото {{ $loop->iteration }}">
                                <img src="{{ $img->url }}" alt="" width="80" height="80">
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="test-card-product__info">
                    <div class="test-card-product__meta">
                        @if ($plant->category_label)
                            <span class="test-card-product__cat">{{ $plant->category_label }}</span>
                        @endif
                        @if ($plant->sku)
                            <span class="test-card-product__sku">{{ $plant->sku }}</span>
                        @endif
                    </div>
                    <h1 class="test-card-product__title">
                        {{ $plant->name }}@if ($plant->subtitle)<br>
                            <span class="test-card-product__title-sub">{{ $plant->subtitle }}</span>
                        @endif
                    </h1>
                    @if ($plant->rating !== null)
                        <div class="test-card-product__stars-row">
                            <span class="test-card-product__stars" aria-hidden="true">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="ri-star-fill"></i>
                                @endfor
                            </span>
                            <span class="test-card-product__reviews">{{ number_format((float) $plant->rating, 1, ',', '') }}
                                — {{ $plant->reviews_count }} отзывов</span>
                        </div>
                    @endif
                    <div class="test-card-product__desc">
                        {!! $plant->description !!}
                        @if ($plant->dishes_text)
                            {!! $plant->dishes_text !!}
                        @endif
                    </div>
                    @if ($plant->tags->isNotEmpty())
                        <div class="test-card-product__tags">
                            @foreach ($plant->tags as $tag)
                                <span class="test-card-product__tag">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif
                    @if (is_array($plant->facts) && count($plant->facts))
                        <div class="test-card-product__facts">
                            @foreach ($plant->facts as $fact)
                                <div class="test-card-product__fact">
                                    <span class="test-card-product__fact-icon" aria-hidden="true"><i
                                            class="{{ $fact['icon'] ?? 'ri-seedling-line' }}"></i></span>
                                    <div class="test-card-product__fact-title">{{ $fact['title'] ?? '' }}</div>
                                    <div class="test-card-product__fact-sub">{{ $fact['sub'] ?? '' }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="test-card-product__buy">
                        <div class="test-card-product__buy-top">
                            <div>
                                <div class="test-card-product__price">
                                    {{ number_format((float) $plant->price, 2, ',', ' ') }} BYN</div>
                                <div class="test-card-product__price-unit">{{ $plant->price_unit_label }}</div>
                            </div>
                            @if ($plant->compare_at_price !== null)
                                <div class="test-card-product__price-old-wrap">
                                    <div class="test-card-product__price-was">
                                        {{ number_format((float) $plant->compare_at_price, 2, ',', ' ') }} BYN</div>
                                    @if ($plant->discount_label)
                                        <span class="test-card-product__discount">{{ $plant->discount_label }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="test-card-product__buy-row">
                            <div class="test-card-product__qty" role="group" aria-label="Количество">
                                <button type="button" class="test-card-product__qty-btn" aria-label="Уменьшить"><i
                                        class="ri-subtract-line"></i></button>
                                <span class="test-card-product__qty-val">10</span>
                                <button type="button" class="test-card-product__qty-btn" aria-label="Увеличить"><i
                                        class="ri-add-line"></i></button>
                            </div>
                            <button type="button" class="test-card-product__cart-btn">
                                <span aria-hidden="true"><i class="ri-shopping-cart-2-line"></i></span>
                                В корзину
                            </button>
                        </div>
                        <p class="test-card-product__delivery">
                            <span aria-hidden="true"><i class="ri-truck-line"></i></span>
                            Доставка по Гомелю — сегодня или завтра утром
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.microzelen_nutrition')

    @if ($plant->recipes->isNotEmpty())
        {{-- Рецепты --}}
        <section class="test-card-recipe">
            <div class="site-container">
                <header class="test-card-section-head">
                    @if ($plant->recipes_section_pill)
                        <span class="test-card-pill">{{ $plant->recipes_section_pill }}</span>
                    @endif
                    <h2 class="test-card-section-head__title">{{ $plant->recipes_section_title }}</h2>
                    <p class="test-card-section-head__text">{{ $plant->recipes_section_lead }}</p>
                </header>
                <div class="test-card-recipe__wrap">
                    <div class="test-card-recipe__viewport">
                        <div class="test-card-recipe__track" id="test-card-recipe-track">
                            @foreach ($plant->recipes as $recipe)
                                <div class="test-card-recipe__slide">
                                    <div class="test-card-recipe__card">
                                        <div class="test-card-recipe__media">
                                            <img src="{{ $recipe->image_url }}"
                                                alt="{{ $recipe->title }}" width="800" height="600">
                                            <div class="test-card-recipe__grad" aria-hidden="true"></div>
                                            @if ($recipe->tag_top)
                                                <span
                                                    class="test-card-recipe__tag test-card-recipe__tag--top">{{ $recipe->tag_top }}</span>
                                            @endif
                                            @if ($recipe->tag_bottom)
                                                <span
                                                    class="test-card-recipe__tag test-card-recipe__tag--bottom">{{ $recipe->tag_bottom }}</span>
                                            @endif
                                        </div>
                                        <div class="test-card-recipe__body">
                                            <div class="test-card-recipe__meta-row">
                                                @if ($recipe->time_label)
                                                    <span class="test-card-recipe__meta"><i class="ri-time-line"
                                                            aria-hidden="true"></i> {{ $recipe->time_label }}</span>
                                                @endif
                                                @if ($recipe->calories_label)
                                                    <span class="test-card-recipe__dot" aria-hidden="true"></span>
                                                    <span class="test-card-recipe__meta"><i class="ri-fire-line"
                                                            aria-hidden="true"></i> {{ $recipe->calories_label }}</span>
                                                @endif
                                                @if ($recipe->difficulty_label)
                                                    <span class="test-card-recipe__dot" aria-hidden="true"></span>
                                                    <span class="test-card-recipe__meta"><i class="ri-bar-chart-line"
                                                            aria-hidden="true"></i> {{ $recipe->difficulty_label }}</span>
                                                @endif
                                            </div>
                                            <h3 class="test-card-recipe__name">{{ $recipe->title }}</h3>
                                            <p class="test-card-recipe__text">
                                                @if ($recipe->excerpt)
                                                    {{ $recipe->excerpt }}
                                                @else
                                                    {!! nl2br(e($recipe->body)) !!}
                                                @endif
                                            </p>
                                            @if (is_array($recipe->ingredients) && count($recipe->ingredients))
                                                <h4 class="test-card-recipe__ing-title">Ингредиенты</h4>
                                                <ul class="test-card-recipe__ing">
                                                    @foreach ($recipe->ingredients as $line)
                                                        <li><i class="ri-leaf-line" aria-hidden="true"></i>
                                                            {{ $line }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                            @if ($recipe->cta_label)
                                                <div class="test-card-recipe__actions">
                                                    <a class="test-card-recipe__btn"
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
                    <div class="test-card-recipe__nav">
                        <div class="test-card-recipe__dots" id="test-card-recipe-dots" role="tablist"
                            aria-label="Рецепты">
                            @foreach ($plant->recipes as $recipe)
                                <button type="button"
                                    class="test-card-recipe__dot-btn {{ $loop->first ? 'test-card-recipe__dot-btn--active' : '' }}"
                                    data-recipe-index="{{ $loop->index }}"
                                    aria-label="Рецепт {{ $loop->iteration }}"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"></button>
                            @endforeach
                        </div>
                        <div class="test-card-recipe__arrows">
                            <button type="button" class="test-card-recipe__arrow" id="test-card-recipe-prev"
                                aria-label="Предыдущий рецепт"><i class="ri-arrow-left-line"></i></button>
                            <button type="button" class="test-card-recipe__arrow" id="test-card-recipe-next"
                                aria-label="Следующий рецепт"><i class="ri-arrow-right-line"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Подписка --}}
    <section id="subscription" class="test-card-sub">
        <div class="site-container">
            <header class="test-card-section-head">
                <span class="test-card-pill">Постоянным покупателям</span>
                <h2 class="test-card-section-head__title">Подписка на доставку {{ $plant->name }}</h2>
                <p class="test-card-section-head__text">Получайте свежую микрозелень по расписанию — со скидкой до 15% и
                    приоритетной доставкой</p>
            </header>
            <div class="test-card-sub__grid">
                <div class="test-card-sub__left">
                    <div class="test-card-sub__period">
                        <h3 class="test-card-sub__period-title">Выберите периодичность</h3>
                        <button type="button" class="test-card-sub__option">
                            <span class="test-card-sub__radio" aria-hidden="true"></span>
                            <span class="test-card-sub__option-text">
                                <span class="test-card-sub__option-name">Каждую неделю</span>
                                <span class="test-card-sub__option-hint">1 раз в неделю</span>
                            </span>
                            <span class="test-card-sub__option-badges">
                                <span class="test-card-sub__badge-pop">Популярно</span>
                                <span class="test-card-sub__badge-pct">−15%</span>
                            </span>
                        </button>
                        <button type="button" class="test-card-sub__option test-card-sub__option--selected">
                            <span class="test-card-sub__radio test-card-sub__radio--on" aria-hidden="true"><span></span></span>
                            <span class="test-card-sub__option-text">
                                <span class="test-card-sub__option-name">Раз в 2 недели</span>
                                <span class="test-card-sub__option-hint">2 раза в месяц</span>
                            </span>
                            <span class="test-card-sub__badge-pct">−10%</span>
                        </button>
                        <button type="button" class="test-card-sub__option">
                            <span class="test-card-sub__radio" aria-hidden="true"></span>
                            <span class="test-card-sub__option-text">
                                <span class="test-card-sub__option-name">Раз в месяц</span>
                                <span class="test-card-sub__option-hint">1 раз в месяц</span>
                            </span>
                            <span class="test-card-sub__badge-pct">−5%</span>
                        </button>
                    </div>
                    <div class="test-card-sub__features">
                        <div class="test-card-sub__feat">
                            <span class="test-card-sub__feat-icon" aria-hidden="true"><i class="ri-calendar-check-line"></i></span>
                            <div class="test-card-sub__feat-title">Регулярные поставки</div>
                            <p class="test-card-sub__feat-text">Без лишних заказов и звонков — всё по расписанию</p>
                        </div>
                        <div class="test-card-sub__feat">
                            <span class="test-card-sub__feat-icon" aria-hidden="true"><i class="ri-percent-line"></i></span>
                            <div class="test-card-sub__feat-title">Скидка для подписчиков</div>
                            <p class="test-card-sub__feat-text">До 15% от стандартной цены каждый заказ</p>
                        </div>
                        <div class="test-card-sub__feat">
                            <span class="test-card-sub__feat-icon" aria-hidden="true"><i class="ri-settings-3-line"></i></span>
                            <div class="test-card-sub__feat-title">Индивидуальный набор</div>
                            <p class="test-card-sub__feat-text">Выбирайте культуры под свой вкус и рацион</p>
                        </div>
                        <div class="test-card-sub__feat">
                            <span class="test-card-sub__feat-icon" aria-hidden="true"><i class="ri-flashlight-line"></i></span>
                            <div class="test-card-sub__feat-title">Приоритетная доставка</div>
                            <p class="test-card-sub__feat-text">Первыми получаете свежий сбор каждое утро</p>
                        </div>
                    </div>
                </div>
                <div class="test-card-sub__panel">
                    <div class="test-card-sub__blob test-card-sub__blob--tr"></div>
                    <div class="test-card-sub__blob test-card-sub__blob--bl"></div>
                    <div class="test-card-sub__panel-inner">
                        <h3 class="test-card-sub__panel-title">Оформить подписку</h3>
                        <p class="test-card-sub__panel-lead">Заполните форму — мы свяжемся и согласуем всё удобно для вас</p>
                        <form class="test-card-sub__form" data-readdy-form="true" method="post" action="#">
                            @csrf
                            <input type="hidden" name="product" value="{{ $plant->name }} FITAHATA">
                            <div class="test-card-sub__field">
                                <label class="test-card-sub__label" for="tc-sub-name">Ваше имя</label>
                                <input id="tc-sub-name" class="test-card-sub__input" type="text" name="sub_name" required
                                    placeholder="Иван Иванов">
                            </div>
                            <div class="test-card-sub__field">
                                <label class="test-card-sub__label" for="tc-sub-phone">Телефон</label>
                                <input id="tc-sub-phone" class="test-card-sub__input" type="tel" name="sub_phone" required
                                    placeholder="+375 29 000-00-00">
                            </div>
                            <div class="test-card-sub__field">
                                <label class="test-card-sub__label" for="tc-sub-email">Email</label>
                                <input id="tc-sub-email" class="test-card-sub__input" type="email" name="email"
                                    placeholder="mail@example.com">
                            </div>
                            <div class="test-card-sub__field">
                                <label class="test-card-sub__label" for="tc-sub-addr">Адрес доставки в Гомеле</label>
                                <input id="tc-sub-addr" class="test-card-sub__input" type="text" name="sub_address"
                                    placeholder="ул. Советская, 1">
                            </div>
                            <button type="submit" class="test-card-sub__submit">
                                Оформить подписку <i class="ri-arrow-right-line" aria-hidden="true"></i>
                            </button>
                            <p class="test-card-sub__note">Отменить можно в любой момент</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="test-card-outro">
        <div class="site-container test-card-outro__inner">
            <h3 class="test-card-outro__title">Хотите попробовать другие культуры?</h3>
            <p class="test-card-outro__text">В нашем каталоге — 20 культур свежей микрозелени с доставкой по Гомелю</p>
            <div class="test-card-outro__actions">
                <a class="test-card-outro__btn test-card-outro__btn--primary" href="{{ route('home') }}#catalog">
                    <i class="ri-apps-2-line" aria-hidden="true"></i> Весь каталог
                </a>
                <a class="test-card-outro__btn test-card-outro__btn--ghost" href="{{ route('contacts') }}">Написать нам</a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (function () {
            var main = document.querySelector('.test-card-product__main-img');
            var thumbs = document.querySelectorAll('.test-card-product__thumb');
            if (main && thumbs.length) {
                thumbs.forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        var src = btn.getAttribute('data-full-src');
                        if (src) main.src = src;
                        thumbs.forEach(function (b) { b.classList.remove('test-card-product__thumb--active'); });
                        btn.classList.add('test-card-product__thumb--active');
                    });
                });
            }

            var tablist = document.querySelector('.test-card-nutrition__tabs[role="tablist"]');
            if (tablist) {
                var tabs = tablist.querySelectorAll('.test-card-tab[data-nutrition-panel]');
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
                    panel.querySelectorAll('.test-card-energy__fill').forEach(function (el) {
                        if (!el.dataset.targetWidth) el.dataset.targetWidth = parseTargetWidth(el);
                    });
                }

                function resetBars(panel) {
                    if (!panel) return;
                    ensureTargets(panel);
                    panel.querySelectorAll('.test-card-energy__fill').forEach(function (el) {
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
                    var fills = panel.querySelectorAll('.test-card-energy__fill');
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

                function activate(key) {
                    tabs.forEach(function (tab) {
                        var k = tab.getAttribute('data-nutrition-panel');
                        var on = k === key;
                        tab.classList.toggle('test-card-tab--active', on);
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

                var wrap = document.querySelector('.test-card-nutrition__panel-wrap');
                var firstKey = tabs[0] && tabs[0].getAttribute('data-nutrition-panel');
                var firstPanel = firstKey ? panels[firstKey] : null;
                if (wrap && firstPanel) {
                    ensureTargets(firstPanel);
                    firstPanel.querySelectorAll('.test-card-energy__fill').forEach(function (el) {
                        el.style.transition = 'none';
                        el.style.width = '0%';
                        el.style.opacity = '0.4';
                    });
                    wrap.removeAttribute('data-nutrition-preload');
                    void wrap.offsetWidth;
                    firstPanel.querySelectorAll('.test-card-energy__fill').forEach(function (el) {
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
                var slides = track.querySelectorAll('.test-card-recipe__slide');
                var n = slides.length;
                if (n > 0) {
                    var idx = 0;
                    var dotBtns = dotsWrap.querySelectorAll('.test-card-recipe__dot-btn');

                    function go(i) {
                        idx = (i + n) % n;
                        track.style.transform = 'translateX(-' + (idx * 100) + '%)';
                        dotBtns.forEach(function (d, j) {
                            var on = j === idx;
                            d.classList.toggle('test-card-recipe__dot-btn--active', on);
                            d.setAttribute('aria-selected', on ? 'true' : 'false');
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
        })();
    </script>
@endpush
