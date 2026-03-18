@php
    $data = $blocksData[$block->id] ?? null;
    $images = $data['images'] ?? [];
@endphp
@if(count($images) > 0)
<div class="article-carousel">
    @foreach($images as $img)
        <figure class="article-carouselItem">
            <img src="{{ $img['url'] ?? '' }}" alt="{{ $img['alt'] ?? '' }}" class="article-carouselImage">
            @if(!empty($img['caption']))
                <figcaption class="article-caption">{{ $img['caption'] }}</figcaption>
            @endif
        </figure>
    @endforeach
</div>
@endif
