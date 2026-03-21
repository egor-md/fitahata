@extends('layouts.site')

@section('title', 'Главная')

@section('content')
<section class="home-hero">
    <div class="site-container">
        <h1 class="home-hero-title">Микрозелень в Гомеле</h1>
        <!--         <h1 class="home-hero-title">Seedling Harvest</h1>
 -->
        <div class="home-hero-card">
            <div class="home-hero-left">
                <div class="home-hero-badge">
                    <span class="home-hero-badge-dot" aria-hidden="true"></span>
                    <span>Свежая микрозелень из локальной фермы</span>
                </div>
                <p class="home-hero-text">
                    Нежная микрозелень, выращенная на заказ: горох, редис, подсолнечник и другие
                    культуры. Доставляем свежий урожай для ресторанов, кафе и домашних кухонь.
                </p>
                <div class="home-hero-actions">
                    <a href="#" class="home-hero-cta">Заказать микрозелень</a>
                    <span class="home-hero-note">Без пестицидов · Сбор в день доставки</span>
                </div>
            </div>
            <div class="home-hero-right">
                <div class="home-hero-imageWrap">
                    <img src="/images/landing-microgreens.png" alt="Микрозелень в керамической миске" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>
<section id="catalog" class="catalog">
    <div class="catalog__container">
        <div class="catalog__header">
            <div class="catalog__headerLeft">
                <div class="catalog__pill">
                    <span class="catalog__pillText">Каталог</span>
                </div>
                <h2 class="catalog__title">Популярные культуры</h2>
                <p class="catalog__subtitle">Свежий сбор каждое утро, доставка в день заказа</p>
            </div>
            <button class="catalog__allBtn" type="button">
                Весь каталог
                <i class="ri-arrow-right-line" aria-hidden="true"></i>
            </button>
        </div>
        <div class="catalog__grid">
            @forelse(($catalogItems ?? []) as $item)
                <div class="catalog-card">
                    <div class="catalog-card__media">
                        <img
                            class="catalog-card__img"
                            src="{{ $item['image_url'] ?? '' }}"
                            alt="{{ $item['title'] ?? '' }}"
                            loading="lazy"
                        >
                        @if(!empty($item['badge']))
                            <span class="catalog-card__badge">{{ $item['badge'] }}</span>
                        @endif
                    </div>
                    <div class="catalog-card__body">
                        <h3 class="catalog-card__title">{{ $item['title'] ?? '' }}</h3>
                        <p class="catalog-card__desc">{{ $item['description'] ?? '' }}</p>
                        <p class="catalog-card__meta">{{ $item['benefit'] ?? '' }}</p>
                        <div class="catalog-card__row">
                            <span class="catalog-card__price">{{ $item['price'] ?? '' }}</span>
                            <a href="{{ route('article.show', $item['slug']) }}" class="catalog-card__btn">
                                Подробнее
                                <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="catalog__bottomText">Каталог пока пуст. Добавьте статьи в категорию «Микрозелень».</p>
            @endforelse
        </div>
        <div class="catalog__bottom">
            <p class="catalog__bottomText">Есть вопрос по культурам? Мы поможем выбрать</p>
            <button class="catalog__contactBtn" type="button">
                <i class="ri-customer-service-line" aria-hidden="true"></i>
                Связаться с нами
            </button>
        </div>
    </div>
