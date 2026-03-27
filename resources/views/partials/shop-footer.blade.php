{{-- Футер магазина (layouts.shop); скрыть: @section('hide_shop_footer') @endsection в дочернем view --}}
<footer class="bg-[#F0EBE0] border-t border-[#DDD6C8]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8">
            <div class="lg:col-span-3">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 flex items-center justify-center bg-[#2D5016] rounded-lg"><i class="ri-leaf-fill text-white text-base"></i></div>
                    <span class="text-xl font-extrabold text-[#1A3A0F] tracking-wide">FITAHATA</span>
                </a>
                <p class="text-sm text-[#556546] leading-relaxed mb-6">Свежая фермерская микрозелень с доставкой по Гомелю. Выращиваем с заботой — доставляем за 24 часа.</p>
                <div class="flex items-center gap-2 mb-8">
                    <a href="#" aria-label="Instagram" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-[#DDD6C8] text-[#4A7C2A] hover:bg-[#2D5016] hover:text-white hover:border-[#2D5016] transition-all"><i class="ri-instagram-line" aria-hidden="true"></i></a>
                    <a href="https://t.me/m93458" target="_blank" rel="nofollow noopener noreferrer" aria-label="Написать в Telegram" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-[#DDD6C8] text-[#0C6BAE] hover:bg-[#0C6BAE] hover:text-white hover:border-[#0C6BAE] transition-all"><i class="ri-telegram-line" aria-hidden="true"></i></a>
                </div>
                <ul class="flex flex-col gap-2">
                    <li><a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 text-sm text-[#556546] hover:text-[#2D5016] transition-colors"><i class="ri-arrow-right-s-line text-[#4A7C2A]"></i>Каталог</a></li>
                    <li><a href="{{ route('contacts') }}" class="inline-flex items-center gap-2 text-sm text-[#556546] hover:text-[#2D5016] transition-colors"><i class="ri-arrow-right-s-line text-[#4A7C2A]"></i>Контакты</a></li>
                </ul>
            </div>
            <div class="lg:col-span-3">
                <h3 class="flex items-center gap-2 text-base font-bold text-[#1A3A0F] mb-6"><i class="ri-contacts-line text-[#4A7C2A]"></i>Контакты</h3>
                <ul class="flex flex-col gap-5">
                    <li class="flex items-start gap-3">
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#4A7C2A]/10 text-[#4A7C2A] flex-shrink-0"><i class="ri-map-pin-2-line"></i></span>
                        <div><p class="text-xs text-[#4F5448] mb-0.5">Адрес</p><a href="https://www.google.com/maps/search/?api=1&amp;query={{ urlencode(config('shop.address_full')) }}" class="text-sm font-semibold text-[#1A3A0F] hover:text-[#4A7C2A] transition-colors">{{ config('shop.address_full') }}</a></div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#4A7C2A]/10 text-[#4A7C2A] flex-shrink-0"><i class="ri-phone-line"></i></span>
                        <div><p class="text-xs text-[#4F5448] mb-0.5">Телефон</p>@foreach (config('shop.phones') as $phone)<a href="tel:{{ $phone['tel'] }}" class="text-sm font-semibold text-[#1A3A0F] hover:text-[#4A7C2A] transition-colors @if (! $loop->first) block mt-1 @endif">{{ $phone['display'] }}</a>@endforeach</div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#4A7C2A]/10 text-[#4A7C2A] flex-shrink-0"><i class="ri-mail-line"></i></span>
                        <div><p class="text-xs text-[#4F5448] mb-0.5">Email</p><a href="mailto:{{ config('shop.email') }}" class="text-sm font-semibold text-[#1A3A0F] hover:text-[#4A7C2A] transition-colors">{{ config('shop.email') }}</a></div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#4A7C2A]/10 text-[#4A7C2A] flex-shrink-0"><i class="ri-time-line"></i></span>
                        <div><p class="text-xs text-[#4F5448] mb-0.5">Режим работы</p><span class="text-sm font-semibold text-[#1A3A0F]">Пн–Вс: 8:00 — 20:00</span></div>
                    </li>
                </ul>
            </div>
            <div class="lg:col-span-6">
                <h3 class="flex items-center gap-2 text-base font-bold text-[#1A3A0F] mb-2"><i class="ri-mail-send-line text-[#4A7C2A]"></i>Написать нам</h3>
                <p class="text-sm text-[#556546] leading-relaxed mb-6">Есть вопросы о продукте или хотите оформить крупный заказ? Мы ответим быстро.</p>
                <form id="shopFooterForm" data-readdy-form="true" data-fitahata-form="true" data-form-type="footer_shop" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="footer-name" class="block text-xs font-semibold text-[#556546] uppercase tracking-wider mb-1.5">Имя *</label>
                            <input id="footer-name" required placeholder="Ваше имя" class="w-full bg-white border border-[#DDD6C8] rounded-xl px-4 py-3 text-sm text-[#1A3A0F] placeholder-[#B5BAA8] outline-none focus:border-[#4A7C2A] focus:ring-2 focus:ring-[#4A7C2A]/20 transition" type="text" name="name">
                        </div>
                        <div>
                            <label for="footer-phone" class="block text-xs font-semibold text-[#556546] uppercase tracking-wider mb-1.5">Телефон *</label>
                            <input id="footer-phone" required placeholder="+375 (29) ___-__-__" class="w-full bg-white border border-[#DDD6C8] rounded-xl px-4 py-3 text-sm text-[#1A3A0F] placeholder-[#B5BAA8] outline-none focus:border-[#4A7C2A] focus:ring-2 focus:ring-[#4A7C2A]/20 transition" type="tel" name="phone">
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="footer-message" class="block text-xs font-semibold text-[#556546] uppercase tracking-wider">Сообщение *</label>
                            <span class="text-xs text-[#555A52]" id="footerCharCount">0/500</span>
                        </div>
                        <textarea id="footer-message" name="message" required rows="3" maxlength="500" placeholder="Напишите ваш вопрос или пожелание..." class="w-full bg-white border border-[#DDD6C8] rounded-xl px-4 py-3 text-sm text-[#1A3A0F] placeholder-[#B5BAA8] outline-none focus:border-[#4A7C2A] focus:ring-2 focus:ring-[#4A7C2A]/20 transition resize-none"></textarea>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-4 pt-1">
                        <p class="text-xs text-[#555A52] leading-snug">Нажимая кнопку, вы соглашаетесь с <a href="#" class="text-[#2D5016] font-bold hover:underline">политикой конфиденциальности</a></p>
                        <button type="submit" class="inline-flex items-center gap-2 bg-[#2D5016] text-white rounded-xl px-6 py-3 text-sm font-bold hover:bg-[#1A3A0F] transition-colors whitespace-nowrap cursor-pointer"><i class="ri-send-plane-line"></i>Отправить</button>
                    </div>
                    <p data-form-status class="text-sm"></p>
                </form>
            </div>
        </div>
    </div>
    <div class="bg-[#E8E2D5] border-t border-[#DDD6C8]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-sm text-[#454843]">&copy; FITAHATA 2026. Все права защищены.</p>
            <div class="flex items-center gap-5">
                <a href="#" class="text-sm text-[#454843] hover:text-[#2D5016] transition-colors">Политика конфиденциальности</a>
                <span class="w-1 h-1 rounded-full bg-[#C5D9B0]"></span>
                <a href="#" class="text-sm text-[#454843] hover:text-[#2D5016] transition-colors">Пользовательское соглашение</a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 pb-5 pt-0 border-t border-[#DDD6C8]/70">
            <div class="pt-4">
                @include('partials.site-credits')
            </div>
        </div>
    </div>
</footer>
