@php
    /** @var \App\Models\Plant $plant */
    $nutritionBySection = $plant->nutritionItems->groupBy('section');
    $sections = [
        'energy' => [
            'tab_id' => 'nutrition-tab-energy',
            'panel_id' => 'nutrition-panel-energy',
            'tab_label' => 'Энергетическая ценность',
            'tab_icon' => 'ri-fire-line',
            'tab_icon_mod' => '',
            'panel_title' => 'Энергетическая ценность',
            'panel_icon' => 'ri-fire-line',
            'theme' => 'energy',
        ],
        'protein' => [
            'tab_id' => 'nutrition-tab-protein',
            'panel_id' => 'nutrition-panel-protein',
            'tab_label' => 'Белки и аминокислоты',
            'tab_icon' => 'ri-test-tube-line',
            'tab_icon_mod' => 'test-card-tab__icon--green',
            'panel_title' => 'Белки и аминокислоты',
            'panel_icon' => 'ri-test-tube-line',
            'theme' => 'protein',
        ],
        'vitamins' => [
            'tab_id' => 'nutrition-tab-vitamins',
            'panel_id' => 'nutrition-panel-vitamins',
            'tab_label' => 'Витамины',
            'tab_icon' => 'ri-capsule-line',
            'tab_icon_mod' => 'test-card-tab__icon--lime',
            'panel_title' => 'Витамины',
            'panel_icon' => 'ri-capsule-line',
            'theme' => 'vitamins',
        ],
        'minerals' => [
            'tab_id' => 'nutrition-tab-minerals',
            'panel_id' => 'nutrition-panel-minerals',
            'tab_label' => 'Минералы и микроэлементы',
            'tab_icon' => 'ri-microscope-line',
            'tab_icon_mod' => 'test-card-tab__icon--teal',
            'panel_title' => 'Минералы и микроэлементы',
            'panel_icon' => 'ri-microscope-line',
            'theme' => 'minerals',
        ],
        'antioxidants' => [
            'tab_id' => 'nutrition-tab-antioxidants',
            'panel_id' => 'nutrition-panel-antioxidants',
            'tab_label' => 'Антиоксиданты и фитонутриенты',
            'tab_icon' => 'ri-shield-star-line',
            'tab_icon_mod' => 'test-card-tab__icon--rose',
            'panel_title' => 'Антиоксиданты и фитонутриенты',
            'panel_icon' => 'ri-shield-star-line',
            'theme' => 'antioxidants',
        ],
    ];
@endphp

<section class="test-card-nutrition">
    <div class="site-container">
        <header class="test-card-section-head">
            <span class="test-card-pill">Состав и полезность</span>
            <h2 class="test-card-section-head__title">{{ $plant->nutrition_section_title }}</h2>
            <p class="test-card-section-head__text">{{ $plant->nutrition_section_lead }}</p>
        </header>
        <div class="test-card-nutrition__grid">
            <div class="test-card-nutrition__tabs" role="tablist" aria-label="Разделы питательности">
                @foreach ($sections as $key => $meta)
                    @php
                        $isFirst = $loop->first;
                    @endphp
                    <button type="button" id="{{ $meta['tab_id'] }}"
                        class="test-card-tab {{ $isFirst ? 'test-card-tab--active' : '' }}"
                        role="tab" aria-selected="{{ $isFirst ? 'true' : 'false' }}"
                        aria-controls="{{ $meta['panel_id'] }}" data-nutrition-panel="{{ $key }}">
                        <span
                            class="test-card-tab__icon {{ $meta['tab_icon_mod'] }}"
                            aria-hidden="true"><i class="{{ $meta['tab_icon'] }}"></i></span>
                        <span class="test-card-tab__text">{{ $meta['tab_label'] }}</span>
                    </button>
                @endforeach
                <aside class="test-card-tip">
                    <div class="test-card-tip__head">
                        <span class="test-card-tip__icon" aria-hidden="true"><i class="ri-lightbulb-line"></i></span>
                        <span class="test-card-tip__label">Знаете ли вы?</span>
                    </div>
                    <p class="test-card-tip__text">{{ $plant->nutrition_tip_text }}</p>
                </aside>
            </div>
            <div class="test-card-nutrition__panel-wrap" data-nutrition-preload>
                @foreach ($sections as $key => $meta)
                    @php
                        $items = $nutritionBySection->get($key, collect());
                        $isFirst = $loop->first;
                    @endphp
                    <div id="{{ $meta['panel_id'] }}"
                        class="test-card-energy test-card-energy--theme-{{ $meta['theme'] }}"
                        role="tabpanel" aria-labelledby="{{ $meta['tab_id'] }}"
                        @if (!$isFirst) hidden @endif>
                        <div class="test-card-energy__head">
                            <span class="test-card-energy__head-icon" aria-hidden="true"><i
                                    class="{{ $meta['panel_icon'] }}"></i></span>
                            <h3 class="test-card-energy__title">{{ $meta['panel_title'] }}</h3>
                        </div>
                        <ul class="test-card-energy__list">
                            @foreach ($items as $item)
                                @php
                                    $fillClass = 'test-card-energy__fill';
                                    $v = $item->bar_variant ? trim((string) $item->bar_variant) : '';
                                    if ($v !== '') {
                                        $fillClass .= ' test-card-energy__fill--' . $v;
                                    }
                                @endphp
                                <li class="test-card-energy__row">
                                    <div class="test-card-energy__row-top">
                                        <span class="test-card-energy__name">{{ $item->label }}</span>
                                        <span class="test-card-energy__meta">{{ $item->meta }}</span>
                                        <span class="test-card-energy__val">{{ $item->value }}</span>
                                    </div>
                                    <div class="test-card-energy__bar"><span class="{{ $fillClass }}"
                                            style="width:{{ min(100, max(0, (int) $item->bar_percent)) }}%"></span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @include('partials.microzelen_nutrition_footnote')
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
