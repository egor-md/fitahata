@extends('layouts.shop')

@section('title', 'Контакты')
@section('meta_description', 'Контакты FITAHATA в Гомеле: адрес, телефон, email, карта и форма обратной связи.')

@section('content')
    {{-- Hero --}}
    <section class="bg-gradient-to-br from-[#1A3A0F] via-[#243D18] to-[#1A3A0F] pt-24 sm:pt-32 pb-24 sm:pb-36 text-white" aria-labelledby="contacts-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 mb-6">
                <span class="text-white/80 text-sm" aria-hidden="true"><i class="ri-leaf-fill"></i></span>
                <span class="text-sm font-medium text-white/90">FITAHATA · Гомель</span>
            </div>
            <h1 id="contacts-heading" class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight mb-4">Свяжитесь с нами</h1>
            <p class="text-lg sm:text-xl text-white/70 max-w-xl mx-auto leading-relaxed mb-8">
                Мы всегда рады ответить на ваши вопросы и помочь с выбором микрозелени.
            </p>
            <nav class="flex items-center justify-center gap-2 text-sm text-white/50" aria-label="Навигация по разделам">
                <a class="hover:text-white transition-colors" href="{{ route('home') }}">Главная</a>
                <span aria-hidden="true"><i class="ri-arrow-right-s-line"></i></span>
                <span class="text-white font-medium">Контакты</span>
            </nav>
        </div>
    </section>

    {{-- Contact Cards --}}
    <section class="py-16 bg-white" aria-label="Контактные данные">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <article class="bg-[#F8F6F0] rounded-2xl p-6 flex flex-col gap-4 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                    <div class="w-11 h-11 flex items-center justify-center rounded-xl bg-[#2D5016]/10" aria-hidden="true">
                        <i class="ri-map-pin-2-fill text-lg text-[#2D5016]"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-[#6B7B5A] uppercase tracking-wider mb-1">Адрес</p>
                        <p class="text-sm font-semibold text-[#1A1A1A]">г. Гомель</p>
                        <p class="text-sm font-semibold text-[#1A1A1A]">ул. Советская, 112</p>
                    </div>
                    <a class="inline-flex items-center gap-1.5 text-sm font-bold text-[#2D5016] hover:text-[#4A7C2A] transition-colors mt-auto" href="https://www.google.com/maps?q=Гомель+ул+Советская+112"
                        target="_blank" rel="noopener noreferrer">
                        Открыть карту
                        <span aria-hidden="true"><i class="ri-arrow-right-up-line text-xs"></i></span>
                    </a>
                </article>

                <article class="bg-[#F8F6F0] rounded-2xl p-6 flex flex-col gap-4 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                    <div class="w-11 h-11 flex items-center justify-center rounded-xl bg-[#2D5016]/10" aria-hidden="true">
                        <i class="ri-phone-fill text-lg text-[#2D5016]"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-[#6B7B5A] uppercase tracking-wider mb-1">Телефон</p>
                        <p class="text-sm font-semibold text-[#1A1A1A]">+375 (29) 123-45-67</p>
                        <p class="text-sm font-semibold text-[#1A1A1A]">+375 (33) 987-65-43</p>
                    </div>
                    <a class="inline-flex items-center gap-1.5 text-sm font-bold text-[#2D5016] hover:text-[#4A7C2A] transition-colors mt-auto" href="tel:+375291234567" rel="noopener noreferrer">
                        Позвонить
                        <span aria-hidden="true"><i class="ri-arrow-right-up-line text-xs"></i></span>
                    </a>
                </article>

                <article class="bg-[#F8F6F0] rounded-2xl p-6 flex flex-col gap-4 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                    <div class="w-11 h-11 flex items-center justify-center rounded-xl bg-[#2D5016]/10" aria-hidden="true">
                        <i class="ri-mail-fill text-lg text-[#2D5016]"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-[#6B7B5A] uppercase tracking-wider mb-1">Email</p>
                        <p class="text-sm font-semibold text-[#1A1A1A]">hello@fitahata.by</p>
                        <p class="text-sm font-semibold text-[#1A1A1A]">order@fitahata.by</p>
                    </div>
                    <a class="inline-flex items-center gap-1.5 text-sm font-bold text-[#2D5016] hover:text-[#4A7C2A] transition-colors mt-auto" href="mailto:hello@fitahata.by" rel="noopener noreferrer">
                        Написать письмо
                        <span aria-hidden="true"><i class="ri-arrow-right-up-line text-xs"></i></span>
                    </a>
                </article>

                <article class="bg-[#F8F6F0] rounded-2xl p-6 flex flex-col gap-4 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                    <div class="w-11 h-11 flex items-center justify-center rounded-xl bg-[#2D5016]/10" aria-hidden="true">
                        <i class="ri-time-fill text-lg text-[#2D5016]"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-[#6B7B5A] uppercase tracking-wider mb-1">Режим работы</p>
                        <p class="text-sm font-semibold text-[#1A1A1A]">Понедельник — пятница</p>
                        <p class="text-sm font-semibold text-[#1A1A1A]">8:00 — 20:00</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- Карта + форма --}}
    <section class="py-16 bg-[#F5F1E8]" aria-label="Карта и обратная связь">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div>
                <h2 class="text-2xl font-extrabold text-[#1A3A0F] mb-3">Мы на карте</h2>
                <p class="text-sm text-[#6B7B5A] leading-relaxed mb-6">
                    Наша ферма находится в Гомеле. Вы можете приехать за заказом самостоятельно или оформить доставку.
                </p>
                <div class="w-full aspect-video rounded-2xl overflow-hidden border border-[#DDD6C8]">
                    <iframe title="FITAHATA на карте Гомеля"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d75222.06!2d30.9!3d52.43!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46d6d1e28adb4b0b%3A0xb01b5f03b7f5dc62!2z0JPQvtC80LXQu9GM!5e0!3m2!1sru!2sby!4v1700000000000!5m2!1sru!2sby"
                        width="100%" height="100%" allowfullscreen loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <ul class="mt-6 flex flex-col gap-4">
                    <li class="flex items-start gap-3">
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#4A7C2A]/10 text-[#4A7C2A] flex-shrink-0 mt-0.5" aria-hidden="true"><i class="ri-map-pin-line"></i></span>
                        <div>
                            <p class="text-sm font-semibold text-[#1A3A0F]">г. Гомель, ул. Советская, 112</p>
                            <p class="text-xs text-[#6B7B5A] mt-0.5">Работаем ежедневно 8:00 — 20:00</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#4A7C2A]/10 text-[#4A7C2A] flex-shrink-0 mt-0.5" aria-hidden="true"><i class="ri-car-line"></i></span>
                        <div>
                            <p class="text-sm font-semibold text-[#1A3A0F]">Бесплатная парковка</p>
                            <p class="text-xs text-[#6B7B5A] mt-0.5">Парковка у входа, 20 мест</p>
                        </div>
                    </li>
                </ul>

                <div class="mt-8">
                    <p class="text-xs font-semibold text-[#6B7B5A] uppercase tracking-wider mb-3">Мы в социальных сетях</p>
                    <div class="flex items-center gap-2">
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-[#DDD6C8] text-[#4A7C2A] hover:bg-[#2D5016] hover:text-white hover:border-[#2D5016] transition-all duration-200" aria-label="Instagram"><i class="ri-instagram-line" aria-hidden="true"></i></a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-[#DDD6C8] text-[#4A7C2A] hover:bg-[#2D5016] hover:text-white hover:border-[#2D5016] transition-all duration-200" aria-label="Telegram"><i class="ri-telegram-line" aria-hidden="true"></i></a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-[#DDD6C8] text-[#4A7C2A] hover:bg-[#2D5016] hover:text-white hover:border-[#2D5016] transition-all duration-200" aria-label="ВКонтакте"><i class="ri-vk-line" aria-hidden="true"></i></a>
                        <a href="https://t.me/m93458" target="_blank" rel="nofollow noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-[#DDD6C8] text-[#229ED9] hover:bg-[#229ED9] hover:text-white hover:border-[#229ED9] transition-all duration-200" aria-label="Telegram"><i class="ri-telegram-line" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white border border-[#DDD6C8] rounded-2xl p-8">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#2D5016]/10 text-[#2D5016]" aria-hidden="true"><i class="ri-mail-send-line"></i></span>
                        <h2 class="text-xl font-extrabold text-[#1A3A0F]">Написать нам</h2>
                    </div>
                    <p class="text-sm text-[#6B7B5A] leading-relaxed mb-6">
                        Есть вопрос о продукции, хотите оформить крупный заказ или наладить регулярные поставки? Заполните
                        форму — мы ответим в течение нескольких часов.
                    </p>

                    <form data-readdy-form="true" data-fitahata-form="true" data-form-type="contacts" id="contacts-main-form" method="post" action="#" class="flex flex-col gap-5">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-[#6B7B5A] uppercase tracking-wider mb-1.5" for="contact-name">Имя *</label>
                                <input id="contact-name" class="w-full bg-[#F8F6F0] border border-[#DDD6C8] rounded-xl px-4 py-3 text-sm text-[#1A3A0F] placeholder-[#B5BAA8] outline-none focus:border-[#4A7C2A] focus:ring-2 focus:ring-[#4A7C2A]/20 transition" type="text" name="name" required
                                    placeholder="Ваше имя" autocomplete="name">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-[#6B7B5A] uppercase tracking-wider mb-1.5" for="contact-phone">Телефон *</label>
                                <input id="contact-phone" class="w-full bg-[#F8F6F0] border border-[#DDD6C8] rounded-xl px-4 py-3 text-sm text-[#1A3A0F] placeholder-[#B5BAA8] outline-none focus:border-[#4A7C2A] focus:ring-2 focus:ring-[#4A7C2A]/20 transition" type="tel" name="phone" required
                                    placeholder="+375 (29) ___-__-__" autocomplete="tel">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#6B7B5A] uppercase tracking-wider mb-1.5" for="contact-email">Email</label>
                            <input id="contact-email" class="w-full bg-[#F8F6F0] border border-[#DDD6C8] rounded-xl px-4 py-3 text-sm text-[#1A3A0F] placeholder-[#B5BAA8] outline-none focus:border-[#4A7C2A] focus:ring-2 focus:ring-[#4A7C2A]/20 transition" type="email" name="email"
                                placeholder="ваш@email.com" autocomplete="email">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#6B7B5A] uppercase tracking-wider mb-1.5" for="contact-topic">Тема обращения</label>
                            <div class="relative">
                                <select id="contact-topic" class="w-full bg-[#F8F6F0] border border-[#DDD6C8] rounded-xl px-4 py-3 text-sm text-[#1A3A0F] outline-none focus:border-[#4A7C2A] focus:ring-2 focus:ring-[#4A7C2A]/20 transition appearance-none cursor-pointer" name="topic">
                                    <option value="">Выберите тему...</option>
                                    <option value="Вопрос о продукции">Вопрос о продукции</option>
                                    <option value="Оформление заказа">Оформление заказа</option>
                                    <option value="Подписка на поставки">Подписка на поставки</option>
                                    <option value="Сотрудничество (рестораны)">Сотрудничество (рестораны)</option>
                                    <option value="Другое">Другое</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-semibold text-[#6B7B5A] uppercase tracking-wider" for="contact-message">Сообщение *</label>
                                <span class="text-xs text-[#9A9E8F]" data-contacts-charcount>0/500</span>
                            </div>
                            <textarea id="contact-message" class="w-full bg-[#F8F6F0] border border-[#DDD6C8] rounded-xl px-4 py-3 text-sm text-[#1A3A0F] placeholder-[#B5BAA8] outline-none focus:border-[#4A7C2A] focus:ring-2 focus:ring-[#4A7C2A]/20 transition resize-none" name="message" required rows="5"
                                maxlength="500" placeholder="Опишите ваш вопрос или пожелание..."></textarea>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-4 pt-1">
                            <p class="text-xs text-[#9A9E8F] leading-snug">
                                Нажимая кнопку, вы соглашаетесь с
                                <a href="#" class="text-[#4A7C2A] font-bold hover:underline">политикой конфиденциальности</a>
                            </p>
                            <button type="submit" class="inline-flex items-center gap-2 bg-[#2D5016] text-white rounded-xl px-6 py-3 text-sm font-bold hover:bg-[#1A3A0F] transition-colors whitespace-nowrap cursor-pointer">
                                <span aria-hidden="true"><i class="ri-send-plane-fill"></i></span>
                                Отправить сообщение
                            </button>
                        </div>
                        <p data-form-status class="text-sm"></p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ: нативные details/summary --}}
    <section class="py-16 bg-white" aria-labelledby="contacts-faq-title">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
            <div class="max-w-2xl mx-auto">
                <header class="text-center mb-10">
                    <h2 id="contacts-faq-title" class="text-2xl sm:text-3xl font-extrabold text-[#1A3A0F] mb-2">Часто задаваемые вопросы</h2>
                    <p class="text-sm text-[#6B7B5A]">Не нашли ответ? Напишите нам через форму выше.</p>
                </header>
                <div class="flex flex-col gap-3">
                    <details class="group bg-[#F8F6F0] border border-[#DDD6C8] rounded-2xl overflow-hidden">
                        <summary class="flex items-center justify-between gap-4 px-6 py-4 text-sm font-bold text-[#1A3A0F] cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                            <span>Как быстро доставляется заказ?</span>
                            <span class="flex-shrink-0 transition-transform duration-200 group-open:rotate-45" aria-hidden="true"><i class="ri-add-line text-[#4A7C2A]"></i></span>
                        </summary>
                        <div class="px-6 pb-5 text-sm text-[#6B7B5A] leading-relaxed">
                            <p>Обычно доставка по Гомелю занимает 2–4 часа в день сбора. Точное время согласуем при оформлении.</p>
                        </div>
                    </details>
                    <details class="group bg-[#F8F6F0] border border-[#DDD6C8] rounded-2xl overflow-hidden">
                        <summary class="flex items-center justify-between gap-4 px-6 py-4 text-sm font-bold text-[#1A3A0F] cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                            <span>Есть ли минимальная сумма заказа?</span>
                            <span class="flex-shrink-0 transition-transform duration-200 group-open:rotate-45" aria-hidden="true"><i class="ri-add-line text-[#4A7C2A]"></i></span>
                        </summary>
                        <div class="px-6 pb-5 text-sm text-[#6B7B5A] leading-relaxed">
                            <p>Условия зависят от набора и объёма — напишите или позвоните, подскажем по вашему заказу.</p>
                        </div>
                    </details>
                    <details class="group bg-[#F8F6F0] border border-[#DDD6C8] rounded-2xl overflow-hidden">
                        <summary class="flex items-center justify-between gap-4 px-6 py-4 text-sm font-bold text-[#1A3A0F] cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                            <span>Можно ли оформить подписку на регулярные поставки?</span>
                            <span class="flex-shrink-0 transition-transform duration-200 group-open:rotate-45" aria-hidden="true"><i class="ri-add-line text-[#4A7C2A]"></i></span>
                        </summary>
                        <div class="px-6 pb-5 text-sm text-[#6B7B5A] leading-relaxed">
                            <p>Да, доступна подписка с гибким набором и графиком. Оставьте заявку в форме — обсудим детали.</p>
                        </div>
                    </details>
                    <details class="group bg-[#F8F6F0] border border-[#DDD6C8] rounded-2xl overflow-hidden">
                        <summary class="flex items-center justify-between gap-4 px-6 py-4 text-sm font-bold text-[#1A3A0F] cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                            <span>Работаете ли вы с ресторанами?</span>
                            <span class="flex-shrink-0 transition-transform duration-200 group-open:rotate-45" aria-hidden="true"><i class="ri-add-line text-[#4A7C2A]"></i></span>
                        </summary>
                        <div class="px-6 pb-5 text-sm text-[#6B7B5A] leading-relaxed">
                            <p>Да, поставляем кафе и ресторанам. В теме обращения выберите «Сотрудничество (рестораны)».</p>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </section>

    {{-- Нижний CTA --}}
    <section class="py-14 bg-[#1A3A0F] text-white" aria-label="Призыв к действию">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-extrabold mb-1">Готовы попробовать свежую микрозелень?</h2>
                <p class="text-sm text-white/60">Первый заказ со скидкой 10%. Доставка по Гомелю за 2–4 часа.</p>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
                <a class="inline-flex items-center gap-2 bg-white text-[#1A3A0F] rounded-full px-6 py-3 text-sm font-bold hover:bg-[#B8D4A8] transition-colors whitespace-nowrap" href="{{ route('home') }}#catalog">
                    <span aria-hidden="true"><i class="ri-shopping-basket-line"></i></span>
                    Смотреть каталог
                </a>
                <a class="inline-flex items-center gap-2 border border-white/30 text-white rounded-full px-6 py-3 text-sm font-bold hover:bg-white/10 transition-colors whitespace-nowrap" href="tel:+375291234567">
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

        (function () {
            var form = document.querySelector('[data-fitahata-form="true"][data-form-type="contacts"]');
            if (!form) return;

            function setStatus(message, isError) {
                var status = form.querySelector('[data-form-status]');
                if (!status) return;
                status.textContent = message || '';
                status.className = 'text-sm ' + (isError ? 'text-red-600' : 'text-green-600');
            }

            form.addEventListener('submit', async function (event) {
                event.preventDefault();

                var submitButton = form.querySelector('[type="submit"]');
                if (submitButton) submitButton.disabled = true;
                setStatus('', false);

                try {
                    var formData = new FormData(form);
                    formData.append('form_type', 'contacts');
                    formData.append('page_url', window.location.href);

                    var response = await fetch('{{ route('forms.submit') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(Object.fromEntries(formData.entries()))
                    });
                    var result = await response.json();
                    if (!response.ok) {
                        throw new Error(result.message || 'Не удалось отправить форму.');
                    }

                    form.reset();
                    var count = document.querySelector('[data-contacts-charcount]');
                    if (count) count.textContent = '0/500';
                    setStatus('Сообщение отправлено в Telegram.', false);
                } catch (error) {
                    setStatus(error.message || 'Ошибка отправки.', true);
                } finally {
                    if (submitButton) submitButton.disabled = false;
                }
            });
        })();
    </script>
@endpush