</section>
<section id="benefits" class="benefits">
    <div class="benefits__container">
        <div class="benefits__header">
            <div class="benefits__pill">
                <i class="ri-seedling-line" aria-hidden="true"></i>
                <span class="benefits__pillText">Польза</span>
            </div>
            <h2 class="benefits__title">Почему микрозелень?</h2>
            <p class="benefits__subtitle">
                Концентрат витаминов, минералов и антиоксидантов в каждом листочке
            </p>
        </div>
        <div class="benefits__grid">
            <div class="benefits-card" style="background-color: rgb(232, 245, 224); opacity: 1; transform: translateY(0px); transition-delay: 0ms;">
                <div class="benefits-card__iconWrap" style="background-color: rgba(45, 80, 22, 0.082);">
                    <span class="benefits-card__bigNumber" style="color: rgb(45, 80, 22);">10×</span>
                </div>
                <h3 class="benefits-card__title">Больше витаминов</h3>
                <p class="benefits-card__text">Чем в зрелых растениях того же вида</p>
            </div>
            <div class="benefits-card" style="background-color: rgb(240, 247, 232); opacity: 1; transform: translateY(0px); transition-delay: 80ms;">
                <div class="benefits-card__iconWrap" style="background-color: rgba(58, 107, 26, 0.082);">
                    <i class="ri-shield-check-line benefits-card__icon" style="color: rgb(58, 107, 26);"></i>
                </div>
                <h3 class="benefits-card__title">Укрепляет иммунитет</h3>
                <p class="benefits-card__text">Антиоксиданты и фитонутриенты защищают организм</p>
            </div>
            <div class="benefits-card" style="background-color: rgb(232, 240, 220); opacity: 1; transform: translateY(0px); transition-delay: 160ms;">
                <div class="benefits-card__iconWrap" style="background-color: rgba(45, 80, 22, 0.082);">
                    <i class="ri-leaf-line benefits-card__icon" style="color: rgb(45, 80, 22);"></i>
                </div>
                <h3 class="benefits-card__title">Натуральный детокс</h3>
                <p class="benefits-card__text">Хлорофилл мягко очищает кровь и выводит токсины</p>
            </div>
            <div class="benefits-card" style="background-color: rgb(245, 241, 232); opacity: 1; transform: translateY(0px); transition-delay: 240ms;">
                <div class="benefits-card__iconWrap" style="background-color: rgba(92, 138, 26, 0.082);">
                    <i class="ri-heart-pulse-line benefits-card__icon" style="color: rgb(92, 138, 26);"></i>
                </div>
                <h3 class="benefits-card__title">Быстрый источник энергии</h3>
                <p class="benefits-card__text">Максимальная биодоступность питательных веществ</p>
            </div>
            <div class="benefits-card" style="background-color: rgb(238, 245, 228); opacity: 1; transform: translateY(0px); transition-delay: 320ms;">
                <div class="benefits-card__iconWrap" style="background-color: rgba(45, 80, 22, 0.082);">
                    <i class="ri-bowl-line benefits-card__icon" style="color: rgb(45, 80, 22);"></i>
                </div>
                <h3 class="benefits-card__title">Для любого рациона</h3>
                <p class="benefits-card__text">Подходит вегетарианцам, спортсменам и детям</p>
            </div>
        </div>
        <div class="benefits__science">
            <div class="benefits__scienceIconWrap">
                <i class="ri-microscope-line" aria-hidden="true"></i>
            </div>
            <p class="benefits__scienceText">
                <strong>Научный факт:</strong>
                Исследования Университета Мэриленда показали, что микрозелень содержит в 4–40 раз больше питательных веществ, чем зрелые растения того же вида.
            </p>
        </div>
    </div>
