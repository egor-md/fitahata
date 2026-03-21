<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">
    @vite(['resources/css/site.css'])
    @stack('styles')
</head>

<body>
    <header class="site-header">
        <nav class="site-nav site-container">
            <div class="site-nav-left">
                <div class="site-logo-wrap">
                    <img src="./images/logo-min.png" alt="">
                </div>
            </div>

            <div class="site-nav-right">
                <div class="menu">
                    <a href="/" class="menu-link {{ request()->is('/') ? 'active' : '' }}">
                        Главная
                    </a>
                    @foreach((is_iterable($menuCategories ?? null) ? $menuCategories : []) as $category)
                        @php
                            if (!($category instanceof \App\Models\Category)) {
                                continue;
                            }

                            $mainArticle = method_exists($category, 'relationLoaded') && $category->relationLoaded('mainArticle')
                                ? $category->mainArticle
                                : null;

                            $articles = $category->articles ?? collect();
                            $dropdownArticles = $mainArticle
                                ? $articles->where('id', '!=', $mainArticle->id)
                                : $articles;
                        @endphp

                        @if($mainArticle)
                            <div class="menu-item">
                                <a href="{{ route('article.show', $mainArticle->slug) }}"
                                    class="menu-link {{ request()->is('article/' . $mainArticle->slug) ? 'active' : '' }}">
                                    {{ $category->name }}
                                </a>
                                @if($dropdownArticles->isNotEmpty())
                                    <div class="menu-dropdown">
                                        @foreach($dropdownArticles as $article)
                                            <a href="{{ route('article.show', $article->slug) }}"
                                                class="menu-dropdown-link {{ request()->is('article/' . $article->slug) ? 'active' : '' }}">
                                                {{ $article->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @elseif($articles && $articles->isNotEmpty())
                            <div class="menu-item">
                                <button type="button" class="menu-button">
                                    {{ $category->name }}
                                    <svg class="menu-caret" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </button>
                                <div class="menu-dropdown">
                                    @foreach($articles as $article)
                                        <a href="{{ route('article.show', $article->slug) }}"
                                            class="menu-dropdown-link {{ request()->is('article/' . $article->slug) ? 'active' : '' }}">
                                            {{ $article->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <span class="menu-text">{{ $category->name }}</span>
                        @endif
                    @endforeach
                </div>
            </div>

            </div>
        </nav>
    </header>

    <main class="site-main">
        @yield('content')
    </main>

    <footer class="home-footer" aria-label="Подвал сайта">
        <div class="home-footer__top">
            <div class="site-container home-footer__container">
                <div class="home-footer__grid">
                    <div class="home-footer__col home-footer__col--brand">
                        <a href="#" class="home-footer__brandLink" aria-label="FITAHATA">
                            <div class="home-footer__brandRow">
                                <div class="home-footer__brandIcon">
                                    <i class="ri-leaf-fill home-footer__brandIconGlyph" aria-hidden="true"></i>
                                </div>
                                <span class="home-footer__brandName">FITAHATA</span>
                            </div>
                        </a>

                        <p class="home-footer__brandDesc">
                            Свежая фермерская микрозелень с доставкой по Гомелю. Выращиваем с заботой — доставляем за 24
                            часа.
                        </p>

                        <div class="home-footer__social">
                            <a href="#" aria-label="Instagram" class="home-footer__socialLink">
                                <i class="ri-instagram-line home-footer__socialIcon" aria-hidden="true"></i>
                            </a>
                            <a href="#" aria-label="Telegram" class="home-footer__socialLink">
                                <i class="ri-telegram-line home-footer__socialIcon" aria-hidden="true"></i>
                            </a>
                            <a href="#" aria-label="ВКонтакте" class="home-footer__socialLink">
                                <i class="ri-vk-line home-footer__socialIcon" aria-hidden="true"></i>
                            </a>
                            <a href="#" aria-label="WhatsApp" class="home-footer__socialLink">
                                <i class="ri-whatsapp-line home-footer__socialIcon" aria-hidden="true"></i>
                            </a>
                        </div>

                        <nav class="home-footer__nav" aria-label="Навигация">
                            <ul class="home-footer__navList">
                                <li class="home-footer__navItem">
                                    <a href="#каталог" class="home-footer__navLink">
                                        <span class="home-footer__navArrow" aria-hidden="true">
                                            <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
                                        </span>
                                        Каталог
                                    </a>
                                </li>
                                <li class="home-footer__navItem">
                                    <a href="#польза" class="home-footer__navLink">
                                        <span class="home-footer__navArrow" aria-hidden="true">
                                            <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
                                        </span>
                                        Польза
                                    </a>
                                </li>
                                <li class="home-footer__navItem">
                                    <a href="#доставка" class="home-footer__navLink">
                                        <span class="home-footer__navArrow" aria-hidden="true">
                                            <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
                                        </span>
                                        Доставка
                                    </a>
                                </li>
                                <li class="home-footer__navItem">
                                    <a href="#рецепты" class="home-footer__navLink">
                                        <span class="home-footer__navArrow" aria-hidden="true">
                                            <i class="ri-arrow-right-s-line" aria-hidden="true"></i>
                                        </span>
                                        Рецепты
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="home-footer__col home-footer__col--contacts">
                        <h3 class="home-footer__sectionTitle">
                            <span class="home-footer__sectionIcon" aria-hidden="true">
                                <i class="ri-contacts-line" aria-hidden="true"></i>
                            </span>
                            Контакты
                        </h3>

                        <ul class="home-footer__contactList">
                            <li class="home-footer__contactItem">
                                <span class="home-footer__contactIcon" aria-hidden="true">
                                    <i class="ri-map-pin-2-line" aria-hidden="true"></i>
                                </span>
                                <span class="home-footer__contactBody">
                                    <span class="home-footer__contactLabel">Адрес</span>
                                    <a href="https://maps.google.com/?q=Гомель" class="home-footer__contactLink">
                                        г. Гомель, ул. Советская, 112
                                    </a>
                                </span>
                            </li>
                            <li class="home-footer__contactItem">
                                <span class="home-footer__contactIcon" aria-hidden="true">
                                    <i class="ri-phone-line" aria-hidden="true"></i>
                                </span>
                                <span class="home-footer__contactBody">
                                    <span class="home-footer__contactLabel">Телефон</span>
                                    <a href="tel:+375291234567" class="home-footer__contactLink">
                                        +375 (29) 123-45-67
                                    </a>
                                </span>
                            </li>
                            <li class="home-footer__contactItem">
                                <span class="home-footer__contactIcon" aria-hidden="true">
                                    <i class="ri-mail-line" aria-hidden="true"></i>
                                </span>
                                <span class="home-footer__contactBody">
                                    <span class="home-footer__contactLabel">Email</span>
                                    <a href="mailto:hello@fitahata.by" class="home-footer__contactLink">
                                        hello@fitahata.by
                                    </a>
                                </span>
                            </li>
                            <li class="home-footer__contactItem">
                                <span class="home-footer__contactIcon" aria-hidden="true">
                                    <i class="ri-time-line" aria-hidden="true"></i>
                                </span>
                                <span class="home-footer__contactBody">
                                    <span class="home-footer__contactLabel">Режим работы</span>
                                    <span class="home-footer__contactText">Пн–Вс: 8:00 — 20:00</span>
                                </span>
                            </li>
                        </ul>

                        <div class="home-footer__mapWrap">
                            <iframe title="FITAHATA на карте Гомеля"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d75222.06!2d30.9!3d52.43!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46d6d1e28adb4b0b%3A0xb01b5f03b7f5dc62!2z0JPQvtC80LXQu9GM!5e0!3m2!1sru!2sby!4v1700000000000!5m2!1sru!2sby"
                                width="100%" height="100%" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" style="border: 0px;"></iframe>
                        </div>
                    </div>

                    <div class="home-footer__col home-footer__col--form">
                        <h3 class="home-footer__sectionTitle home-footer__sectionTitle--form">
                            <span class="home-footer__sectionIcon" aria-hidden="true">
                                <i class="ri-mail-send-line" aria-hidden="true"></i>
                            </span>
                            Написать нам
                        </h3>

                        <p class="home-footer__formDesc">
                            Есть вопросы о продукте или хотите оформить крупный заказ? Мы ответим быстро.
                        </p>

                        <form data-readdy-form="true" class="home-footer__form">
                            <div class="home-footer__formGrid">
                                <div class="home-footer__field">
                                    <label for="footer-name" class="home-footer__label">
                                        Имя *
                                    </label>
                                    <input id="footer-name" required="" placeholder="Ваше имя"
                                        class="home-footer__input" type="text" name="name">
                                </div>

                                <div class="home-footer__field">
                                    <label for="footer-phone" class="home-footer__label">
                                        Телефон *
                                    </label>
                                    <input id="footer-phone" required="" placeholder="+375 (29) ___-__-__"
                                        class="home-footer__input" type="tel" name="phone">
                                </div>
                            </div>

                            <div class="home-footer__field">
                                <div class="home-footer__messageHead">
                                    <label for="footer-message" class="home-footer__label">
                                        Сообщение *
                                    </label>
                                    <span class="home-footer__charCount">0/500</span>
                                </div>

                                <textarea id="footer-message" name="message" required="" rows="4" maxlength="500"
                                    placeholder="Напишите ваш вопрос или пожелание..."
                                    class="home-footer__textarea"></textarea>
                            </div>

                            <div class="home-footer__formBottom">
                                <p class="home-footer__consent">
                                    Нажимая кнопку, вы соглашаетесь с
                                    <a href="#" class="home-footer__policyLink">политикой конфиденциальности</a>
                                </p>

                                <button type="submit" class="home-footer__submitBtn">
                                    <span class="home-footer__submitIcon" aria-hidden="true">
                                        <i class="ri-send-plane-line" aria-hidden="true"></i>
                                    </span>
                                    Отправить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="home-footer__bottom">
            <div class="site-container home-footer__bottomContainer">
                <div class="home-footer__bottomRow">
                    <p class="home-footer__copyright">
                        © FITAHATA 2026. Все права защищены.
                    </p>
                    <div class="home-footer__bottomLinks">
                        <a href="#" class="home-footer__bottomLink">Политика конфиденциальности</a>
                        <span class="home-footer__bottomSeparator" aria-hidden="true"></span>
                        <a href="#" class="home-footer__bottomLink">Пользовательское соглашение</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>