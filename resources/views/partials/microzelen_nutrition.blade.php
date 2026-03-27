@php
    /** @var \App\Models\Plant $plant */
    $nutritionBySection = $plant->nutritionItems->groupBy('section');
    $sections = [
        'energy' => [
            'tab_id' => 'nutrition-tab-energy',
            'panel_id' => 'nutrition-panel-energy',
            'tab_label' => 'Энергетическая ценность',
            'tab_icon' => 'ri-fire-line',
            'icon_classes' => 'bg-[#FEF3C7] text-[#F59E0B]',
            'panel_title' => 'Энергетическая ценность',
            'panel_icon' => 'ri-fire-line',
            'theme' => 'energy',
            'panel_classes' => 'border border-[#FDE68A] bg-[#FFFBEB]',
            'bar_default' => '#F59E0B',
        ],
        'protein' => [
            'tab_id' => 'nutrition-tab-protein',
            'panel_id' => 'nutrition-panel-protein',
            'tab_label' => 'Белки и аминокислоты',
            'tab_icon' => 'ri-test-tube-line',
            'icon_classes' => 'bg-[#DCFCE7] text-[#22C55E]',
            'panel_title' => 'Белки и аминокислоты',
            'panel_icon' => 'ri-test-tube-line',
            'theme' => 'protein',
            'panel_classes' => 'border border-[#BBF7D0] bg-[#F0FDF4]',
            'bar_default' => '#22C55E',
        ],
        'vitamins' => [
            'tab_id' => 'nutrition-tab-vitamins',
            'panel_id' => 'nutrition-panel-vitamins',
            'tab_label' => 'Витамины',
            'tab_icon' => 'ri-capsule-line',
            'icon_classes' => 'bg-[#ECFCCB] text-[#84CC16]',
            'panel_title' => 'Витамины',
            'panel_icon' => 'ri-capsule-line',
            'theme' => 'vitamins',
            'panel_classes' => 'border border-[#D9F99D] bg-[#F7FEE7]',
            'bar_default' => '#84CC16',
        ],
        'minerals' => [
            'tab_id' => 'nutrition-tab-minerals',
            'panel_id' => 'nutrition-panel-minerals',
            'tab_label' => 'Минералы и микроэлементы',
            'tab_icon' => 'ri-microscope-line',
            'icon_classes' => 'bg-[#CCFBF1] text-[#14B8A6]',
            'panel_title' => 'Минералы и микроэлементы',
            'panel_icon' => 'ri-microscope-line',
            'theme' => 'minerals',
            'panel_classes' => 'border border-[#99F6E4] bg-[#F0FDFA]',
            'bar_default' => '#14B8A6',
        ],
        'antioxidants' => [
            'tab_id' => 'nutrition-tab-antioxidants',
            'panel_id' => 'nutrition-panel-antioxidants',
            'tab_label' => 'Антиоксиданты и фитонутриенты',
            'tab_icon' => 'ri-shield-star-line',
            'icon_classes' => 'bg-[#FFE4E6] text-[#F43F5E]',
            'panel_title' => 'Антиоксиданты и фитонутриенты',
            'panel_icon' => 'ri-shield-star-line',
            'theme' => 'antioxidants',
            'panel_classes' => 'border border-[#FECDD3] bg-[#FFF1F2]',
            'bar_default' => '#F43F5E',
        ],
    ];

    $barColorMap = [
        'amber' => '#F59E0B',
        'yellow' => '#EAB308',
        'orange' => '#F97316',
        'green' => '#22C55E',
        'emerald' => '#10B981',
        'lime' => '#84CC16',
        'teal' => '#14B8A6',
        'cyan' => '#06B6D4',
        'blue' => '#3B82F6',
        'indigo' => '#6366F1',
        'purple' => '#A855F7',
        'rose' => '#F43F5E',
        'red' => '#EF4444',
    ];