</section>
<section id="delivery" class="delivery">
    <div class="delivery__container">
        <div class="delivery__grid">
            <div class="delivery__media" style="opacity: 1; transform: translateX(0px); transition: 0.7s;">
                <img
                    alt="Доставка микрозелени в Гомеле"
                    class="delivery__img"
                    src="https://readdy.ai/api/search-image?query=eco%20friendly%20packaging%20microgreens%20delivery%20box%20opened%20with%20fresh%20green%20sprouts%20inside%20kraft%20paper%20box%20natural%20materials%20white%20background%20clean%20organic%20farm%20delivery%20concept%20beautiful%20food%20photography&amp;width=700&amp;height=600&amp;seq=delivery1&amp;orientation=landscape"
                    style="min-height: 420px;"
                >
                <div class="delivery__overlay">
                    <div class="delivery__overlayIconWrap">
                        <i class="ri-truck-line" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="delivery__overlayLabel">Среднее время</div>
                        <div class="delivery__overlayValue">2–4 часа</div>
                    </div>
                </div>
            </div>
            <div class="delivery__content" style="opacity: 1; transform: translateX(0px); transition: 0.7s 0.15s;">
                <div class="delivery__pill">
                    <i class="ri-map-pin-2-line" aria-hidden="true"></i>
                    <span class="delivery__pillText">Доставка</span>
                </div>
                <h2 class="delivery__title">
                    Доставка в день сбора
                    <br>
                    <span class="delivery__titleAccent">по Гомелю</span>
                </h2>
                <p class="delivery__subtitle">
                    Сохраняем максимум свежести и пользы. Ваша зелень приедет живой, сочной и готовой к столу.
                </p>
                <div class="delivery__features">
                    <div class="delivery__feature" style="opacity: 1; transform: translateX(0px); transition: 0.5s 0.2s;">
                        <div class="delivery__featureIconWrap">
                            <i class="ri-knife-line" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h4 class="delivery__featureTitle">Доставка в день сбора</h4>
                            <p class="delivery__featureText">Срезаем утром — привозим к вашему столу в тот же день</p>
                        </div>
                    </div>
                    <div class="delivery__feature" style="opacity: 1; transform: translateX(0px); transition: 0.5s 0.28s;">
                        <div class="delivery__featureIconWrap">
                            <i class="ri-gift-line" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h4 class="delivery__featureTitle">Бесплатно от 15 BYN</h4>
                            <p class="delivery__featureText">Или 3 BYN по городу — выбирайте ближайшее время</p>
                        </div>
                    </div>
                    <div class="delivery__feature" style="opacity: 1; transform: translateX(0px); transition: 0.5s 0.36s;">
                        <div class="delivery__featureIconWrap">
                            <i class="ri-recycle-line" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h4 class="delivery__featureTitle">Экологичная упаковка</h4>
                            <p class="delivery__featureText">Используем только перерабатываемые материалы</p>
                        </div>
                    </div>
                    <div class="delivery__feature" style="opacity: 1; transform: translateX(0px); transition: 0.5s 0.44s;">
                        <div class="delivery__featureIconWrap">
                            <i class="ri-time-line" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h4 class="delivery__featureTitle">Удобные интервалы</h4>
                            <p class="delivery__featureText">Выбирайте время доставки с 10:00 до 21:00</p>
                        </div>
                    </div>
                    <div class="delivery__feature" style="opacity: 1; transform: translateX(0px); transition: 0.5s 0.52s;">
                        <div class="delivery__featureIconWrap">
                            <i class="ri-repeat-line" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h4 class="delivery__featureTitle">Возможность подписки</h4>
                            <p class="delivery__featureText">Получайте зелень по расписанию без лишних заказов</p>
                        </div>
                    </div>
                </div>
                <div class="delivery__actions">
                    <button class="delivery__btn delivery__btn--primary" type="button">
                        Оформить заказ
                        <i class="ri-arrow-right-line" aria-hidden="true"></i>
                    </button>
                    <button class="delivery__btn delivery__btn--secondary" type="button">
                        Условия доставки
                        <i class="ri-information-line" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="subscription" class="subscription">
    <div class="subscription__container">
        <div class="subscription__grid">
            <div class="subscription__panel">
                <div class="subscription__blob subscription__blob--topRight"></div>
                <div class="subscription__blob subscription__blob--bottomLeft"></div>
                <div class="subscription__panelInner">
                    <div class="subscription__badge">
                        <i class="ri-leaf-line subscription__badgeIcon" aria-hidden="true"></i>
                        <span class="subscription__badgeText">Экономия до 15%</span>
                    </div>
                    <h2 class="subscription__title">
                        Подписка на
                        <br>
                        <span class="subscription__titleAccent">микрозелень</span>
                    </h2>
                    <p class="subscription__description">
                        Получайте свежую микрозелень каждую неделю без лишних заказов. Удобно,
                        выгодно и всегда вовремя.
                    </p>
                    <div class="subscription__bullets">
                        <div class="subscription__bullet">
                            <div class="subscription__bulletIconWrap">
                                <i class="ri-check-line subscription__bulletIcon" aria-hidden="true"></i>
                            </div>
                            <span class="subscription__bulletText">Еженедельная доставка без оформления</span>
                        </div>
                        <div class="subscription__bullet">
                            <div class="subscription__bulletIconWrap">
                                <i class="ri-check-line subscription__bulletIcon" aria-hidden="true"></i>
                            </div>
                            <span class="subscription__bulletText">Гибкое управление набором</span>
                        </div>
                        <div class="subscription__bullet">
                            <div class="subscription__bulletIconWrap">
                                <i class="ri-check-line subscription__bulletIcon" aria-hidden="true"></i>
                            </div>
                            <span class="subscription__bulletText">Пауза или отмена в любой момент</span>
                        </div>
                    </div>
                </div>
                <div class="subscription__ctaRow">
                    <button class="subscription__button" type="button">
                        Оформить подписку
                        <i class="ri-arrow-right-line subscription__buttonIcon" aria-hidden="true"></i>
                    </button>
                    <span class="subscription__ctaNote">Отменить можно в любой момент</span>
                </div>
            </div>
            <div class="subscription__features">
                <div class="subscription__feature">
                    <div class="subscription__featureIconWrap">
                        <i class="ri-calendar-check-line subscription__featureIcon" aria-hidden="true"></i>
                    </div>
                    <h3 class="subscription__featureTitle">Регулярные поставки</h3>
                    <p class="subscription__featureText">Без лишних заказов и звонков — всё по расписанию</p>
                </div>
                <div class="subscription__feature">
                    <div class="subscription__featureIconWrap">
                        <i class="ri-percent-line subscription__featureIcon" aria-hidden="true"></i>
                    </div>
                    <h3 class="subscription__featureTitle">Скидка для подписчиков</h3>
                    <p class="subscription__featureText">До 15% от стандартной цены каждый заказ</p>
                </div>
                <div class="subscription__feature">
                    <div class="subscription__featureIconWrap">
                        <i class="ri-settings-3-line subscription__featureIcon" aria-hidden="true"></i>
                    </div>
                    <h3 class="subscription__featureTitle">Индивидуальный набор</h3>
                    <p class="subscription__featureText">Выбирайте культуры под свой вкус и рацион</p>
                </div>
                <div class="subscription__feature">
                    <div class="subscription__featureIconWrap">
                        <i class="ri-flashlight-line subscription__featureIcon" aria-hidden="true"></i>
                    </div>
                    <h3 class="subscription__featureTitle">Приоритетная доставка</h3>
                    <p class="subscription__featureText">Первыми получаете свежий сбор каждое утро</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="why" class="why">
    <div class="why__container">
        <div class="why__header">
            <div class="why__pill">
                <i class="ri-medal-line why__pillIcon" aria-hidden="true"></i>
                <span class="why__pillText">Наши преимущества</span>
            </div>
            <h2 class="why__title">Почему выбирают FITAHATA</h2>
            <p class="why__subtitle">Прозрачность на каждом этапе — от семени до вашего стола</p>
        </div>
        <div class="why__grid">
            <div class="why-card" style="background-color: rgb(232, 245, 224); opacity: 1; transition: 0.5s;">
                <div class="why-card__iconWrap">
                    <i class="ri-plant-line why-card__icon" aria-hidden="true"></i>
                </div>
                <h3 class="why-card__title">100% эко-выращивание</h3>
                <p class="why-card__text">Закрытые фермы без использования почвы и пестицидов</p>
            </div>
            <div class="why-card" style="background-color: rgb(240, 247, 232); opacity: 1; transition: 0.5s 70ms;">
                <div class="why-card__iconWrap">
                    <i class="ri-forbid-2-line why-card__icon" aria-hidden="true"></i>
                </div>
                <h3 class="why-card__title">Без химии</h3>
                <p class="why-card__text">Только вода, свет и семена. Никаких добавок</p>
            </div>
            <div class="why-card" style="background-color: rgb(238, 245, 228); opacity: 1; transition: 0.5s 140ms;">
                <div class="why-card__iconWrap">
                    <i class="ri-user-settings-line why-card__icon" aria-hidden="true"></i>
                </div>
                <h3 class="why-card__title">Выращивание под заказ</h3>
                <p class="why-card__text">Сбор только после получения заказа — максимальная свежесть</p>
            </div>
            <div class="why-card" style="background-color: rgb(245, 241, 232); opacity: 1; transition: 0.5s 210ms;">
                <div class="why-card__iconWrap">
                    <i class="ri-award-line why-card__icon" aria-hidden="true"></i>
                </div>
                <h3 class="why-card__title">Контроль качества</h3>
                <p class="why-card__text">Каждая партия проходит визуальный и вкусовой контроль</p>
            </div>
            <div class="why-card" style="background-color: rgb(232, 240, 220); opacity: 1; transition: 0.5s 280ms;">
                <div class="why-card__iconWrap">
                    <i class="ri-map-pin-line why-card__icon" aria-hidden="true"></i>
                </div>
                <h3 class="why-card__title">Локальное производство</h3>
                <p class="why-card__text">Выращиваем прямо в Гомеле — от фермы до стола</p>
            </div>
            <div class="why-card" style="background-color: rgb(237, 245, 224); opacity: 1; transition: 0.5s 350ms;">
                <div class="why-card__iconWrap">
                    <i class="ri-heart-3-line why-card__icon" aria-hidden="true"></i>
                </div>
                <h3 class="why-card__title">Выращено с заботой</h3>
                <p class="why-card__text">Каждый росток — это наша ответственность и любовь</p>
            </div>
        </div>
        <div class="why__panel">
            <div class="why__blob why__blob--topRight"></div>
            <div class="why__blob why__blob--bottomLeft"></div>
            <div class="why__panelInner">
                <div class="why__stats">
                    <div class="why__stat">
                        <div class="why__statNumber">500+</div>
                        <div class="why__statLabel">Довольных клиентов</div>
                    </div>
                    <div class="why__stat">
                        <div class="why__statNumber">24ч</div>
                        <div class="why__statLabel">От сбора до доставки</div>
                    </div>
                    <div class="why__stat">
                        <div class="why__statNumber">100%</div>
                        <div class="why__statLabel">Натуральный продукт</div>
                    </div>
                </div>
                <div class="why__panelTextBlock">
                    <p class="why__panelText">Мы не перепродаём. Каждый пакетик микрозелени вырастили мы сами, в нашей ферме, под нашим контролем — с чистыми технологиями и любовью.</p>
                    <button type="button" class="why__cta">
                        Попробовать сейчас
                        <i class="ri-arrow-right-line why__ctaIcon" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="cooc" class="recipes">
    <div class="recipes__container">
        <div class="recipes__header">
            <span class="recipes__pill">Идеи для кухни</span>
            <h2 class="recipes__title">Готовим с микрозеленью</h2>
            <p class="recipes__subtitle">Простые и вкусные рецепты, которые превратят вашу кухню в маленький ресторан</p>
        </div>
        <div class="recipes__main">
            <div class="recipes__card" style="transition: opacity 0.35s, transform 0.35s;">
                <div class="recipes__media">
                    <img alt="Сэндвич с редисом и творожным сыром" class="recipes__img" src="https://readdy.ai/api/search-image?query=artisan%20sandwich%20with%20radish%20microgreens%20cream%20cheese%20sourdough%20bread%20cucumber%20red%20onion%20close%20up%20food%20photography%20natural%20light%20rustic%20wooden%20board%20fresh%20vibrant%20colors&amp;width=800&amp;height=600&amp;seq=recipe3&amp;orientation=landscape">
                    <div class="recipes__gradient"></div>
                    <div class="recipes__tag recipes__tag--accent">Быстрый рецепт</div>
                    <div class="recipes__tag recipes__tag--glass">Сэндвичи</div>
                </div>
                <div class="recipes__content">
                    <div>
                        <div class="recipes__metaRow">
                            <div class="recipes__metaItem">
                                <div class="recipes__metaIconWrap">
                                    <i class="ri-time-line recipes__metaIcon" aria-hidden="true"></i>
                                </div>
                                <span class="recipes__metaText">7 мин</span>
                            </div>
                            <div class="recipes__dot" aria-hidden="true"></div>
                            <div class="recipes__metaItem">
                                <div class="recipes__metaIconWrap">
                                    <i class="ri-fire-line recipes__metaIcon" aria-hidden="true"></i>
                                </div>
                                <span class="recipes__metaText">290 ккал</span>
                            </div>
                            <div class="recipes__dot" aria-hidden="true"></div>
                            <div class="recipes__metaItem">
                                <div class="recipes__metaIconWrap">
                                    <i class="ri-bar-chart-line recipes__metaIcon" aria-hidden="true"></i>
                                </div>
                                <span class="recipes__metaText">Очень легко</span>
                            </div>
                        </div>
                        <h3 class="recipes__recipeTitle">Сэндвич с редисом и творожным сыром</h3>
                        <p class="recipes__recipeDesc">Хрустящий сэндвич с пряными ростками редиса и нежным творожным сыром. Отличный вариант для быстрого завтрака или перекуса на ходу.</p>
                        <div class="recipes__ingredients">
                            <h4 class="recipes__ingredientsTitle">Ингредиенты</h4>
                            <ul class="recipes__ingredientsList">
                                <li class="recipes__ingredientItem">
                                    <div class="recipes__ingredientIconWrap">
                                        <i class="ri-leaf-line recipes__ingredientIcon" aria-hidden="true"></i>
                                    </div>
                                    Микрозелень редиса FITAHATA — 30 г
                                </li>
                                <li class="recipes__ingredientItem">
                                    <div class="recipes__ingredientIconWrap">
                                        <i class="ri-leaf-line recipes__ingredientIcon" aria-hidden="true"></i>
                                    </div>
                                    Хлеб на закваске — 2 ломтика
                                </li>
                                <li class="recipes__ingredientItem">
                                    <div class="recipes__ingredientIconWrap">
                                        <i class="ri-leaf-line recipes__ingredientIcon" aria-hidden="true"></i>
                                    </div>
                                    Творожный сыр — 60 г
                                </li>
                                <li class="recipes__ingredientItem">
                                    <div class="recipes__ingredientIconWrap">
                                        <i class="ri-leaf-line recipes__ingredientIcon" aria-hidden="true"></i>
                                    </div>
                                    Огурец — ½ шт
                                </li>
                                <li class="recipes__ingredientItem">
                                    <div class="recipes__ingredientIconWrap">
                                        <i class="ri-leaf-line recipes__ingredientIcon" aria-hidden="true"></i>
                                    </div>
                                    Красный лук — несколько колец
                                </li>
                                <li class="recipes__ingredientItem">
                                    <div class="recipes__ingredientIconWrap">
                                        <i class="ri-leaf-line recipes__ingredientIcon" aria-hidden="true"></i>
                                    </div>
                                    Лимонный перец — по вкусу
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="recipes__actions">
                        <a href="#каталог" class="recipes__actionBtn recipes__actionBtn--primary">
                            <i class="ri-shopping-basket-line recipes__actionIcon" aria-hidden="true"></i>
                            Купить микрозелень
                        </a>
                        <a href="#рецепты" class="recipes__actionBtn recipes__actionBtn--ghost">
                            Все рецепты
                            <i class="ri-arrow-right-line recipes__actionIcon" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="recipes__paginationRow">
                <div class="recipes__paginationDots">
                    <button class="recipes__pageDot" type="button" aria-label="Рецепт 1"></button>
                    <button class="recipes__pageDot" type="button" aria-label="Рецепт 2"></button>
                    <button class="recipes__pageDot recipes__pageDot--active" type="button" aria-label="Рецепт 3"></button>
                    <button class="recipes__pageDot" type="button" aria-label="Рецепт 4"></button>
                    <button class="recipes__pageDot" type="button" aria-label="Рецепт 5"></button>
                </div>
                <div class="recipes__navRow">
                    <button type="button" class="recipes__navBtn" aria-label="Предыдущий рецепт">
                        <div class="recipes__navIconWrap">
                            <i class="ri-arrow-left-line recipes__navIcon" aria-hidden="true"></i>
                        </div>
                    </button>
                    <button type="button" class="recipes__navBtn" aria-label="Следующий рецепт">
                        <div class="recipes__navIconWrap">
                            <i class="ri-arrow-right-line recipes__navIcon" aria-hidden="true"></i>
                        </div>
                    </button>
                </div>
            </div>
            <div class="recipes__counter">3 / 5</div>
        </div>
    </div>
