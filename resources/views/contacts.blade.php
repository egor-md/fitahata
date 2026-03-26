@extends('layouts.site')

@section('title', 'Контакты')
@section('meta_description', 'Контакты FITAHATA в Гомеле: адрес, телефон, email, карта и форма обратной связи.')

@section('content')
    <section class="contacts-hero" aria-labelledby="contacts-heading">
        <div class="site-container contacts-hero__inner">
            <div class="contacts-hero__badge">
                <span class="contacts-hero__badge-icon" aria-hidden="true"><i class="ri-leaf-fill"></i></span>
                <span class="contacts-hero__badge-text">FITAHATA · Гомель</span>
            </div>
            <h1 id="contacts-heading" class="contacts-hero__title">Свяжитесь с нами</h1>
            <p class="contacts-hero__lead">
                Мы всегда рады ответить на ваши вопросы и помочь с выбором микрозелени.
            </p>
            <nav class="contacts-breadcrumb" aria-label="Навигация по разделам">
                <a class="contacts-breadcrumb__link" href="{{ route('home') }}">Главная</a>
                <span class="contacts-breadcrumb__sep" aria-hidden="true"><i class="ri-arrow-right-s-line"></i></span>
                <span class="contacts-breadcrumb__current">Контакты</span>
            </nav>
        </div>
    </section>

    <section class="contacts-cards-section" aria-label="Контактные данные">
        <div class="site-container">
            <div class="contacts-cards">
                <article class="contacts-card">
                    <div class="contacts-card__icon-wrap" aria-hidden="true">
                        <i class="ri-map-pin-2-fill contacts-card__icon"></i>
                    </div>
                    <div class="contacts-card__body">
                        <p class="contacts-card__label">Адрес</p>
                        <p class="contacts-card__value">г. Гомель</p>
                        <p class="contacts-card__value">ул. Советская, 112</p>
                    </div>
                    <a class="contacts-card__action" href="https://www.google.com/maps?q=Гомель+ул+Советская+112"
                        target="_blank" rel="noopener noreferrer">
                        Открыть карту
                        <span class="contacts-card__action-icon" aria-hidden="true"><i class="ri-arrow-right-up-line"></i></span>
                    </a>
                </article>

                <article class="contacts-card">
                    <div class="contacts-card__icon-wrap" aria-hidden="true">
                        <i class="ri-phone-fill contacts-card__icon"></i>
                    </div>
                    <div class="contacts-card__body">
                        <p class="contacts-card__label">Телефон</p>
                        <p class="contacts-card__value">+375 (29) 123-45-67</p>
                        <p class="contacts-card__value">+375 (33) 987-65-43</p>
                    </div>
                    <a class="contacts-card__action" href="tel:+375291234567" rel="noopener noreferrer">
                        Позвонить
                        <span class="contacts-card__action-icon" aria-hidden="true"><i class="ri-arrow-right-up-line"></i></span>
                    </a>
                </article>

                <article class="contacts-card">
                    <div class="contacts-card__icon-wrap" aria-hidden="true">
                        <i class="ri-mail-fill contacts-card__icon"></i>
                    </div>
                    <div class="contacts-card__body">
                        <p class="contacts-card__label">Email</p>
                        <p class="contacts-card__value">hello@fitahata.by</p>
                        <p class="contacts-card__value">order@fitahata.by</p>
                    </div>
                    <a class="contacts-card__action" href="mailto:hello@fitahata.by" rel="noopener noreferrer">
                        Написать письмо
                        <span class="contacts-card__action-icon" aria-hidden="true"><i class="ri-arrow-right-up-line"></i></span>
                    </a>
                </article>

                <article class="contacts-card">
                    <div class="contacts-card__icon-wrap" aria-hidden="true">
                        <i class="ri-time-fill contacts-card__icon"></i>
                    </div>
                    <div class="contacts-card__body">
                        <p class="contacts-card__label">Режим работы</p>
                        <p class="contacts-card__value">Понедельник — пятница</p>
                        <p class="contacts-card__value">8:00 — 20:00</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- Карта + форма --}}
    <section class="contacts-split" aria-label="Карта и обратная связь">
        <div class="site-container contacts-split__grid">
            <div class="contacts-split__col contacts-split__col--map">
                <h2 class="contacts-split__title">Мы на карте</h2>
                <p class="contacts-split__text">
                    Наша ферма находится в Гомеле. Вы можете приехать за заказом самостоятельно или оформить доставку.
                </p>
                <div class="contacts-split__map">
                    <iframe title="FITAHATA на карте Гомеля"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d75222.06!2d30.9!3d52.43!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46d6d1e28adb4b0b%3A0xb01b5f03b7f5dc62!2z0JPQvtC80LXQu9GM!5e0!3m2!1sru!2sby!4v1700000000000!5m2!1sru!2sby"
                        width="100%" height="100%" allowfullscreen loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <ul class="contacts-hints">
                    <li class="contacts-hints__item">
                        <span class="contacts-hints__icon" aria-hidden="true"><i class="ri-map-pin-line"></i></span>
                        <div>
                            <p class="contacts-hints__title">г. Гомель, ул. Советская, 112</p>
                            <p class="contacts-hints__sub">Работаем ежедневно 8:00 — 20:00</p>
                        </div>
                    </li>
                    <li class="contacts-hints__item">
                        <span class="contacts-hints__icon" aria-hidden="true"><i class="ri-car-line"></i></span>
                        <div>
                            <p class="contacts-hints__title">Бесплатная парковка</p>
                            <p class="contacts-hints__sub">Парковка у входа, 20 мест</p>
                        </div>
                    </li>
                </ul>

                <div class="contacts-social">
                    <p class="contacts-social__label">Мы в социальных сетях</p>
                    <div class="contacts-social__row">
                        <a href="#" class="contacts-social__link contacts-social__link--instagram" aria-label="Instagram"><i
                                class="ri-instagram-line" aria-hidden="true"></i></a>
                        <a href="#" class="contacts-social__link contacts-social__link--telegram" aria-label="Telegram"><i
                                class="ri-telegram-line" aria-hidden="true"></i></a>
                        <a href="#" class="contacts-social__link contacts-social__link--vk" aria-label="ВКонтакте"><i
                                class="ri-vk-line" aria-hidden="true"></i></a>
                        <a href="#" class="contacts-social__link contacts-social__link--whatsapp" aria-label="WhatsApp"><i
                                class="ri-whatsapp-line" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>

            <div class="contacts-split__col contacts-split__col--form">
                <div class="contacts-form-panel">
                    <div class="contacts-form-panel__head">
                        <span class="contacts-form-panel__head-icon" aria-hidden="true"><i class="ri-mail-send-line"></i></span>
                        <h2 class="contacts-form-panel__title">Написать нам</h2>
                    </div>
                    <p class="contacts-form-panel__intro">
                        Есть вопрос о продукции, хотите оформить крупный заказ или наладить регулярные поставки? Заполните
                        форму — мы ответим в течение нескольких часов.
                    </p>

                    <form class="contacts-form" data-readdy-form="true" id="contacts-main-form" method="post" action="#">
                        @csrf
                        <div class="contacts-form__row2">
                            <div class="contacts-form__field">
                                <label class="contacts-form__label" for="contact-name">Имя *</label>
                                <input id="contact-name" class="contacts-form__input" type="text" name="name" required
                                    placeholder="Ваше имя" autocomplete="name">
                            </div>
                            <div class="contacts-form__field">
                                <label class="contacts-form__label" for="contact-phone">Телефон *</label>
                                <input id="contact-phone" class="contacts-form__input" type="tel" name="phone" required
                                    placeholder="+375 (29) ___-__-__" autocomplete="tel">
                            </div>
                        </div>
                        <div class="contacts-form__field">
                            <label class="contacts-form__label" for="contact-email">Email</label>
                            <input id="contact-email" class="contacts-form__input" type="email" name="email"
                                placeholder="ваш@email.com" autocomplete="email">
                        </div>
                        <div class="contacts-form__field">
                            <label class="contacts-form__label" for="contact-topic">Тема обращения</label>
                            <div class="contacts-form__select-wrap">
                                <select id="contact-topic" class="contacts-form__select" name="topic">
                                    <option value="">Выберите тему...</option>
                                    <option value="Вопрос о продукции">Вопрос о продукции</option>
                                    <option value="Оформление заказа">Оформление заказа</option>
                                    <option value="Подписка на поставки">Подписка на поставки</option>
                                    <option value="Сотрудничество (рестораны)">Сотрудничество (рестораны)</option>
                                    <option value="Другое">Другое</option>
                                </select>
                            </div>
                        </div>
                        <div class="contacts-form__field">
                            <div class="contacts-form__message-head">
                                <label class="contacts-form__label" for="contact-message">Сообщение *</label>
                                <span class="contacts-form__counter" data-contacts-charcount>0/500</span>
                            </div>
                            <textarea id="contact-message" class="contacts-form__textarea" name="message" required rows="5"
                                maxlength="500" placeholder="Опишите ваш вопрос или пожелание..."></textarea>
                        </div>
                        <div class="contacts-form__footer">
                            <p class="contacts-form__consent">
                                Нажимая кнопку, вы соглашаетесь с
                                <a href="#" class="contacts-form__policy">политикой конфиденциальности</a>
                            </p>
                            <button type="submit" class="contacts-form__submit">
                                <span class="contacts-form__submit-icon" aria-hidden="true"><i
                                        class="ri-send-plane-fill"></i></span>
                                Отправить сообщение
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ: нативные details/summary --}}
    <section class="contacts-faq" aria-labelledby="contacts-faq-title">
        <div class="site-container contacts-faq__inner">
            <header class="contacts-faq__header">
                <h2 id="contacts-faq-title" class="contacts-faq__title">Часто задаваемые вопросы</h2>
                <p class="contacts-faq__sub">Не нашли ответ? Напишите нам через форму выше.</p>
            </header>
            <div class="contacts-faq__list">
                <details class="contacts-faq__item">
                    <summary class="contacts-faq__summary">
                        <span>Как быстро доставляется заказ?</span>
                        <span class="contacts-faq__chev" aria-hidden="true"><i class="ri-add-line"></i></span>
                    </summary>
                    <div class="contacts-faq__body">
                        <p>Обычно доставка по Гомелю занимает 2–4 часа в день сбора. Точное время согласуем при оформлении.</p>
                    </div>
                </details>
                <details class="contacts-faq__item">
                    <summary class="contacts-faq__summary">
                        <span>Есть ли минимальная сумма заказа?</span>
                        <span class="contacts-faq__chev" aria-hidden="true"><i class="ri-add-line"></i></span>
                    </summary>
                    <div class="contacts-faq__body">
                        <p>Условия зависят от набора и объёма — напишите или позвоните, подскажем по вашему заказу.</p>
                    </div>
                </details>
                <details class="contacts-faq__item">
                    <summary class="contacts-faq__summary">
                        <span>Можно ли оформить подписку на регулярные поставки?</span>
                        <span class="contacts-faq__chev" aria-hidden="true"><i class="ri-add-line"></i></span>
                    </summary>
                    <div class="contacts-faq__body">
                        <p>Да, доступна подписка с гибким набором и графиком. Оставьте заявку в форме — обсудим детали.</p>
                    </div>
                </details>
                <details class="contacts-faq__item">
                    <summary class="contacts-faq__summary">
                        <span>Работаете ли вы с ресторанами?</span>
                        <span class="contacts-faq__chev" aria-hidden="true"><i class="ri-add-line"></i></span>
                    </summary>
                    <div class="contacts-faq__body">
                        <p>Да, поставляем кафе и ресторанам. В теме обращения выберите «Сотрудничество (рестораны)».</p>
                    </div>
                </details>
            </div>
        </div>
    </section>

    {{-- Нижний CTA; общий подвал уже в layouts.site --}}
    <section class="contacts-cta" aria-label="Призыв к действию">
        <div class="site-container contacts-cta__inner">
            <div class="contacts-cta__text">
                <h2 class="contacts-cta__title">Готовы попробовать свежую микрозелень?</h2>
                <p class="contacts-cta__lead">Первый заказ со скидкой 10%. Доставка по Гомелю за 2–4 часа.</p>
            </div>
            <div class="contacts-cta__actions">
                <a class="contacts-cta__btn contacts-cta__btn--primary" href="{{ route('home') }}#catalog">
                    <span aria-hidden="true"><i class="ri-shopping-basket-line"></i></span>
                    Смотреть каталог
                </a>
                <a class="contacts-cta__btn contacts-cta__btn--ghost" href="tel:+375291234567">
                    <span aria-hidden="true"><i class="ri-phone-line"></i></span>
                    Позвонить нам
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (function () {
            var ta = document.getElementById('contact-message');
            var count = document.querySelector('[data-contacts-charcount]');
            if (!ta || !count) return;
            function sync() {
                count.textContent = ta.value.length + '/500';
            }
            ta.addEventListener('input', sync);
            sync();
        })();
    </script>
@endpush
