<div class="{{ $textCol ?? '' }}">
    @if($title)
        <h2 class="feature__title">{{ $title }}</h2>
    @endif
    @if($price)
        <div class="feature__price">{{ $price }}</div>
    @endif
    @if($text)
        <p class="feature__text">{!! nl2br(e($text)) !!}</p>
    @endif
</div>

