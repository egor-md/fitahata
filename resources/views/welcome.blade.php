@extends('layouts.site')

@section('title', 'Главная')

@section('content')
<section class="home-hero">
    <div class="site-container">
        <h1 class="home-hero-title">Микрозелень в Гомеле</h1>
<!--         <h1 class="home-hero-title">Seedling Harvest</h1>
 -->        <div class="home-hero-card">
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
<section class="cooking">
    <div class="site-container">
        <h2 class="h2-coocing-title">Готовим <br>с микрозеленью</h2>
        <div class="cooking-slider" aria-label="Слайдер рецептов с микрозеленью" data-visible="3">
            <button class="cooking-slider-arrow cooking-slider-arrow--left" type="button" aria-label="Влево">
                <svg class="cooking-slider-arrowIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
            </button>

            <div class="cooking-slider-viewport">
                <div class="cooking-slider-track">
                    <div class="cooking-slide">
                        <div class="cooking-card-i">
                            <div class="cooking-img"><img src="/images/cook1.png" alt="яичница с микрозеленью"></div>
                            <div class="cooking-text">
                                <div class="cooking-img-desc">Яичница с растишками</div>
                                <div class="cooking-img-add">Белок, желток и немного зелени</div>
                            </div>
                        </div>
                    </div>

                    <div class="cooking-slide">
                        <div class="cooking-card-i">
                            <div class="cooking-img"><img src="/images/cook2.png" alt="Тосты с авокадо и микрозеленью"></div>
                            <div class="cooking-text">
                                <div class="cooking-img-desc">Тосты с авокадо и микрозеленью</div>
                                <div class="cooking-img-add">Тосты, авокадо, микрозелень</div>
                            </div>
                        </div>
                    </div>

                    <div class="cooking-slide">
                        <div class="cooking-card-i">
                            <div class="cooking-img"><img src="/images/cook3.png" alt="Окрошка с микрозеленью"></div>
                            <div class="cooking-text">
                                <div class="cooking-img-desc">Окрошка с микрозеленью</div>
                                <div class="cooking-img-add">Окрошка с микрозеленью смотреть онлайн</div>
                            </div>
                        </div>
                    </div>

                    <div class="cooking-slide">
                        <div class="cooking-card-i">
                            <div class="cooking-img"><img src="/images/cook1.png" alt="яичница с микрозеленью"></div>
                            <div class="cooking-text">
                                <div class="cooking-img-desc">Яичница с растишками</div>
                                <div class="cooking-img-add">Белок, желток и немного зелени</div>
                            </div>
                        </div>
                    </div>

                    <div class="cooking-slide">
                        <div class="cooking-card-i">
                            <div class="cooking-img"><img src="/images/cook2.png" alt="Тосты с авокадо и микрозеленью"></div>
                            <div class="cooking-text">
                                <div class="cooking-img-desc">Тосты с авокадо и микрозеленью</div>
                                <div class="cooking-img-add">Тосты, авокадо, микрозелень</div>
                            </div>
                        </div>
                    </div>

                    <div class="cooking-slide">
                        <div class="cooking-card-i">
                            <div class="cooking-img"><img src="/images/cook3.png" alt="Окрошка с микрозеленью"></div>
                            <div class="cooking-text">
                                <div class="cooking-img-desc">Окрошка с микрозеленью</div>
                                <div class="cooking-img-add">Окрошка с микрозеленью смотреть онлайн</div>
                            </div>
                        </div>
                    </div>
                    <div class="cooking-slide">
                        <div class="cooking-card-i">
                            <div class="cooking-img"><img src="/images/cook2.png" alt="Тосты с авокадо и микрозеленью"></div>
                            <div class="cooking-text">
                                <div class="cooking-img-desc">Тосты с авокадо и микрозеленью</div>
                                <div class="cooking-img-add">Тосты, авокадо, микрозелень</div>
                            </div>
                        </div>
                    </div>

                    <div class="cooking-slide">
                        <div class="cooking-card-i">
                            <div class="cooking-img"><img src="/images/cook3.png" alt="Окрошка с микрозеленью"></div>
                            <div class="cooking-text">
                                <div class="cooking-img-desc">Окрошка с микрозеленью</div>
                                <div class="cooking-img-add">Окрошка с микрозеленью смотреть онлайн</div>
                            </div>
                        </div>
                    </div>
                    <div class="cooking-slide">
                        <div class="cooking-card-i">
                            <div class="cooking-img"><img src="/images/cook2.png" alt="Тосты с авокадо и микрозеленью"></div>
                            <div class="cooking-text">
                                <div class="cooking-img-desc">Тосты с авокадо и микрозеленью</div>
                                <div class="cooking-img-add">Тосты, авокадо, микрозелень</div>
                            </div>
                        </div>
                    </div>

                    <div class="cooking-slide">
                        <div class="cooking-card-i">
                            <div class="cooking-img"><img src="/images/cook3.png" alt="Окрошка с микрозеленью"></div>
                            <div class="cooking-text">
                                <div class="cooking-img-desc">Окрошка с микрозеленью</div>
                                <div class="cooking-img-add">Окрошка с микрозеленью смотреть онлайн</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button class="cooking-slider-arrow cooking-slider-arrow--right" type="button" aria-label="Вправо">
                <svg class="cooking-slider-arrowIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m9 18 6-6-6-6"/>
                </svg>
            </button>

            <div class="cooking-slider-dots" aria-label="Точки слайдера"></div>
        </div>
    </div>
