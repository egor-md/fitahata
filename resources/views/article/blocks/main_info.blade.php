@php
    $content = is_array($block->content ?? null) ? $block->content : [];
    $imageUrl = $content['imageUrl'] ?? '';
    $imageAlt = $content['imageAlt'] ?? ($content['productName'] ?? '');
    $productName = $content['productName'] ?? '';
    $price = $content['price'] ?? '';
    $benefit = $content['benefit'] ?? '';
    $taste = $content['taste'] ?? '';
    $description = $content['description'] ?? '';
@endphp

<section class="main-info">
    <div class="main-info__media">
        @if($imageUrl)
            <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}" class="main-info__image">
        @else
            <div class="main-info__placeholder">Изображение продукта не задано</div>
        @endif
    </div>

    <div class="main-info__content">
        @if($productName)
            <h2 class="main-info__title">{{ $productName }}</h2>
        @endif
        @if($price)
            <div class="main-info__price">{{ $price }}</div>
        @endif
        @if($benefit)
            <p class="main-info__line"><strong>Польза:</strong> {{ $benefit }}</p>
        @endif
        @if($taste)
            <p class="main-info__line"><strong>Вкус:</strong> {{ $taste }}</p>
        @endif
        @if($description)
            <p class="main-info__description">{{ $description }}</p>
        @endif
    </div>
</section>