</section>

@push('scripts')
<script>
        (function () {
            const slider = document.querySelector('.cooking-slider');
            if (!slider) return;

            const viewport = slider.querySelector('.cooking-slider-viewport');
            const track = slider.querySelector('.cooking-slider-track');
            const slides = Array.from(slider.querySelectorAll('.cooking-slide'));
            const leftBtn = slider.querySelector('.cooking-slider-arrow--left');
            const rightBtn = slider.querySelector('.cooking-slider-arrow--right');
            const dotsWrap = slider.querySelector('.cooking-slider-dots');

            const visible = Number(slider.dataset.visible || '4');
            slider.style.setProperty('--cooking-visible', String(visible));
            const maxIndex = Math.max(0, slides.length - visible);
            let index = 0;
            let slideWidth = 0;
            let slideStep = 0;

            function recalc() {
                if (!slides[0]) return;
                slideWidth = slides[0].getBoundingClientRect().width;
                const gap = parseFloat((window.getComputedStyle(track).gap || '0').toString()) || 0;
                slideStep = slideWidth + gap;
            }

            function setActiveDot(nextIndex) {
                if (!dotsWrap) return;
                const dots = Array.from(dotsWrap.querySelectorAll('button[data-dot]'));
                dots.forEach((d) => {
                    const isActive = Number(d.dataset.dot) === nextIndex;
                    d.classList.toggle('is-active', isActive);
                    d.setAttribute('aria-current', isActive ? 'true' : 'false');
                });
            }

            function go(nextIndex) {
                index = Math.min(maxIndex, Math.max(0, nextIndex));
                recalc();
                const offset = index * slideStep;
                track.style.transform = 'translateX(' + -offset + 'px)';
                setActiveDot(index);
            }

            // Dots
            if (dotsWrap) {
                dotsWrap.innerHTML = '';
                for (let i = 0; i <= maxIndex; i++) {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.dataset.dot = String(i);
                    btn.className = 'cooking-slider-dot';
                    btn.setAttribute('aria-label', 'Слайд ' + (i + 1));
                    btn.addEventListener('click', function () {
                        go(i);
                    });
                    dotsWrap.appendChild(btn);
                }
            }

            // Arrows
            if (leftBtn) {
                leftBtn.addEventListener('click', function () {
                    go(index - 1);
                });
            }
            if (rightBtn) {
                rightBtn.addEventListener('click', function () {
                    go(index + 1);
                });
            }

            // Resize
            window.addEventListener('resize', function () {
                go(index);
            });

            recalc();
            go(0);
        })();