</section>

<section class="benefits">
    <div class="site-container">
        <div class="benefits-grid">
            <div class="benefits-left">
                <h2 class="benefits-title">Польза микрозелени</h2>

                <div class="benefits-items">
                    <div class="benefits-item">
                        <div class="benefits-itemIcon" aria-hidden="true">
                            <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M32 54c0-18 0-28 0-40" />
                                <path d="M32 14c-10 2-18 10-20 20 12 0 20-4 20-20Z" />
                                <path d="M32 14c10 2 18 10 20 20-12 0-20-4-20-20Z" />
                            </svg>
                        </div>
                        <div class="benefits-itemTitle">Витамины</div>
                        <div class="benefits-itemText">Микрозелень богата витаминами и антиоксидантами.</div>
                    </div>

                    <div class="benefits-item">
                        <div class="benefits-itemIcon" aria-hidden="true">
                            <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 10v44" />
                                <path d="M42 10v44" />
                                <path d="M14 18h36" />
                                <path d="M18 28h28" />
                                <path d="M14 38h36" />
                            </svg>
                        </div>
                        <div class="benefits-itemTitle">Минералы</div>
                        <div class="benefits-itemText">Поддерживает баланс микроэлементов в рационе.</div>
                    </div>

                    <div class="benefits-item">
                        <div class="benefits-itemIcon" aria-hidden="true">
                            <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="32" cy="26" r="10" />
                                <path d="M22 50c3-10 7-16 10-16s7 6 10 16" />
                                <path d="M18 14c6-6 22-6 28 0" />
                            </svg>
                        </div>
                        <div class="benefits-itemTitle">Лёгкость</div>
                        <div class="benefits-itemText">Добавляет вкус и свежесть без тяжести.</div>
                    </div>

                    <div class="benefits-item">
                        <div class="benefits-itemIcon" aria-hidden="true">
                            <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 28c10-16 26-16 36 0" />
                                <path d="M18 34c8-10 20-10 28 0" />
                                <path d="M24 40c4-4 12-4 16 0" />
                                <path d="M20 52h24" />
                            </svg>
                        </div>
                        <div class="benefits-itemTitle">Антиоксиданты</div>
                        <div class="benefits-itemText">Помогают бороться с окислительным стрессом.</div>
                    </div>
                </div>
            </div>

            <div class="benefits-right">
                <div class="benefits-media">
                    <img
                        src="/images/microgreens-benefits.png"
                        alt="Микрозелень"
                        class="benefits-mediaImg"
                        loading="lazy"
                    />
                </div>
            </div>
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
@endpush

@endsection
