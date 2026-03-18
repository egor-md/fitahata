<div class="{{ $imageCol ?? '' }}">
    @if($imageUrl)
        <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}" class="feature__image">
    @else
        <div class="feature__imagePlaceholder">
            Изображение не задано
        </div>
    @endif
</div>

