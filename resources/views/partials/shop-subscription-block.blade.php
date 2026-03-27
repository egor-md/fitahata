{{--
  Подписка: периодичность (radio) + форма в одном <form>, уходит в forms.submit.
  Параметры: subscriptionTitle, subscriptionLead, subscriptionProduct
--}}
@php
    $subscriptionBadge = $subscriptionBadge ?? 'Постоянным покупателям';
@endphp
<section id="subscription" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <header class="text-center mb-12">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-[#2D5016]/10 text-[#2D5016] text-xs font-bold uppercase tracking-wider mb-4">{{ $subscriptionBadge }}</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1A1A1A] mb-3">{{ $subscriptionTitle }}</h2>
            <p class="text-sm sm:text-base text-[#5A6B4A] max-w-2xl mx-auto">{{ $subscriptionLead }}</p>
        </header>
        <form data-readdy-form="true" data-fitahata-form="true" data-form-type="subscription" method="post" action="#" class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
            @csrf
            <input type="hidden" name="product" value="{{ $subscriptionProduct }}">
            <div>
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-[#1A1A1A] mb-4">Выберите периодичность</h3>
                    <fieldset class="flex flex-col gap-3 border-0 p-0 m-0">
                        <legend class="sr-only">Периодичность доставки</legend>
                        <label class="flex items-center gap-4 w-full px-5 py-4 rounded-2xl border-2 border-[#EDE8DC] bg-[#FAFAF7] text-left cursor-pointer transition-colors hover:border-[#C5D9B0] has-[:checked]:border-[#2D5016] has-[:checked]:bg-[#E8F0E0]">
                            <input type="radio" name="subscription_frequency" value="weekly" class="peer sr-only">
                            <span class="w-5 h-5 rounded-full border-2 border-[#C5D9B0] shrink-0 peer-checked:border-[#2D5016] peer-checked:bg-[#2D5016]" aria-hidden="true"></span>
                            <span class="flex-1 min-w-0">
                                <span class="block text-sm font-semibold text-[#1A1A1A]">Каждую неделю</span>
                                <span class="block text-xs text-[#5C5F58]">1 раз в неделю</span>
                            </span>
                            <span class="flex items-center gap-2 shrink-0">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-[#FEF3C7] text-[#B45309] text-xs font-bold">Популярно</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-[#D1FAE5] text-[#065F46] text-xs font-bold">−15%</span>
                            </span>
                        </label>
                        <label class="flex items-center gap-4 w-full px-5 py-4 rounded-2xl border-2 border-[#EDE8DC] bg-[#FAFAF7] text-left cursor-pointer transition-colors hover:border-[#C5D9B0] has-[:checked]:border-[#2D5016] has-[:checked]:bg-[#E8F0E0]">
                            <input type="radio" name="subscription_frequency" value="biweekly" class="peer sr-only" checked required>
                            <span class="w-5 h-5 rounded-full border-2 border-[#C5D9B0] shrink-0 peer-checked:border-[#2D5016] peer-checked:bg-[#2D5016]" aria-hidden="true"></span>
                            <span class="flex-1 min-w-0">
                                <span class="block text-sm font-semibold text-[#1A1A1A]">Раз в 2 недели</span>
                                <span class="block text-xs text-[#5C5F58]">2 раза в месяц</span>
                            </span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-[#D1FAE5] text-[#065F46] text-xs font-bold">−10%</span>
                        </label>
                        <label class="flex items-center gap-4 w-full px-5 py-4 rounded-2xl border-2 border-[#EDE8DC] bg-[#FAFAF7] text-left cursor-pointer transition-colors hover:border-[#C5D9B0] has-[:checked]:border-[#2D5016] has-[:checked]:bg-[#E8F0E0]">
                            <input type="radio" name="subscription_frequency" value="monthly" class="peer sr-only">
                            <span class="w-5 h-5 rounded-full border-2 border-[#C5D9B0] shrink-0 peer-checked:border-[#2D5016] peer-checked:bg-[#2D5016]" aria-hidden="true"></span>
                            <span class="flex-1 min-w-0">
                                <span class="block text-sm font-semibold text-[#1A1A1A]">Раз в месяц</span>
                                <span class="block text-xs text-[#5C5F58]">1 раз в месяц</span>
                            </span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-[#D1FAE5] text-[#065F46] text-xs font-bold">−5%</span>
                        </label>
                    </fieldset>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-[#FAFAF7]">
                        <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-[#E8F0E0] text-[#2D5016] flex-shrink-0" aria-hidden="true"><i class="ri-calendar-check-line text-lg"></i></span>
                        <div>
                            <div class="text-sm font-bold text-[#1A1A1A]">Регулярные поставки</div>
                            <p class="text-xs text-[#5A6B4A] mt-0.5">Без лишних заказов и звонков — всё по расписанию</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-[#FAFAF7]">
                        <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-[#E8F0E0] text-[#2D5016] flex-shrink-0" aria-hidden="true"><i class="ri-percent-line text-lg"></i></span>
                        <div>
                            <div class="text-sm font-bold text-[#1A1A1A]">Скидка для подписчиков</div>
                            <p class="text-xs text-[#5A6B4A] mt-0.5">До 15% от стандартной цены каждый заказ</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-[#FAFAF7]">
                        <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-[#E8F0E0] text-[#2D5016] flex-shrink-0" aria-hidden="true"><i class="ri-settings-3-line text-lg"></i></span>
                        <div>
                            <div class="text-sm font-bold text-[#1A1A1A]">Индивидуальный набор</div>
                            <p class="text-xs text-[#5A6B4A] mt-0.5">Выбирайте культуры под свой вкус и рацион</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-[#FAFAF7]">
                        <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-[#E8F0E0] text-[#2D5016] flex-shrink-0" aria-hidden="true"><i class="ri-flashlight-line text-lg"></i></span>
                        <div>
                            <div class="text-sm font-bold text-[#1A1A1A]">Приоритетная доставка</div>
                            <p class="text-xs text-[#5A6B4A] mt-0.5">Первыми получаете свежий сбор каждое утро</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-[#1A3A0F] rounded-3xl p-8 overflow-hidden relative">
                <div class="absolute -top-20 -right-20 w-60 h-60 rounded-full bg-[#2D5016]/30 blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-60 h-60 rounded-full bg-[#4A7C2A]/20 blur-3xl"></div>
                <div class="relative">
                    <h3 class="text-xl font-bold text-white mb-2">Оформить подписку</h3>
                    <p class="text-sm text-[#B8D4A8] mb-6">Заполните форму — мы свяжемся и согласуем всё удобно для вас</p>
                    <div class="flex flex-col gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-[#B8D4A8] uppercase tracking-wider mb-1.5" for="shop-sub-name">Ваше имя</label>
                            <input id="shop-sub-name" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-sm text-white placeholder-white/40 outline-none focus:border-[#B8D4A8] focus:ring-2 focus:ring-[#B8D4A8]/20 transition" type="text" name="sub_name" required
                                placeholder="Иван Иванов" autocomplete="name">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#B8D4A8] uppercase tracking-wider mb-1.5" for="shop-sub-phone">Телефон</label>
                            <input id="shop-sub-phone" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-sm text-white placeholder-white/40 outline-none focus:border-[#B8D4A8] focus:ring-2 focus:ring-[#B8D4A8]/20 transition" type="tel" name="sub_phone" required
                                placeholder="+375 29 000-00-00" autocomplete="tel">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#B8D4A8] uppercase tracking-wider mb-1.5" for="shop-sub-email">Email</label>
                            <input id="shop-sub-email" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-sm text-white placeholder-white/40 outline-none focus:border-[#B8D4A8] focus:ring-2 focus:ring-[#B8D4A8]/20 transition" type="email" name="email"
                                placeholder="mail@example.com" autocomplete="email">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#B8D4A8] uppercase tracking-wider mb-1.5" for="shop-sub-addr">Адрес доставки в Гомеле</label>
                            <input id="shop-sub-addr" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-sm text-white placeholder-white/40 outline-none focus:border-[#B8D4A8] focus:ring-2 focus:ring-[#B8D4A8]/20 transition" type="text" name="sub_address"
                                placeholder="ул. Паромная, 2" autocomplete="street-address">
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-full bg-white text-[#1A3A0F] text-sm font-bold hover:bg-[#E8F0E0] transition-colors cursor-pointer mt-2">
                            Оформить подписку <i class="ri-arrow-right-line" aria-hidden="true"></i>
                        </button>
                        <p data-form-status class="text-sm text-white/90"></p>
                        <p class="text-center text-xs text-white/90">Отменить можно в любой момент</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@once
@push('scripts')
    <script>
        (function () {
            var subscriptionForm = document.querySelector('[data-fitahata-form="true"][data-form-type="subscription"]');
            if (!subscriptionForm) return;

            function setSubscriptionStatus(message, isError) {
                var status = subscriptionForm.querySelector('[data-form-status]');
                if (!status) return;
                status.textContent = message || '';
                status.className = 'text-sm ' + (isError ? 'text-red-300' : 'text-white/90');
            }

            subscriptionForm.addEventListener('submit', async function (event) {
                event.preventDefault();

                var submitButton = subscriptionForm.querySelector('[type="submit"]');
                if (submitButton) submitButton.disabled = true;
                setSubscriptionStatus('', false);

                try {
                    var formData = new FormData(subscriptionForm);
                    formData.append('form_type', 'subscription');
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

                    subscriptionForm.reset();
                    setSubscriptionStatus('Заявка отправлена в Telegram.', false);
                } catch (error) {
                    setSubscriptionStatus(error.message || 'Ошибка отправки.', true);
                } finally {
                    if (submitButton) submitButton.disabled = false;
                }
            });
        })();
    </script>
@endpush
@endonce
