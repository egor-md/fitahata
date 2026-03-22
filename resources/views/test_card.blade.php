@extends('layouts.site')

@section('title', 'Микрозелень руккола в Гомеле')
@section('meta_description', 'Микрозелень руккола в Гомеле — демо-карточка товара FITAHATA.')

@section('content')
    {{-- Продукт --}}
    <section class="test-card-product">
        <div class="site-container test-card-product__inner">
            <div class="test-card-product__grid">
                <div class="test-card-product__media">
                    <div class="test-card-product__stage">
                        <img class="test-card-product__main-img" src="/images/test-card/phero3.jpg"
                            alt="Руккола микрозелень" width="800" height="800">
                        <span class="test-card-product__hit">Хит продаж</span>
                        <div class="test-card-product__rating-pill">
                            <span class="test-card-product__rating-pill-star" aria-hidden="true"><i
                                    class="ri-star-fill"></i></span>
                            <span class="test-card-product__rating-pill-score">4.9</span>
                            <span class="test-card-product__rating-pill-count">(87)</span>
                        </div>
                    </div>
                    <div class="test-card-product__thumbs" role="group" aria-label="Галерея фото">
                        <button type="button" class="test-card-product__thumb" data-full-src="/images/test-card/phero1.jpg"
                            aria-label="Фото 1">
                            <img src="/images/test-card/phero1.jpg" alt="" width="80" height="80">
                        </button>
                        <button type="button" class="test-card-product__thumb" data-full-src="/images/test-card/phero2.jpg"
                            aria-label="Фото 2">
                            <img src="/images/test-card/phero2.jpg" alt="" width="80" height="80">
                        </button>
                        <button type="button"
                            class="test-card-product__thumb test-card-product__thumb--active"
                            data-full-src="/images/test-card/phero3.jpg" aria-label="Фото 3">
                            <img src="/images/test-card/phero3.jpg" alt="" width="80" height="80">
                        </button>
                    </div>
                </div>

                <div class="test-card-product__info">
                    <div class="test-card-product__meta">
                        <span class="test-card-product__cat">Зелень</span>
                        <span class="test-card-product__sku">Арт. FIT-001</span>
                    </div>
                    <h1 class="test-card-product__title">
                        Руккола<br>
                        <span class="test-card-product__title-sub">микрозелень</span>
                    </h1>
                    <div class="test-card-product__stars-row">
                        <span class="test-card-product__stars" aria-hidden="true">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="ri-star-fill"></i>
                            @endfor
                        </span>
                        <span class="test-card-product__reviews">4.9 — 87 отзывов</span>
                    </div>
                    <div class="test-card-product__desc">
                        <p>Нежные ростки рукколы с характерным пряным вкусом и едва уловимой ореховой горчинкой.
                            Выращиваем без пестицидов, собираем на 7–9 день — когда концентрация питательных веществ в 40
                            раз выше, чем у взрослого растения.</p>
                        <p>Идеальна для салатов, пиццы, пасты, тартинок и боулов. Придаёт любому блюду утончённую пряность и
                            яркую зелень.</p>
                    </div>
                    <div class="test-card-product__tags">
                        <span class="test-card-product__tag">Витамин К</span>
                        <span class="test-card-product__tag">Кальций</span>
                        <span class="test-card-product__tag">Фолиевая кислота</span>
                        <span class="test-card-product__tag">Антиоксиданты</span>
                        <span class="test-card-product__tag">Без ГМО</span>
                    </div>
                    <div class="test-card-product__facts">
                        <div class="test-card-product__fact">
                            <span class="test-card-product__fact-icon" aria-hidden="true"><i class="ri-test-tube-line"></i></span>
                            <div class="test-card-product__fact-title">В 40× больше</div>
                            <div class="test-card-product__fact-sub">питательных веществ</div>
                        </div>
                        <div class="test-card-product__fact">
                            <span class="test-card-product__fact-icon" aria-hidden="true"><i class="ri-seedling-line"></i></span>
                            <div class="test-card-product__fact-title">7–9 дней</div>
                            <div class="test-card-product__fact-sub">срок выращивания</div>
                        </div>
                        <div class="test-card-product__fact">
                            <span class="test-card-product__fact-icon" aria-hidden="true"><i
                                    class="ri-shield-check-line"></i></span>
                            <div class="test-card-product__fact-title">БЕЗ ГМО</div>
                            <div class="test-card-product__fact-sub">и пестицидов</div>
                        </div>
                    </div>
                    <div class="test-card-product__buy">
                        <div class="test-card-product__buy-top">
                            <div>
                                <div class="test-card-product__price">5,50 BYN</div>
                                <div class="test-card-product__price-unit">за 50 г</div>
                            </div>
                            <div class="test-card-product__price-old-wrap">
                                <div class="test-card-product__price-was">6,50 BYN</div>
                                <span class="test-card-product__discount">Скидка 15%</span>
                            </div>
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

    {{-- Питательность --}}
    <section class="test-card-nutrition">
        <div class="site-container">
            <header class="test-card-section-head">
                <span class="test-card-pill">Состав и полезность</span>
                <h2 class="test-card-section-head__title">Таблица питательности рукколы</h2>
                <p class="test-card-section-head__text">Микрозелень рукколы содержит в 40 раз больше питательных веществ,
                    чем взрослые растения — научно доказано</p>
            </header>
            <div class="test-card-nutrition__grid">
                <div class="test-card-nutrition__tabs" role="tablist" aria-label="Разделы питательности">
                    <button type="button" id="nutrition-tab-energy" class="test-card-tab test-card-tab--active"
                        role="tab" aria-selected="true" aria-controls="nutrition-panel-energy" data-nutrition-panel="energy">
                        <span class="test-card-tab__icon" aria-hidden="true"><i class="ri-fire-line"></i></span>
                        <span class="test-card-tab__text">Энергетическая ценность</span>
                    </button>
                    <button type="button" id="nutrition-tab-protein" class="test-card-tab" role="tab"
                        aria-selected="false" aria-controls="nutrition-panel-protein" data-nutrition-panel="protein">
                        <span class="test-card-tab__icon test-card-tab__icon--green" aria-hidden="true"><i
                                class="ri-test-tube-line"></i></span>
                        <span class="test-card-tab__text">Белки и аминокислоты</span>
                    </button>
                    <button type="button" id="nutrition-tab-vitamins" class="test-card-tab" role="tab"
                        aria-selected="false" aria-controls="nutrition-panel-vitamins" data-nutrition-panel="vitamins">
                        <span class="test-card-tab__icon test-card-tab__icon--lime" aria-hidden="true"><i
                                class="ri-capsule-line"></i></span>
                        <span class="test-card-tab__text">Витамины</span>
                    </button>
                    <button type="button" id="nutrition-tab-minerals" class="test-card-tab" role="tab"
                        aria-selected="false" aria-controls="nutrition-panel-minerals" data-nutrition-panel="minerals">
                        <span class="test-card-tab__icon test-card-tab__icon--teal" aria-hidden="true"><i
                                class="ri-microscope-line"></i></span>
                        <span class="test-card-tab__text">Минералы и микроэлементы</span>
                    </button>
                    <button type="button" id="nutrition-tab-antioxidants" class="test-card-tab" role="tab"
                        aria-selected="false" aria-controls="nutrition-panel-antioxidants"
                        data-nutrition-panel="antioxidants">
                        <span class="test-card-tab__icon test-card-tab__icon--rose" aria-hidden="true"><i
                                class="ri-shield-star-line"></i></span>
                        <span class="test-card-tab__text">Антиоксиданты и фитонутриенты</span>
                    </button>
                    <aside class="test-card-tip">
                        <div class="test-card-tip__head">
                            <span class="test-card-tip__icon" aria-hidden="true"><i class="ri-lightbulb-line"></i></span>
                            <span class="test-card-tip__label">Знаете ли вы?</span>
                        </div>
                        <p class="test-card-tip__text">Всего 50 г рукколы FITAHATA покрывает суточную норму витамина К и даёт
                            больше кальция, чем стакан молока.</p>
                    </aside>
                </div>
                <div class="test-card-nutrition__panel-wrap" data-nutrition-preload>
                    <div id="nutrition-panel-energy" class="test-card-energy test-card-energy--theme-energy" role="tabpanel"
                        aria-labelledby="nutrition-tab-energy">
                        <div class="test-card-energy__head">
                            <span class="test-card-energy__head-icon" aria-hidden="true"><i class="ri-fire-line"></i></span>
                            <h3 class="test-card-energy__title">Энергетическая ценность</h3>
                        </div>
                        <ul class="test-card-energy__list">
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Калорийность</span>
                                    <span class="test-card-energy__meta">на 100 г</span>
                                    <span class="test-card-energy__val">25 ккал</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill"
                                        style="width:12%"></span></div>
                            </li>
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Углеводы</span>
                                    <span class="test-card-energy__meta">на 100 г</span>
                                    <span class="test-card-energy__val">3.7 г</span>
                                </div>
                                <div class="test-card-energy__bar"><span
                                        class="test-card-energy__fill test-card-energy__fill--mid" style="width:30%"></span>
                                </div>
                            </li>
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Жиры</span>
                                    <span class="test-card-energy__meta">на 100 г</span>
                                    <span class="test-card-energy__val">0.7 г</span>
                                </div>
                                <div class="test-card-energy__bar"><span
                                        class="test-card-energy__fill test-card-energy__fill--orange" style="width:8%"></span>
                                </div>
                            </li>
                        </ul>
                        @include('partials.test_card_nutrition_footnote')
                    </div>

                    <div id="nutrition-panel-protein" class="test-card-energy test-card-energy--theme-protein" role="tabpanel"
                        aria-labelledby="nutrition-tab-protein" hidden>
                        <div class="test-card-energy__head">
                            <span class="test-card-energy__head-icon" aria-hidden="true"><i
                                    class="ri-test-tube-line"></i></span>
                            <h3 class="test-card-energy__title">Белки и аминокислоты</h3>
                        </div>
                        <ul class="test-card-energy__list">
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Белки (общие)</span>
                                    <span class="test-card-energy__meta">на 100 г</span>
                                    <span class="test-card-energy__val">2.6 г</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--prot1"
                                        style="width:52%"></span></div>
                            </li>
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Незаменимые аминокислоты</span>
                                    <span class="test-card-energy__meta">на 100 г</span>
                                    <span class="test-card-energy__val">1.1 г</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--prot2"
                                        style="width:40%"></span></div>
                            </li>
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Аргинин</span>
                                    <span class="test-card-energy__meta">на 100 г</span>
                                    <span class="test-card-energy__val">0.14 г</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--prot3"
                                        style="width:18%"></span></div>
                            </li>
                        </ul>
                        @include('partials.test_card_nutrition_footnote')
                    </div>

                    <div id="nutrition-panel-vitamins" class="test-card-energy test-card-energy--theme-vitamins" role="tabpanel"
                        aria-labelledby="nutrition-tab-vitamins" hidden>
                        <div class="test-card-energy__head">
                            <span class="test-card-energy__head-icon" aria-hidden="true"><i class="ri-capsule-line"></i></span>
                            <h3 class="test-card-energy__title">Витамины</h3>
                        </div>
                        <ul class="test-card-energy__list">
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Витамин К</span>
                                    <span class="test-card-energy__meta">136% нормы</span>
                                    <span class="test-card-energy__val">109 мкг</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--vit1"
                                        style="width:100%"></span></div>
                            </li>
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Витамин С</span>
                                    <span class="test-card-energy__meta">101% нормы</span>
                                    <span class="test-card-energy__val">91 мг</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--vit2"
                                        style="width:95%"></span></div>
                            </li>
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Фолиевая кислота (В9)</span>
                                    <span class="test-card-energy__meta">24% нормы</span>
                                    <span class="test-card-energy__val">97 мкг</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--vit3"
                                        style="width:55%"></span></div>
                            </li>
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Витамин А (бета-каротин)</span>
                                    <span class="test-card-energy__meta">158% нормы</span>
                                    <span class="test-card-energy__val">1424 мкг</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--vit4"
                                        style="width:100%"></span></div>
                            </li>
                        </ul>
                        @include('partials.test_card_nutrition_footnote')
                    </div>

                    <div id="nutrition-panel-minerals" class="test-card-energy test-card-energy--theme-minerals" role="tabpanel"
                        aria-labelledby="nutrition-tab-minerals" hidden>
                        <div class="test-card-energy__head">
                            <span class="test-card-energy__head-icon" aria-hidden="true"><i
                                    class="ri-microscope-line"></i></span>
                            <h3 class="test-card-energy__title">Минералы и микроэлементы</h3>
                        </div>
                        <ul class="test-card-energy__list">
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Кальций</span>
                                    <span class="test-card-energy__meta">16% нормы</span>
                                    <span class="test-card-energy__val">160 мг</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--min1"
                                        style="width:45%"></span></div>
                            </li>
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Железо</span>
                                    <span class="test-card-energy__meta">12% нормы</span>
                                    <span class="test-card-energy__val">1.5 мг</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--min2"
                                        style="width:30%"></span></div>
                            </li>
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Магний</span>
                                    <span class="test-card-energy__meta">12% нормы</span>
                                    <span class="test-card-energy__val">47 мг</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--min3"
                                        style="width:28%"></span></div>
                            </li>
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Калий</span>
                                    <span class="test-card-energy__meta">16% нормы</span>
                                    <span class="test-card-energy__val">369 мг</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--min4"
                                        style="width:40%"></span></div>
                            </li>
                        </ul>
                        @include('partials.test_card_nutrition_footnote')
                    </div>

                    <div id="nutrition-panel-antioxidants" class="test-card-energy test-card-energy--theme-antioxidants"
                        role="tabpanel" aria-labelledby="nutrition-tab-antioxidants" hidden>
                        <div class="test-card-energy__head">
                            <span class="test-card-energy__head-icon" aria-hidden="true"><i
                                    class="ri-shield-star-line"></i></span>
                            <h3 class="test-card-energy__title">Антиоксиданты и фитонутриенты</h3>
                        </div>
                        <ul class="test-card-energy__list">
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Глюкозинолаты</span>
                                    <span class="test-card-energy__meta">противораковый эффект</span>
                                    <span class="test-card-energy__val">высокое</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--ox1"
                                        style="width:88%"></span></div>
                            </li>
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Флавоноиды</span>
                                    <span class="test-card-energy__meta">сердечно-сосудистая защита</span>
                                    <span class="test-card-energy__val">высокое</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--ox2"
                                        style="width:78%"></span></div>
                            </li>
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Полифенолы</span>
                                    <span class="test-card-energy__meta">замедляют старение</span>
                                    <span class="test-card-energy__val">высокое</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--ox3"
                                        style="width:72%"></span></div>
                            </li>
                            <li class="test-card-energy__row">
                                <div class="test-card-energy__row-top">
                                    <span class="test-card-energy__name">Антиоксидантный индекс (ORAC)</span>
                                    <span class="test-card-energy__meta">мкмоль TE/100г</span>
                                    <span class="test-card-energy__val">1904</span>
                                </div>
                                <div class="test-card-energy__bar"><span class="test-card-energy__fill test-card-energy__fill--ox4"
                                        style="width:65%"></span></div>
                            </li>
                        </ul>
                        @include('partials.test_card_nutrition_footnote')
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Рецепт --}}
    <section class="test-card-recipe">
        <div class="site-container">
            <header class="test-card-section-head">
                <span class="test-card-pill">Идеи для кухни</span>
                <h2 class="test-card-section-head__title">Готовим с рукколой</h2>
                <p class="test-card-section-head__text">Четыре простых рецепта, которые сделают рукколу FITAHATA центром вашего
                    стола</p>
            </header>
            <div class="test-card-recipe__wrap">
                <div class="test-card-recipe__card">
                    <div class="test-card-recipe__media">
                        <img src="/images/test-card/recipe-pizza.jpg" alt="Пицца бьянка с рукколой и прошутто" width="800"
                            height="600">
                        <div class="test-card-recipe__grad" aria-hidden="true"></div>
                        <span class="test-card-recipe__tag test-card-recipe__tag--top">Горячее</span>
                        <span class="test-card-recipe__tag test-card-recipe__tag--bottom">Горячее</span>
                    </div>
                    <div class="test-card-recipe__body">
                        <div class="test-card-recipe__meta-row">
                            <span class="test-card-recipe__meta"><i class="ri-time-line" aria-hidden="true"></i> 25 мин</span>
                            <span class="test-card-recipe__dot" aria-hidden="true"></span>
                            <span class="test-card-recipe__meta"><i class="ri-fire-line" aria-hidden="true"></i> 420 ккал</span>
                            <span class="test-card-recipe__dot" aria-hidden="true"></span>
                            <span class="test-card-recipe__meta"><i class="ri-bar-chart-line" aria-hidden="true"></i> Средне</span>
                        </div>
                        <h3 class="test-card-recipe__name">Пицца бьянка с рукколой и прошутто</h3>
                        <p class="test-card-recipe__text">Белая пицца из тонкого теста с рикоттой, моцареллой и розмарином.
                            Сразу после духовки — горсть свежей рукколы FITAHATA и тончайшие ломтики прошутто.</p>
                        <h4 class="test-card-recipe__ing-title">Ингредиенты</h4>
                        <ul class="test-card-recipe__ing">
                            <li><i class="ri-leaf-line" aria-hidden="true"></i> Руккола FITAHATA — 40 г</li>
                            <li><i class="ri-leaf-line" aria-hidden="true"></i> Тонкое тесто для пиццы</li>
                            <li><i class="ri-leaf-line" aria-hidden="true"></i> Рикотта — 100 г</li>
                            <li><i class="ri-leaf-line" aria-hidden="true"></i> Моцарелла — 80 г</li>
                            <li><i class="ri-leaf-line" aria-hidden="true"></i> Прошутто — 60 г</li>
                            <li><i class="ri-leaf-line" aria-hidden="true"></i> Чеснок — 2 зубчика</li>
                            <li><i class="ri-leaf-line" aria-hidden="true"></i> Оливковое масло, розмарин</li>
                        </ul>
                        <div class="test-card-recipe__actions">
                            <a class="test-card-recipe__btn" href="{{ route('home') }}#catalog">
                                <i class="ri-shopping-basket-line" aria-hidden="true"></i> Купить рукколу
                            </a>
                        </div>
                    </div>
                </div>
                <div class="test-card-recipe__nav">
                    <div class="test-card-recipe__dots">
                        <span class="test-card-recipe__dot-btn"></span>
                        <span class="test-card-recipe__dot-btn test-card-recipe__dot-btn--active"></span>
                        <span class="test-card-recipe__dot-btn"></span>
                        <span class="test-card-recipe__dot-btn"></span>
                    </div>
                    <div class="test-card-recipe__arrows">
                        <button type="button" class="test-card-recipe__arrow" aria-label="Предыдущий рецепт"><i
                                class="ri-arrow-left-line"></i></button>
                        <button type="button" class="test-card-recipe__arrow" aria-label="Следующий рецепт"><i
                                class="ri-arrow-right-line"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Подписка --}}
    <section id="subscription" class="test-card-sub">
        <div class="site-container">
            <header class="test-card-section-head">
                <span class="test-card-pill">Постоянным покупателям</span>
                <h2 class="test-card-section-head__title">Подписка на доставку рукколы</h2>
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
                            <input type="hidden" name="product" value="Руккола FITAHATA">
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
            <p class="test-card-outro__text">В нашем каталоге — 12 видов свежей микрозелени с доставкой по Гомелю</p>
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
            if (!tablist) return;
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
            if (wrap && panels.energy) {
                ensureTargets(panels.energy);
                panels.energy.querySelectorAll('.test-card-energy__fill').forEach(function (el) {
                    el.style.transition = 'none';
                    el.style.width = '0%';
                    el.style.opacity = '0.4';
                });
                wrap.removeAttribute('data-nutrition-preload');
                void wrap.offsetWidth;
                panels.energy.querySelectorAll('.test-card-energy__fill').forEach(function (el) {
                    el.style.transition = '';
                });
                animateNutritionBars(panels.energy);
            }
        })();
    </script>
@endpush