</script>
<script>
        (function () {
            const section = document.getElementById('cooc');
            if (!section) return;

            const card = section.querySelector('.recipes__card');
            if (!card) return;

            const imgEl = section.querySelector('.recipes__img');
            const accentTag = section.querySelector('.recipes__tag--accent');
            const glassTag = section.querySelector('.recipes__tag--glass');
            const titleEl = section.querySelector('.recipes__recipeTitle');
            const descEl = section.querySelector('.recipes__recipeDesc');
            const metaTexts = Array.from(section.querySelectorAll('.recipes__metaText'));
            const ingredientsList = section.querySelector('.recipes__ingredientsList');
            const counterEl = section.querySelector('.recipes__counter');

            const dots = Array.from(section.querySelectorAll('.recipes__pageDot'));
            const navButtons = Array.from(section.querySelectorAll('.recipes__navBtn'));
            const prevBtn = navButtons[0];
            const nextBtn = navButtons[1];

            // 5 статических слайдов: переключаем контент в одной карточке.
            // Если позже появится динамический список рецептов из БД — можно будет заменить этот массив.
            const slides = [
                {
                    imgSrc: 'https://readdy.ai/api/search-image?query=artisan%20sandwich%20with%20peas%20microgreens%20green%20salsa%20bread%20close%20up%20food%20photography%20natural%20light%20rustic%20wooden%20board%20fresh%20vibrant%20colors&width=800&height=600&seq=recipe1&orientation=landscape',
                    imgAlt: 'Сэндвич с горохом и микрозеленью',
                    tagAccent: 'Идея за 10 минут',
                    tagGlass: 'Сэндвичи',
                    meta: ['10 мин', '260 ккал', 'Легко'],
                    title: 'Сэндвич с горохом и зеленью',
                    desc: 'Хрустящий хлеб и ароматные ростки гороха — быстрый вариант для завтрака и перекуса.',
                    ingredients: [
                        'Микрозелень гороха FITAHATA — 30 г',
                        'Хлеб на закваске — 2 ломтика',
                        'Сливочный сыр — 60 г',
                        'Огурец — 1/2 шт',
                        'Зелёный лук — несколько колец',
                        'Лимонный перец — по вкусу',
                    ],
                },
                {
                    imgSrc: 'https://readdy.ai/api/search-image?query=artisan%20sandwich%20with%20broccoli%20microgreens%20cream%20cheese%20sourdough%20bread%20cucumber%20red%20onion%20close%20up%20food%20photography%20natural%20light%20rustic%20wooden%20board%20fresh%20vibrant%20colors&width=800&height=600&seq=recipe2&orientation=landscape',
                    imgAlt: 'Сэндвич с брокколи и микрозеленью',
                    tagAccent: 'Сытный рецепт',
                    tagGlass: 'Сэндвичи',
                    meta: ['12 мин', '310 ккал', 'Средне'],
                    title: 'Сэндвич с брокколи и сливочным сыром',
                    desc: 'Насыщенный вкус брокколи-микрозелени и сливочного сыра — для плотного и полезного перекуса.',
                    ingredients: [
                        'Микрозелень брокколи FITAHATA — 30 г',
                        'Хлеб на закваске — 2 ломтика',
                        'Сливочный сыр — 60 г',
                        'Огурец — 1/2 шт',
                        'Красный лук — несколько колец',
                        'Перец и соль — по вкусу',
                    ],
                },
                // Текущий контент из разметки будет совпадать с 3-м слайдом по умолчанию.
                {
                    imgSrc: imgEl?.getAttribute('src') || '',
                    imgAlt: imgEl?.getAttribute('alt') || 'Рецепт с микрозеленью',
                    tagAccent: accentTag?.textContent?.trim() || 'Быстрый рецепт',
                    tagGlass: glassTag?.textContent?.trim() || 'Сэндвичи',
                    meta: metaTexts.map((n) => n.textContent.trim()).slice(0, 3),
                    title: titleEl?.textContent?.trim() || 'Сэндвич с редисом и творожным сыром',
                    desc: descEl?.textContent?.trim() || '',
                    ingredients: [
                        'Микрозелень редиса FITAHATA — 30 г',
                        'Хлеб на закваске — 2 ломтика',
                        'Творожный сыр — 60 г',
                        'Огурец — 1/2 шт',
                        'Красный лук — несколько колец',
                        'Лимонный перец — по вкусу',
                    ],
                },
                {
                    imgSrc: 'https://readdy.ai/api/search-image?query=artisan%20sandwich%20with%20sunflower%20microgreens%20cream%20cheese%20sourdough%20bread%20cucumber%20red%20onion%20close%20up%20food%20photography%20natural%20light%20rustic%20wooden%20board%20fresh%20vibrant%20colors&width=800&height=600&seq=recipe4&orientation=landscape',
                    imgAlt: 'Сэндвич с подсолнечником и микрозеленью',
                    tagAccent: 'Рецепт дня',
                    tagGlass: 'Сэндвичи',
                    meta: ['8 мин', '280 ккал', 'Очень легко'],
                    title: 'Сэндвич с подсолнечником',
                    desc: 'Тонкий вкус и лёгкий аромат микрозелени — идеальный вариант на скорую руку.',
                    ingredients: [
                        'Микрозелень подсолнечника FITAHATA — 30 г',
                        'Хлеб на закваске — 2 ломтика',
                        'Творожный сыр — 60 г',
                        'Огурец — 1/2 шт',
                        'Красный лук — несколько колец',
                        'Перец — по вкусу',
                    ],
                },
                {
                    imgSrc: 'https://readdy.ai/api/search-image?query=artisan%20sandwich%20with%20radish%20microgreens%20herb%20sauce%20sourdough%20bread%20cucumber%20close%20up%20food%20photography%20natural%20light%20rustic%20wooden%20board%20fresh%20vibrant%20colors&width=800&height=600&seq=recipe5&orientation=landscape',
                    imgAlt: 'Сэндвич с редисом и микрозеленью',
                    tagAccent: 'Лёгкая закуска',
                    tagGlass: 'Сэндвичи',
                    meta: ['6 мин', '240 ккал', 'Легко'],
                    title: 'Быстрый сэндвич с ростками редиса',
                    desc: 'Свежие ростки редиса и зелёная нотка — чтобы быстро зарядиться энергией.',
                    ingredients: [
                        'Микрозелень редиса FITAHATA — 30 г',
                        'Хлеб на закваске — 2 ломтика',
                        'Сливочный сыр — 60 г',
                        'Огурец — 1/2 шт',
                        'Зелёный лук — несколько колец',
                        'Лимонный перец — по вкусу',
                    ],
                },
            ];

            let index = dots.findIndex((b) => b.classList.contains('recipes__pageDot--active'));
            if (index < 0) index = 0;

            function setActiveDot(nextIndex) {
                dots.forEach((btn, i) => {
                    const isActive = i === nextIndex;
                    btn.classList.toggle('recipes__pageDot--active', isActive);
                    btn.setAttribute('aria-current', isActive ? 'true' : 'false');
                });
            }

            function render(nextIndex) {
                const s = slides[nextIndex];
                if (!s) return;

                // Мягкая смена кадра
                card.style.opacity = '0';

                window.setTimeout(() => {
                    if (imgEl) {
                        imgEl.src = s.imgSrc;
                        imgEl.alt = s.imgAlt;
                    }
                    if (accentTag) accentTag.textContent = s.tagAccent;
                    if (glassTag) glassTag.textContent = s.tagGlass;
                    if (titleEl) titleEl.textContent = s.title;
                    if (descEl) descEl.textContent = s.desc;

                    if (metaTexts.length) {
                        for (let i = 0; i < Math.min(3, s.meta.length); i++) {
                            if (metaTexts[i]) metaTexts[i].textContent = s.meta[i];
                        }
                    }

                    if (ingredientsList) {
                        ingredientsList.innerHTML = s.ingredients
                            .map((text) => {
                                return (
                                    '<li class="recipes__ingredientItem">' +
                                    '<div class="recipes__ingredientIconWrap">' +
                                    '<i class="ri-leaf-line recipes__ingredientIcon" aria-hidden="true"></i>' +
                                    '</div>' +
                                    text +
                                    '</li>'
                                );
                            })
                            .join('');
                    }

                    if (counterEl) {
                        counterEl.textContent = String(nextIndex + 1) + ' / ' + String(slides.length);
                    }

                    setActiveDot(nextIndex);
                    card.style.opacity = '1';
                }, 180);
            }

            function go(nextIndex) {
                const max = slides.length - 1;
                const clamped = Math.min(max, Math.max(0, nextIndex));
                if (clamped === index) return;
                index = clamped;
                render(index);
            }

            dots.forEach((btn, i) => {
                btn.addEventListener('click', function () {
                    go(i);
                });
            });

            if (prevBtn) {
                prevBtn.addEventListener('click', function () {
                    go(index - 1);
                });
            }
            if (nextBtn) {
                nextBtn.addEventListener('click', function () {
                    go(index + 1);
                });
            }

            window.addEventListener('keydown', function (e) {
                if (!section.contains(document.activeElement)) return;
                if (e.key === 'ArrowLeft') go(index - 1);
                if (e.key === 'ArrowRight') go(index + 1);
            });

            render(index);
        })();
</script>
@endpush

@endsection
