@php
    $content = $block->content ?? [];
    $images = $content['images'] ?? null;
    if ($images === null) {
        $data = $blocksData[$block->id] ?? null;
        $images = $data['images'] ?? [];
    }
    $images = is_array($images) ? $images : [];
    $columns = (int) ($content['columns'] ?? 2);
    if ($columns !== 3) {
        $columns = 2;
    }
    $gridClass = $columns === 3 ? 'md:grid-cols-3' : 'md:grid-cols-2';
@endphp
@if(count($images) > 0)
<div class="article-gallery article-gallery--cols-{{ $columns }}">
    @foreach($images as $img)
        <figure class="article-galleryItem">
            <img src="{{ $img['url'] ?? '' }}" alt="{{ $img['alt'] ?? '' }}" class="article-galleryImage">
            @if(!empty($img['caption']))
                <figcaption class="article-caption">{{ $img['caption'] }}</figcaption>
            @endif
        </figure>
    @endforeach
</div>
@endif
