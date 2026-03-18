@php
    $content = $block->content ?? [];
    $url = $content['url'] ?? '';
    $alt = $content['alt'] ?? '';
    $caption = $content['caption'] ?? '';
@endphp
@if($url)
<figure class="article-figure">
    <img src="{{ $url }}" alt="{{ $alt }}" class="article-image">
    @if($caption)
        <figcaption class="article-caption">{{ $caption }}</figcaption>
    @endif
</figure>
@endif