@endphp

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
        <header class="text-center mb-12">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-[#2D5016]/10 text-[#2D5016] text-xs font-bold uppercase tracking-wider mb-4">Состав и полезность</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1A1A1A] mb-3">{{ $plant->nutrition_section_title }}</h2>
            <p class="text-sm sm:text-base text-[#5A6B4A] max-w-2xl mx-auto">{{ $plant->nutrition_section_lead }}</p>
        </header>
        <div class="grid grid-cols-1 lg:grid-cols-[minmax(260px,1fr)_minmax(0,2fr)] gap-8">
            <div class="flex flex-col gap-2" role="tablist" aria-label="Разделы питательности">
                @foreach ($sections as $key => $meta)
                    @php
                        $isFirst = $loop->first;
                    @endphp
                    <button type="button" id="{{ $meta['tab_id'] }}"
                        class="nutrition-tab flex items-center gap-3 w-full px-5 py-4 border-0 rounded-2xl text-left cursor-pointer transition-colors {{ $isFirst ? 'nutrition-tab-active bg-[#2D5016] text-white' : 'bg-[#FAFAF7] text-[#4A4A4A] hover:bg-[#F0EDE4]' }}"
                        role="tab" aria-selected="{{ $isFirst ? 'true' : 'false' }}"
                        aria-controls="{{ $meta['panel_id'] }}" data-nutrition-panel="{{ $key }}">
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg {{ $meta['icon_classes'] }}"
                            aria-hidden="true"><i class="{{ $meta['tab_icon'] }}"></i></span>
                        <span class="text-sm font-medium">{{ $meta['tab_label'] }}</span>
                    </button>
                @endforeach
                <aside class="mt-4 p-4 rounded-2xl bg-[#FAFAF7] border border-[#EDE8DC]">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-lg text-[#E8C547]" aria-hidden="true"><i class="ri-lightbulb-line"></i></span>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#5A6B4A]">Знаете ли вы?</span>
                    </div>
                    <p class="text-sm text-[#5A6B4A] leading-relaxed">{{ $plant->nutrition_tip_text }}</p>
                </aside>
            </div>
            <div id="nutritionPanelWrap" data-nutrition-preload>
                @foreach ($sections as $key => $meta)
                    @php
                        $items = $nutritionBySection->get($key, collect());
                        $isFirst = $loop->first;
                    @endphp
                    <div id="{{ $meta['panel_id'] }}"
                        class="rounded-2xl {{ $meta['panel_classes'] }} p-6"
                        role="tabpanel" aria-labelledby="{{ $meta['tab_id'] }}"
                        @if (!$isFirst) hidden @endif>
                        <div class="flex items-center gap-3 mb-5">
                            <span class="w-10 h-10 flex items-center justify-center rounded-xl {{ $meta['icon_classes'] }}"
                                aria-hidden="true"><i class="{{ $meta['panel_icon'] }} text-lg"></i></span>
                            <h3 class="text-lg font-bold text-[#1A1A1A]">{{ $meta['panel_title'] }}</h3>
                        </div>
                        <ul class="flex flex-col gap-3">
                            @foreach ($items as $item)
                                @php
                                    $v = $item->bar_variant ? trim((string) $item->bar_variant) : '';
                                    $barColor = ($v !== '' && isset($barColorMap[$v])) ? $barColorMap[$v] : $meta['bar_default'];
                                @endphp
                                <li>
                                    <div class="flex items-baseline gap-2 mb-1">
                                        <span class="text-sm font-medium text-[#1A1A1A]">{{ $item->label }}</span>
                                        <span class="text-xs text-[#52564E]">{{ $item->meta }}</span>
                                        <span class="text-sm font-bold text-[#1A1A1A] ml-auto flex-shrink-0">{{ $item->value }}</span>
                                    </div>
                                    <div class="h-2 rounded-full overflow-hidden bg-black/5">
                                        <span class="nutrition-fill block h-full rounded-full transition-all duration-700 ease-out"
                                            style="width:{{ min(100, max(0, (int) $item->bar_percent)) }}%; background-color:{{ $barColor }}"></span>
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
