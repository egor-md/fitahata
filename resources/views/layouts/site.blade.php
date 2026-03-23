<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="@yield('meta_description', 'Свежая микрозелень FITAHATA в Гомеле: каталог культур, доставка в день сбора и полезные рецепты.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="FITAHATA">
    <meta property="og:title"
        content="@yield('og_title', trim((($__env->yieldContent('title')) ?: config('app.name')) . ' | FITAHATA'))">
    <meta property="og:description"
        content="@yield('og_description', trim($__env->yieldContent('meta_description', 'Свежая микрозелень FITAHATA в Гомеле: каталог культур, доставка в день сбора и полезные рецепты.')))">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('images/landing-microgreens.webp'))">
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title"
        content="@yield('twitter_title', trim((($__env->yieldContent('title')) ?: config('app.name')) . ' | FITAHATA'))">
    <meta name="twitter:description"
        content="@yield('twitter_description', trim($__env->yieldContent('meta_description', 'Свежая микрозелень FITAHATA в Гомеле: каталог культур, доставка в день сбора и полезные рецепты.')))">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/landing-microgreens.webp'))">
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
        <nav class="site-nav site-container" aria-label="Основная навигация">
            <div class="site-nav-left">
                <a href="{{ route('home') }}" class="site-logo-link" aria-label="FITAHATA — на главную">
                    <div class="site-logo-wrap">
                        <img src="/images/logo-min.webp" alt="Логотип FITAHATA" width="277" height="120">
                    </div>
                </a>
            </div>
            <button class="mobile-menu-toggle" type="button" aria-label="Открыть меню" aria-controls="site-menu"
                aria-expanded="false">
                <i class="ri-menu-line" aria-hidden="true"></i>
            </button>

            <div id="site-menu" class="site-nav-right" aria-hidden="true">
                <div class="menu">
                    <a href="{{ route('home') }}" class="menu-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        Главная
                    </a>
                    <div class="menu-item">
                        <button type="button" class="menu-button {{ request()->is('article/*') ? 'active' : '' }}">
                            Микрозелень
                            <svg class="menu-caret" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </button>
                        <div class="menu-dropdown">
                            <a href="{{ route('home') }}#catalog" class="menu-dropdown-link">Растения</a>
                            @foreach(($menuPlants ?? collect()) as $plant)
                                <a href="{{ route('article.show', $plant->slug) }}"
                                    class="menu-dropdown-link {{ request()->is('article/' . $plant->slug) ? 'active' : '' }}">
                                    {{ $plant->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ route('contacts') }}" class="menu-link {{ request()->routeIs('contacts') ? 'active' : '' }}">
                        Контакты
                    </a>
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
                        <a href="/" class="home-footer__brandLink" aria-label="FITAHATA">
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
                            <a href="#" aria-label="Instagram" class="home-footer__socialLink"><i class="ri-instagram-line home-footer__socialIcon" aria-hidden="true"></i></a>
                            <a href="#" aria-label="Telegram" class="home-footer__socialLink"><i class="ri-telegram-line home-footer__socialIcon" aria-hidden="true"></i></a>
                            <a href="#" aria-label="ВКонтакте" class="home-footer__socialLink"><i class="ri-vk-line home-footer__socialIcon" aria-hidden="true"></i></a>
                            <a href="#" aria-label="WhatsApp" class="home-footer__socialLink"><i class="ri-whatsapp-line home-footer__socialIcon" aria-hidden="true"></i></a>
                        </div>

                        <nav class="home-footer__nav" aria-label="Навигация">
                            <ul class="home-footer__navList">
                                <li class="home-footer__navItem"><a href="{{ route('home') }}#catalog" class="home-footer__navLink"><span class="home-footer__navArrow" aria-hidden="true"><i class="ri-arrow-right-s-line" aria-hidden="true"></i></span>Каталог</a></li>
                                <li class="home-footer__navItem"><a href="{{ route('home') }}#benefits" class="home-footer__navLink"><span class="home-footer__navArrow" aria-hidden="true"><i class="ri-arrow-right-s-line" aria-hidden="true"></i></span>Польза</a></li>
                                <li class="home-footer__navItem"><a href="{{ route('home') }}#delivery" class="home-footer__navLink"><span class="home-footer__navArrow" aria-hidden="true"><i class="ri-arrow-right-s-line" aria-hidden="true"></i></span>Доставка</a></li>
                                <li class="home-footer__navItem"><a href="{{ route('home') }}#cooc" class="home-footer__navLink"><span class="home-footer__navArrow" aria-hidden="true"><i class="ri-arrow-right-s-line" aria-hidden="true"></i></span>Рецепты</a></li>
                            </ul>
                        </nav>
                    </div>

                    <div id="home-contacts" class="home-footer__col home-footer__col--contacts">
                        <h3 class="home-footer__sectionTitle"><span class="home-footer__sectionIcon" aria-hidden="true"><i class="ri-contacts-line" aria-hidden="true"></i></span>Контакты</h3>
                        <ul class="home-footer__contactList">
                            <li class="home-footer__contactItem"><span class="home-footer__contactIcon" aria-hidden="true"><i class="ri-map-pin-2-line" aria-hidden="true"></i></span><span class="home-footer__contactBody"><span class="home-footer__contactLabel">Адрес</span><a href="https://maps.google.com/?q=Гомель" class="home-footer__contactLink">г. Гомель, ул. Советская, 112</a></span></li>
                            <li class="home-footer__contactItem"><span class="home-footer__contactIcon" aria-hidden="true"><i class="ri-phone-line" aria-hidden="true"></i></span><span class="home-footer__contactBody"><span class="home-footer__contactLabel">Телефон</span><a href="tel:+375291234567" class="home-footer__contactLink">+375 (29) 123-45-67</a></span></li>
                            <li class="home-footer__contactItem"><span class="home-footer__contactIcon" aria-hidden="true"><i class="ri-mail-line" aria-hidden="true"></i></span><span class="home-footer__contactBody"><span class="home-footer__contactLabel">Email</span><a href="mailto:hello@fitahata.by" class="home-footer__contactLink">hello@fitahata.by</a></span></li>
                            <li class="home-footer__contactItem"><span class="home-footer__contactIcon" aria-hidden="true"><i class="ri-time-line" aria-hidden="true"></i></span><span class="home-footer__contactBody"><span class="home-footer__contactLabel">Режим работы</span><span class="home-footer__contactText">Пн–Вс: 8:00 — 20:00</span></span></li>
                        </ul>
                    </div>

                    <div class="home-footer__col home-footer__col--form">
                        <h3 class="home-footer__sectionTitle home-footer__sectionTitle--form"><span class="home-footer__sectionIcon" aria-hidden="true"><i class="ri-mail-send-line" aria-hidden="true"></i></span>Написать нам</h3>
                        <p class="home-footer__formDesc">Есть вопросы о продукте или хотите оформить крупный заказ? Мы ответим быстро.</p>
                        <form data-readdy-form="true" class="home-footer__form">
                            <div class="home-footer__formGrid">
                                <div class="home-footer__field"><label for="footer-name" class="home-footer__label">Имя *</label><input id="footer-name" required placeholder="Ваше имя" class="home-footer__input" type="text" name="name"></div>
                                <div class="home-footer__field"><label for="footer-phone" class="home-footer__label">Телефон *</label><input id="footer-phone" required placeholder="+375 (29) ___-__-__" class="home-footer__input" type="tel" name="phone"></div>
                            </div>
                            <div class="home-footer__field">
                                <div class="home-footer__messageHead"><label for="footer-message" class="home-footer__label">Сообщение *</label><span class="home-footer__charCount">0/500</span></div>
                                <textarea id="footer-message" name="message" required rows="4" maxlength="500" placeholder="Напишите ваш вопрос или пожелание..." class="home-footer__textarea"></textarea>
                            </div>
                            <div class="home-footer__formBottom">
                                <p class="home-footer__consent">Нажимая кнопку, вы соглашаетесь с <a href="#" class="home-footer__policyLink">политикой конфиденциальности</a></p>
                                <button type="submit" class="home-footer__submitBtn"><span class="home-footer__submitIcon" aria-hidden="true"><i class="ri-send-plane-line" aria-hidden="true"></i></span>Отправить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="home-footer__bottom">
            <div class="site-container home-footer__bottomContainer">
                <div class="home-footer__bottomRow">
                    <p class="home-footer__copyright">© FITAHATA 2026. Все права защищены.</p>
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
    <script>
        (function () {
            const toggle = document.querySelector('.mobile-menu-toggle');
            const menu = document.getElementById('site-menu');
            if (!toggle || !menu) return;

            function closeMenu() {
                menu.classList.remove('site-nav-right--open');
                menu.setAttribute('aria-hidden', 'true');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.setAttribute('aria-label', 'Открыть меню');
                document.body.classList.remove('is-menu-open');
            }

            function openMenu() {
                menu.classList.add('site-nav-right--open');
                menu.setAttribute('aria-hidden', 'false');
                toggle.setAttribute('aria-expanded', 'true');
                toggle.setAttribute('aria-label', 'Закрыть меню');
                document.body.classList.add('is-menu-open');
            }

            toggle.addEventListener('click', function () {
                const isOpen = menu.classList.contains('site-nav-right--open');
                if (isOpen) {
                    closeMenu();
                    return;
                }
                openMenu();
            });

            menu.addEventListener('click', function (event) {
                if (event.target instanceof HTMLElement && event.target.closest('a')) {
                    closeMenu();
                }
            });

            document.addEventListener('click', function (event) {
                if (!(event.target instanceof Node)) return;
                if (!menu.contains(event.target) && !toggle.contains(event.target)) {
                    closeMenu();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') closeMenu();
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth > 992) {
                    closeMenu();
                    menu.removeAttribute('aria-hidden');
                } else if (!menu.classList.contains('site-nav-right--open')) {
                    menu.setAttribute('aria-hidden', 'true');
                }
            });
        })();
    </script>
</body>

</html>
