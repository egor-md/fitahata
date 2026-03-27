@extends('layouts.shop')

@section('title', 'FitaHata, Главная')
@section('meta_description', 'Свежая микрозелень FITAHATA в Гомеле: популярные культуры, польза, доставка в день сбора и простые рецепты.')

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
                    <img src="./images/landing-microgreens.webp" alt="Микрозелень в керамической миске" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

<section id="catalog" class="bg-[#FAFAF7] py-16 sm:py-20 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#E8F5D9] text-xs text-[#2D5016] font-medium mb-3">
                    <span>Каталог</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#1A1A1A]">Популярные культуры</h2>
                <p class="text-[#6B6B6B] text-sm sm:text-base mt-2">Свежий сбор каждое утро, доставка в день заказа</p>
            </div>
            <a class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-[#E8E3D8] text-sm font-semibold text-[#2D5016] hover:bg-[#2D5016] hover:text-white transition-colors" href="{{ route('catalog') }}" aria-label="Перейти к каталогу микрозелени">
                Весь каталог
                <i class="ri-arrow-right-line" aria-hidden="true"></i>
            </a>
        </div>
        <div id="homeProductGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @forelse(($catalogItems ?? []) as $item)
            @php
                $badge = trim((string) ($item['badge'] ?? ''));
                $badgeBg = match($badge) {
                    'Хит' => 'bg-[#92400e]',
                    'Новинка' => 'bg-[#047857]',
                    'Выгода' => 'bg-[#2563eb]',
                    'Редкость' => 'bg-[#9333ea]',
                    default => 'bg-[#2D5016]',
                };
                $fullStars = $item['rating'] ? (int) floor($item['rating']) : 0;
                $emptyStars = 5 - $fullStars;
            @endphp
            <div class="custom_card product-card bg-white rounded-3xl overflow-hidden group transition-all duration-300 hover:-translate-y-1.5 border border-transparent hover:border-[#E8E3D8]"
                 data-id="{{ $item['id'] }}"
                 data-name="{{ $item['title'] }}"
                 data-price="{{ $item['price_raw'] }}"
                 data-price-display="{{ $item['price'] }}"
                 data-image="{{ $item['image_card_src'] }}"
                 data-slug="{{ $item['slug'] }}"
                 data-weight="{{ $item['weight'] }}"
                 data-category="{{ $item['category'] }}"
                 data-rating="{{ $item['rating'] ?? 0 }}"
            >
                <div class="relative overflow-hidden" style="padding-top:100%">
                    <a href="{{ route('article.show', $item['slug']) }}" class="absolute inset-0 w-full h-full block">
                        <picture>
                            @if(!empty($item['image_card_srcset']))
                            <source type="image/webp" srcset="{{ $item['image_card_srcset'] }}" sizes="(min-width: 1024px) 283px, (min-width: 768px) 33vw, 50vw">
                            @endif
                            <img alt="{{ $item['title'] }}" class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105" src="{{ $item['image_card_src'] }}" width="300" height="300" loading="lazy">
                        </picture>
                    </a>
                    @if($badge)
                    <span class="absolute top-3 left-3 {{ $badgeBg }} text-white text-xs font-semibold px-3 py-1 rounded-full pointer-events-none">{{ $badge }}</span>
                    @endif
                    @if($item['rating'])
                    <div class="absolute bottom-3 right-3 flex items-center gap-1 bg-white/90 backdrop-blur-sm rounded-full px-2.5 py-1 pointer-events-none">
                        <i class="ri-star-fill text-xs text-[#E8C547]"></i>
                        <span class="text-xs font-semibold text-[#1A1A1A]">{{ number_format($item['rating'], 1) }}</span>
                    </div>
                    @endif
                </div>
                <div class="p-2 sm:p-4 flex flex-col gap-2">
                    <div>
                        <div class="flex items-start justify-between gap-2 mb-1">
                            <a href="{{ route('article.show', $item['slug']) }}" class="text-base font-bold text-[#1A1A1A] leading-tight hover:text-[#2D5016] transition-colors">{{ $item['title'] }}</a>
                            @if($item['weight'])
                            <span class="text-xs text-[#767676] whitespace-nowrap mt-0.5">{{ $item['weight'] }}</span>
                            @endif
                        </div>
                        @if($item['subtitle'])
                        <p class="text-xs text-[#666666] leading-relaxed">{{ $item['subtitle'] }}</p>
                        @endif
                        <!-- @if($item['benefit'])
                        <p class="text-xs text-[#2D5016] font-medium mt-0.5">{{ $item['benefit'] }}</p>
                        @endif -->
                    </div>
                    @if(!empty($item['tags']))
                    <div class="flex flex-wrap gap-1">
                        @foreach(array_slice($item['tags'], 0, 3) as $tag)
                        <span class="text-xs bg-[#F5F1E8] text-[#48602E] px-2 py-0.5 rounded-full">{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif
                    <!-- @if($item['rating'])
                    <div class="flex items-center gap-1">
                        @for($i = 0; $i < $fullStars; $i++)
                        <i class="ri-star-fill text-xs text-[#E8C547]"></i>
                        @endfor
                        @for($i = 0; $i < $emptyStars; $i++)
                        <i class="ri-star-line text-xs text-[#D0D0D0]"></i>
                        @endfor
                        @if($item['reviews_count'])
                        <span class="text-xs text-[#9A9A9A] ml-1">{{ $item['reviews_count'] }} отзывов</span>
                        @endif
                    </div>
                    @endif -->
                    <div class="mt-1 pt-3 border-t border-[#F0EDE4]">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-center text-lg font-bold text-[#2D5016]">{{ $item['price'] }}</span>
                            @if($item['price_raw'] > 0)
                            <div class="flex items-center gap-2 custom_wel_card">
                                <div class="qty-control flex items-center gap-1 border border-[#E8E3D8] rounded-full overflow-hidden">
                                    <button type="button" aria-label="Уменьшить количество" class="qty-minus w-7 h-7 flex items-center justify-center text-[#2D5016] hover:bg-[#F5F1E8] transition-colors cursor-pointer"><i class="ri-subtract-line text-sm" aria-hidden="true"></i></button>
                                    <span class="qty-value text-sm font-semibold text-[#1A1A1A] w-5 text-center select-none">1</span>
                                    <button type="button" aria-label="Увеличить количество" class="qty-plus w-7 h-7 flex items-center justify-center text-[#2D5016] hover:bg-[#F5F1E8] transition-colors cursor-pointer"><i class="ri-add-line text-sm" aria-hidden="true"></i></button>
                                </div>
                                <button type="button" class="add-to-cart flex items-center gap-1.5 px-3 py-2 rounded-full text-xs font-semibold whitespace-nowrap transition-all duration-300 cursor-pointer bg-[#2D5016] text-white hover:bg-[#1A3A0F]">
                                    <i class="ri-shopping-cart-2-line text-xs"></i>В корзину
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="col-span-full text-center text-[#6B6B6B] py-12">Каталог пока пуст. Добавьте растения в разделе админки «Растения».</p>
            @endforelse
        </div>
        <div class="flex justify-center mt-10">
            <button class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-[#E8E3D8] text-sm font-semibold text-[#6B6B6B] hover:border-[#2D5016] hover:text-[#2D5016] transition-colors" type="button">
                <i class="ri-customer-service-line" aria-hidden="true"></i>
                Связаться с нами
            </button>
        </div>
    </div>
</section>

<section id="benefits" class="bg-white py-16 sm:py-20 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#E8F5D9] text-xs text-[#2D5016] font-medium mb-3">
                <i class="ri-seedling-line" aria-hidden="true"></i>
                <span>Польза</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#1A1A1A]">Почему микрозелень?</h2>
            <p class="text-[#6B6B6B] text-sm sm:text-base mt-3 max-w-xl mx-auto">
                Концентрат витаминов, минералов и антиоксидантов в каждом листочке
            </p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
            <div class="group rounded-3xl p-6 sm:p-8 flex flex-col items-center text-center hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 cursor-default" style="background:#F0F5EB">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center bg-white/70 mb-4 group-hover:scale-110 transition-transform duration-300">
                    <span class="text-2xl font-extrabold text-[#2D5016]">10×</span>
                </div>
                <h3 class="text-sm font-bold text-[#1A1A1A] mb-1">Больше витаминов</h3>
                <p class="text-xs text-[#6B6B6B] leading-relaxed">Чем в зрелых растениях того же вида</p>
            </div>
            <div class="group rounded-3xl p-6 sm:p-8 flex flex-col items-center text-center hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 cursor-default" style="background:#EBF0F5">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center bg-white/70 mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="ri-shield-check-line text-2xl text-[#2D5016]"></i>
                </div>
                <h3 class="text-sm font-bold text-[#1A1A1A] mb-1">Укрепляет иммунитет</h3>
                <p class="text-xs text-[#6B6B6B] leading-relaxed">Антиоксиданты и фитонутриенты защищают организм</p>
            </div>
            <div class="group rounded-3xl p-6 sm:p-8 flex flex-col items-center text-center hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 cursor-default" style="background:#F5F0EB">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center bg-white/70 mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="ri-leaf-line text-2xl text-[#2D5016]"></i>
                </div>
                <h3 class="text-sm font-bold text-[#1A1A1A] mb-1">Натуральный детокс</h3>
                <p class="text-xs text-[#6B6B6B] leading-relaxed">Хлорофилл мягко очищает кровь и выводит токсины</p>
            </div>
            <div class="group rounded-3xl p-6 sm:p-8 flex flex-col items-center text-center hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 cursor-default" style="background:#F5EBF0">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center bg-white/70 mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="ri-heart-pulse-line text-2xl text-[#2D5016]"></i>
                </div>
                <h3 class="text-sm font-bold text-[#1A1A1A] mb-1">Быстрый источник энергии</h3>
                <p class="text-xs text-[#6B6B6B] leading-relaxed">Максимальная биодоступность питательных веществ</p>
            </div>
            <div class="group rounded-3xl p-6 sm:p-8 flex flex-col items-center text-center hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 cursor-default" style="background:#EBECF5">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center bg-white/70 mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="ri-bowl-line text-2xl text-[#2D5016]"></i>
                </div>
                <h3 class="text-sm font-bold text-[#1A1A1A] mb-1">Для любого рациона</h3>
                <p class="text-xs text-[#6B6B6B] leading-relaxed">Подходит вегетарианцам, спортсменам и детям</p>
            </div>
        </div>
        <div class="flex items-center gap-4 mt-10 bg-[#F5F1E8] rounded-2xl p-5 sm:p-6">
            <div class="w-10 h-10 rounded-xl bg-[#2D5016] flex items-center justify-center flex-shrink-0">
                <i class="ri-microscope-line text-white" aria-hidden="true"></i>
            </div>
            <p class="text-sm text-[#6B6B6B] leading-relaxed">
                <strong class="text-[#1A1A1A]">Научный факт:</strong>
                Исследования показывают, что микрозелень содержит в 4–40 раз больше питательных веществ, чем зрелые растения того же вида.
            </p>
        </div>
    </div>
</section>

<section id="delivery" class="bg-[#FAFAF7] py-16 sm:py-20 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            <div class="relative rounded-3xl overflow-hidden">
                <img alt="Доставка микрозелени в Гомеле" class="w-full h-80 sm:h-96 lg:h-[28rem] object-cover" src="./images/2534da8bb9c670d8384dc1505ba9d117.jpg" loading="lazy">
                <div class="absolute bottom-4 left-4 flex items-center gap-3 bg-white/90 backdrop-blur-sm rounded-2xl px-4 py-3 shadow-lg">
                    <div class="w-10 h-10 rounded-xl bg-[#2D5016] flex items-center justify-center flex-shrink-0">
                        <i class="ri-truck-line text-white" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="text-xs text-[#6B6B6B]">Среднее время</div>
                        <div class="text-base font-bold text-[#1A1A1A]">2–4 часа</div>
                    </div>
                </div>
            </div>
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#E8F5D9] text-xs text-[#2D5016] font-medium mb-4">
                    <i class="ri-map-pin-2-line" aria-hidden="true"></i>
                    <span>Доставка</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#1A1A1A] mb-2">
                    Доставка в день сбора
                    <br>
                    <span class="text-[#2D5016]">по Гомелю</span>
                </h2>
                <p class="text-[#6B6B6B] text-sm sm:text-base leading-relaxed mb-8">
                    Сохраняем максимум свежести и пользы. Ваша зелень приедет живой, сочной и готовой к столу.
                </p>
                <div class="flex flex-col gap-5">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#E8F5D9] flex items-center justify-center flex-shrink-0">
                            <i class="ri-knife-line text-[#2D5016]" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-[#1A1A1A]">Доставка в день сбора</h3>
                            <p class="text-xs text-[#6B6B6B] mt-0.5">Срезаем утром — привозим к вашему столу в тот же день</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#E8F5D9] flex items-center justify-center flex-shrink-0">
                            <i class="ri-gift-line text-[#2D5016]" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-[#1A1A1A]">Бесплатно от 15 BYN</h3>
                            <p class="text-xs text-[#6B6B6B] mt-0.5">Или 3 BYN по городу — выбирайте ближайшее время</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#E8F5D9] flex items-center justify-center flex-shrink-0">
                            <i class="ri-time-line text-[#2D5016]" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-[#1A1A1A]">Удобные интервалы</h3>
                            <p class="text-xs text-[#6B6B6B] mt-0.5">Выбирайте время доставки с 10:00 до 21:00</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#E8F5D9] flex items-center justify-center flex-shrink-0">
                            <i class="ri-repeat-line text-[#2D5016]" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-[#1A1A1A]">Возможность подписки</h3>
                            <p class="text-xs text-[#6B6B6B] mt-0.5">Получайте зелень по расписанию без лишних заказов</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3 mt-8">
                    <a class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#2D5016] text-white text-sm font-semibold hover:bg-[#1A3A0F] transition-colors" href="#home-contacts" aria-label="Перейти к контактам для оформления заказа">
                        Оформить заказ
                        <i class="ri-arrow-right-line" aria-hidden="true"></i>
                    </a>
                    <a class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-[#E8E3D8] text-sm font-semibold text-[#1A1A1A] hover:border-[#2D5016] hover:text-[#2D5016] transition-colors" href="#delivery" aria-label="Перейти к условиям доставки">
                        Условия доставки
                        <i class="ri-information-line" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.shop-subscription-block', [
    'subscriptionTitle' => 'Подписка на доставку микрозелени',
    'subscriptionLead' => 'Получайте свежую микрозелень по расписанию — со скидкой до 15% и приоритетной доставкой',
    'subscriptionProduct' => 'Каталог FITAHATA',
])

<section id="why" class="bg-white py-16 sm:py-20 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#E8F5D9] text-xs text-[#2D5016] font-medium mb-3">
                <i class="ri-medal-line" aria-hidden="true"></i>
                <span>Наши преимущества</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#1A1A1A]">Почему выбирают FITAHATA</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
            <div class="group bg-[#FAFAF7] rounded-3xl p-6 sm:p-8 flex flex-col items-center text-center hover:-translate-y-1.5 hover:shadow-lg hover:bg-white transition-all duration-300 cursor-default">
                <div class="w-12 h-12 rounded-2xl bg-[#E8F5D9] flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-[#2D5016] transition-all duration-300">
                    <i class="ri-plant-line text-xl text-[#2D5016] group-hover:text-white transition-colors duration-300" aria-hidden="true"></i>
                </div>
                <h3 class="text-sm font-bold text-[#1A1A1A] mb-1">100% эко-выращивание</h3>
                <p class="text-xs text-[#6B6B6B] leading-relaxed">Закрытые фермы без использования гербецидов и пестицидов</p>
            </div>
            <div class="group bg-[#FAFAF7] rounded-3xl p-6 sm:p-8 flex flex-col items-center text-center hover:-translate-y-1.5 hover:shadow-lg hover:bg-white transition-all duration-300 cursor-default">
                <div class="w-12 h-12 rounded-2xl bg-[#E8F5D9] flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-[#2D5016] transition-all duration-300">
                    <i class="ri-forbid-2-line text-xl text-[#2D5016] group-hover:text-white transition-colors duration-300" aria-hidden="true"></i>
                </div>
                <h3 class="text-sm font-bold text-[#1A1A1A] mb-1">Без химии</h3>
                <p class="text-xs text-[#6B6B6B] leading-relaxed">Только вода, свет и семена. Никаких добавок</p>
            </div>
            <div class="group bg-[#FAFAF7] rounded-3xl p-6 sm:p-8 flex flex-col items-center text-center hover:-translate-y-1.5 hover:shadow-lg hover:bg-white transition-all duration-300 cursor-default">
                <div class="w-12 h-12 rounded-2xl bg-[#E8F5D9] flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-[#2D5016] transition-all duration-300">
                    <i class="ri-user-settings-line text-xl text-[#2D5016] group-hover:text-white transition-colors duration-300" aria-hidden="true"></i>
                </div>
                <h3 class="text-sm font-bold text-[#1A1A1A] mb-1">Выращивание под заказ</h3>
                <p class="text-xs text-[#6B6B6B] leading-relaxed">Сбор только после получения заказа — максимальная свежесть</p>
            </div>
            <div class="group bg-[#FAFAF7] rounded-3xl p-6 sm:p-8 flex flex-col items-center text-center hover:-translate-y-1.5 hover:shadow-lg hover:bg-white transition-all duration-300 cursor-default">
                <div class="w-12 h-12 rounded-2xl bg-[#E8F5D9] flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-[#2D5016] transition-all duration-300">
                    <i class="ri-award-line text-xl text-[#2D5016] group-hover:text-white transition-colors duration-300" aria-hidden="true"></i>
                </div>
                <h3 class="text-sm font-bold text-[#1A1A1A] mb-1">Контроль качества</h3>
                <p class="text-xs text-[#6B6B6B] leading-relaxed">Каждая партия проходит визуальный и вкусовой контроль</p>
            </div>
            <div class="group bg-[#FAFAF7] rounded-3xl p-6 sm:p-8 flex flex-col items-center text-center hover:-translate-y-1.5 hover:shadow-lg hover:bg-white transition-all duration-300 cursor-default">
                <div class="w-12 h-12 rounded-2xl bg-[#E8F5D9] flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-[#2D5016] transition-all duration-300">
                    <i class="ri-map-pin-line text-xl text-[#2D5016] group-hover:text-white transition-colors duration-300" aria-hidden="true"></i>
                </div>
                <h3 class="text-sm font-bold text-[#1A1A1A] mb-1">Локальное производство</h3>
                <p class="text-xs text-[#6B6B6B] leading-relaxed">Выращиваем прямо в Гомеле — от фермы до стола</p>
            </div>
            <div class="group bg-[#FAFAF7] rounded-3xl p-6 sm:p-8 flex flex-col items-center text-center hover:-translate-y-1.5 hover:shadow-lg hover:bg-white transition-all duration-300 cursor-default">
                <div class="w-12 h-12 rounded-2xl bg-[#E8F5D9] flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-[#2D5016] transition-all duration-300">
                    <i class="ri-heart-3-line text-xl text-[#2D5016] group-hover:text-white transition-colors duration-300" aria-hidden="true"></i>
                </div>
                <h3 class="text-sm font-bold text-[#1A1A1A] mb-1">Выращено с заботой</h3>
                <p class="text-xs text-[#6B6B6B] leading-relaxed">Каждый росток — это наша ответственность и любовь</p>
            </div>
        </div>
        <div class="relative bg-[#1A3A0F] rounded-3xl p-8 sm:p-10 lg:p-12 overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-[#2D5016]/30 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-[#4A7C2A]/20 rounded-full blur-3xl"></div>
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                <div class="flex items-center justify-center gap-8 sm:gap-12 lg:gap-16">
                    <div class="text-center">
                        <div class="text-3xl sm:text-4xl font-extrabold text-white">500+</div>
                        <div class="text-xs text-white/60 mt-1">Довольных клиентов</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl sm:text-4xl font-extrabold text-white">24ч</div>
                        <div class="text-xs text-white/60 mt-1">От сбора до доставки</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl sm:text-4xl font-extrabold text-white">100%</div>
                        <div class="text-xs text-white/60 mt-1">Натуральный продукт</div>
                    </div>
                </div>
                <div class="lg:max-w-sm">
                    <p class="text-sm text-white/70 leading-relaxed mb-4">Мы не перепродаём. Каждый лоток микрозелени вырастили мы сами, в нашей ферме, под нашим контролем — с чистыми технологиями и любовью.</p>
                    <a href="#catalog" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-white text-[#1A3A0F] text-sm font-bold hover:bg-[#B8D4A8] transition-colors" aria-label="Перейти в каталог микрозелени">
                        Попробовать сейчас
                        <i class="ri-arrow-right-line" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="cooc" class="bg-[#F5F1E8] py-16 sm:py-20 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="text-center mb-12">
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#E8E3D8] text-xs text-[#5A5A5A] font-medium mb-3">Идеи для кухни</span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#1A1A1A]">Готовим с микрозеленью</h2>
            <p class="text-[#6B6B6B] text-sm sm:text-base mt-3 max-w-xl mx-auto">Простые и вкусные рецепты, которые превратят вашу кухню в маленький ресторан</p>
        </div>
        <div>
            <div id="recipeCard" class="grid grid-cols-1 lg:grid-cols-2 bg-white rounded-3xl overflow-hidden shadow-sm transition-opacity duration-200" aria-live="polite">
                <div class="relative aspect-[4/3] lg:aspect-auto overflow-hidden">
                    <img id="recipeImg" alt="Сэндвич с редисом и творожным сыром" class="w-full h-full object-cover" src="./images/b97422bef2b4c9c4a3cbbf623dfb6ea3.jpg" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    <div id="recipeTagAccent" class="absolute top-4 left-4 px-3 py-1 rounded-full bg-[#556B1A] text-white text-xs font-semibold">Быстрый рецепт</div>
                    <div id="recipeTagGlass" class="absolute top-4 left-36 px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-white text-xs font-medium">Сэндвичи</div>
                </div>
                <div class="custom_recipe_card p-6 sm:p-8 lg:p-10 flex flex-col justify-between">
                    <div>
                        <div class="flex flex-wrap items-center gap-3 mb-4">
                            <div class="flex items-center gap-1.5">
                                <div class="w-7 h-7 rounded-lg bg-[#E8F5D9] flex items-center justify-center">
                                    <i class="ri-time-line text-[#2D5016] text-sm" aria-hidden="true"></i>
                                </div>
                                <span class="recipe-meta-text text-xs text-[#6B6B6B]">7 мин</span>
                            </div>
                            <div class="w-1 h-1 rounded-full bg-[#E8E3D8]" aria-hidden="true"></div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-7 h-7 rounded-lg bg-[#E8F5D9] flex items-center justify-center">
                                    <i class="ri-fire-line text-[#2D5016] text-sm" aria-hidden="true"></i>
                                </div>
                                <span class="recipe-meta-text text-xs text-[#6B6B6B]">290 ккал</span>
                            </div>
                            <div class="w-1 h-1 rounded-full bg-[#E8E3D8]" aria-hidden="true"></div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-7 h-7 rounded-lg bg-[#E8F5D9] flex items-center justify-center">
                                    <i class="ri-bar-chart-line text-[#2D5016] text-sm" aria-hidden="true"></i>
                                </div>
                                <span class="recipe-meta-text text-xs text-[#6B6B6B]">Очень легко</span>
                            </div>
                        </div>
                        <h3 id="recipeTitle" class="text-lg sm:text-xl font-bold text-[#1A1A1A] mb-2">Сэндвич с редисом и творожным сыром</h3>
                        <p id="recipeDesc" class="text-sm text-[#5E5E5E] leading-relaxed mb-6">Хрустящий сэндвич с пряными ростками редиса и нежным творожным сыром. Отличный вариант для быстрого завтрака или перекуса на ходу.</p>
                        <div>
                            <h4 class="text-xs font-bold text-[#1A1A1A] uppercase tracking-wider mb-3">Ингредиенты</h4>
                            <ul id="recipeIngredients" class="flex flex-col gap-2">
                                <li class="flex items-center gap-2 text-sm text-[#6B6B6B]">
                                    <div class="w-6 h-6 rounded-lg bg-[#E8F5D9] flex items-center justify-center flex-shrink-0">
                                        <i class="ri-leaf-line text-[#2D5016] text-xs" aria-hidden="true"></i>
                                    </div>
                                    Микрозелень редиса FITAHATA — 30 г
                                </li>
                                <li class="flex items-center gap-2 text-sm text-[#6B6B6B]">
                                    <div class="w-6 h-6 rounded-lg bg-[#E8F5D9] flex items-center justify-center flex-shrink-0">
                                        <i class="ri-leaf-line text-[#2D5016] text-xs" aria-hidden="true"></i>
                                    </div>
                                    Хлеб на закваске — 2 ломтика
                                </li>
                                <li class="flex items-center gap-2 text-sm text-[#6B6B6B]">
                                    <div class="w-6 h-6 rounded-lg bg-[#E8F5D9] flex items-center justify-center flex-shrink-0">
                                        <i class="ri-leaf-line text-[#2D5016] text-xs" aria-hidden="true"></i>
                                    </div>
                                    Творожный сыр — 60 г
                                </li>
                                <li class="flex items-center gap-2 text-sm text-[#6B6B6B]">
                                    <div class="w-6 h-6 rounded-lg bg-[#E8F5D9] flex items-center justify-center flex-shrink-0">
                                        <i class="ri-leaf-line text-[#2D5016] text-xs" aria-hidden="true"></i>
                                    </div>
                                    Огурец — ½ шт
                                </li>
                                <li class="flex items-center gap-2 text-sm text-[#6B6B6B]">
                                    <div class="w-6 h-6 rounded-lg bg-[#E8F5D9] flex items-center justify-center flex-shrink-0">
                                        <i class="ri-leaf-line text-[#2D5016] text-xs" aria-hidden="true"></i>
                                    </div>
                                    Красный лук — несколько колец
                                </li>
                                <li class="flex items-center gap-2 text-sm text-[#6B6B6B]">
                                    <div class="w-6 h-6 rounded-lg bg-[#E8F5D9] flex items-center justify-center flex-shrink-0">
                                        <i class="ri-leaf-line text-[#2D5016] text-xs" aria-hidden="true"></i>
                                    </div>
                                    Лимонный перец — по вкусу
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 mt-6">
                        <a href="#catalog" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#2D5016] text-white text-sm font-semibold hover:bg-[#1A3A0F] transition-colors">
                            <i class="ri-shopping-basket-line" aria-hidden="true"></i>
                            Купить микрозелень
                        </a>
                        <a href="#cooc" class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-[#E8E3D8] text-sm font-semibold text-[#1A1A1A] hover:border-[#2D5016] hover:text-[#2D5016] transition-colors">
                            Все рецепты
                            <i class="ri-arrow-right-line" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center gap-1 sm:gap-2" role="group" aria-label="Выбор рецепта">
                    <button class="recipe-dot inline-flex h-11 min-h-[44px] w-11 min-w-[44px] shrink-0 items-center justify-center rounded-full touch-manipulation" type="button" aria-label="Рецепт 1" aria-current="true">
                        <span class="recipe-dot-inner block h-2.5 w-2.5 rounded-full bg-[#D4CFC4] transition-[width,background-color] duration-200" aria-hidden="true"></span>
                    </button>
                    <button class="recipe-dot inline-flex h-11 min-h-[44px] w-11 min-w-[44px] shrink-0 items-center justify-center rounded-full touch-manipulation" type="button" aria-label="Рецепт 2">
                        <span class="recipe-dot-inner block h-2.5 w-2.5 rounded-full bg-[#D4CFC4] transition-[width,background-color] duration-200" aria-hidden="true"></span>
                    </button>
                    <button class="recipe-dot inline-flex h-11 min-h-[44px] w-11 min-w-[44px] shrink-0 items-center justify-center rounded-full touch-manipulation" type="button" aria-label="Рецепт 3">
                        <span class="recipe-dot-inner block h-2.5 w-2.5 rounded-full bg-[#D4CFC4] transition-[width,background-color] duration-200" aria-hidden="true"></span>
                    </button>
                    <button class="recipe-dot inline-flex h-11 min-h-[44px] w-11 min-w-[44px] shrink-0 items-center justify-center rounded-full touch-manipulation" type="button" aria-label="Рецепт 4">
                        <span class="recipe-dot-inner block h-2.5 w-2.5 rounded-full bg-[#D4CFC4] transition-[width,background-color] duration-200" aria-hidden="true"></span>
                    </button>
                    <button class="recipe-dot inline-flex h-11 min-h-[44px] w-11 min-w-[44px] shrink-0 items-center justify-center rounded-full touch-manipulation" type="button" aria-label="Рецепт 5">
                        <span class="recipe-dot-inner block h-2.5 w-2.5 rounded-full bg-[#D4CFC4] transition-[width,background-color] duration-200" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="flex items-center gap-4">
                    <button
                        type="button"
                        class="recipe-nav-btn bg-white w-10 h-10 rounded-full border border-[#E8E3D8] flex items-center justify-center text-[#6B6B6B] hover:bg-[#2D5016] hover:text-white hover:border-[#2D5016] transition-colors"
                        aria-label="Предыдущий рецепт"
                        aria-controls="cooc"
                    >
                        <i class="ri-arrow-left-line" aria-hidden="true"></i>
                    </button>
                    <button
                        type="button"
                        class="recipe-nav-btn bg-white w-10 h-10 rounded-full border border-[#E8E3D8] flex items-center justify-center text-[#6B6B6B] hover:bg-[#2D5016] hover:text-white hover:border-[#2D5016] transition-colors"
                        aria-label="Следующий рецепт"
                        aria-controls="cooc"
                    >
                        <i class="ri-arrow-right-line" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div id="recipeCounter" class="text-center text-xs text-[#6B6B6B] mt-3">3 / 5</div>
        </div>
    </div>
</section>
@push('scripts')
@php
    $sliderSlides = ($sliderRecipes ?? collect())->map(function ($r) {
        return [
            'imgSrc' => $r->image_url ?? '',
            'imgAlt' => $r->title ?? '',
            'tagAccent' => $r->tag_top ?? '',
            'tagGlass' => $r->tag_bottom ?? '',
            'meta' => [
                (string) ($r->time_label ?? ''),
                (string) ($r->calories_label ?? ''),
                (string) ($r->difficulty_label ?? ''),
            ],
            'title' => $r->title ?? '',
            'desc' => $r->excerpt ?? '',
            'ingredients' => $r->ingredients ?? [],
        ];
    })->values();
@endphp
<script>
        (function () {
            const section = document.getElementById('cooc');
            if (!section) return;

            const card = document.getElementById('recipeCard');
            if (!card) return;

            const imgEl = document.getElementById('recipeImg');
            const accentTag = document.getElementById('recipeTagAccent');
            const glassTag = document.getElementById('recipeTagGlass');
            const titleEl = document.getElementById('recipeTitle');
            const descEl = document.getElementById('recipeDesc');
            const metaTexts = Array.from(section.querySelectorAll('.recipe-meta-text'));
            const ingredientsList = document.getElementById('recipeIngredients');
            const counterEl = document.getElementById('recipeCounter');

            const dots = Array.from(section.querySelectorAll('.recipe-dot'));
            const navButtons = Array.from(section.querySelectorAll('.recipe-nav-btn'));
            const prevBtn = navButtons[0];
            const nextBtn = navButtons[1];

            const slides = @json($sliderSlides);
            let index = 0;
            let transitioning = false;

            const preloaded = {};
            slides.forEach(function (s) {
                if (s.imgSrc) {
                    const img = new Image();
                    img.src = s.imgSrc;
                    preloaded[s.imgSrc] = img;
                }
            });

            function setActiveDot(nextIndex) {
                dots.forEach((btn, i) => {
                    const isActive = i === nextIndex;
                    const inner = btn.querySelector('.recipe-dot-inner');
                    btn.classList.toggle('recipe-dot-active', isActive);
                    if (isActive) {
                        btn.setAttribute('aria-current', 'true');
                    } else {
                        btn.removeAttribute('aria-current');
                    }
                    if (inner) {
                        inner.classList.toggle('w-8', isActive);
                        inner.classList.toggle('w-2.5', !isActive);
                        inner.classList.toggle('bg-[#2D5016]', isActive);
                        inner.classList.toggle('bg-[#D4CFC4]', !isActive);
                    }
                });
            }

            function applyText(s, nextIndex) {
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
                                '<li class="flex items-center gap-2 text-sm text-[#6B6B6B]">' +
                                '<div class="w-6 h-6 rounded-lg bg-[#E8F5D9] flex items-center justify-center flex-shrink-0">' +
                                '<i class="ri-leaf-line text-[#2D5016] text-xs" aria-hidden="true"></i>' +
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
            }

            function ensureImageReady(src) {
                return new Promise(function (resolve) {
                    if (!src) {
                        resolve(null);
                        return;
                    }

                    var cached = preloaded[src];
                    if (!cached) {
                        cached = new Image();
                        cached.src = src;
                        preloaded[src] = cached;
                    }

                    function finish() {
                        if (typeof cached.decode === 'function') {
                            cached.decode().catch(function () {}).finally(function () {
                                resolve(cached);
                            });
                            return;
                        }
                        resolve(cached);
                    }

                    if (cached.complete && cached.naturalWidth > 0) {
                        finish();
                        return;
                    }

                    cached.onload = finish;
                    cached.onerror = function () {
                        resolve(cached);
                    };
                });
            }

            function render(nextIndex) {
                const s = slides[nextIndex];
                if (!s || transitioning) return;
                transitioning = true;

                applyText(s, nextIndex);

                ensureImageReady(s.imgSrc).then(function () {
                    if (imgEl) {
                        imgEl.src = s.imgSrc;
                        imgEl.alt = s.imgAlt;
                    }
                    transitioning = false;
                });
            }

            function go(nextIndex) {
                const max = slides.length - 1;
                const clamped = Math.min(max, Math.max(0, nextIndex));
                if (clamped === index || transitioning) return;
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

            var first = slides[0];
            if (first) {
                applyText(first, 0);
                if (imgEl && first.imgSrc) { imgEl.src = first.imgSrc; imgEl.alt = first.imgAlt; }
                setActiveDot(0);
            }
        })();

        /* ─── Home catalog: qty +/- and add-to-cart ─── */
        (function () {
            var cart = window.__fitahataCart;
            var grid = document.getElementById('homeProductGrid');
            if (!cart || !grid) return;

            grid.addEventListener('click', function (e) {
                var card = e.target.closest('.product-card');
                if (!card) return;
                var qtyEl = card.querySelector('.qty-value');
                if (!qtyEl) return;
                var currentQty = parseInt(qtyEl.textContent, 10) || 1;

                if (e.target.closest('.qty-minus')) { qtyEl.textContent = Math.max(1, currentQty - 1); e.preventDefault(); return; }
                if (e.target.closest('.qty-plus')) { qtyEl.textContent = currentQty + 1; e.preventDefault(); return; }

                if (e.target.closest('.add-to-cart')) {
                    e.preventDefault();
                    cart.addItem({
                        id: Number(card.dataset.id), slug: card.dataset.slug, name: card.dataset.name,
                        price: parseFloat(card.dataset.price), priceDisplay: card.dataset.priceDisplay,
                        image: card.dataset.image, weight: card.dataset.weight
                    }, parseInt(qtyEl.textContent, 10) || 1);
                    qtyEl.textContent = '1';
                    var btn = card.querySelector('.add-to-cart');
                    btn.classList.add('card-add-pulse');
                    setTimeout(function () { btn.classList.remove('card-add-pulse'); }, 400);
                }
            });
        })();
</script>
@endpush

@endsection
