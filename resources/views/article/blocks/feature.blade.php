@php
    $content = $block->content ?? [];
    $imageUrl = $content['imageUrl'] ?? '';
    $imageAlt = $content['imageAlt'] ?? '';
    $title = $content['title'] ?? '';
    $price = $content['price'] ?? '';
    $text = $content['text'] ?? '';
    $layout = $content['layout'] ?? [];
    $imageWidth = $layout['imageWidth'] ?? '1/2';
    $order = $layout['order'] ?? 'image-first';

    $isOneThird = $imageWidth === '1/3';
    $gridCols = $isOneThird ? 'feature--oneThird' : 'feature--half';
    $imageCol = $isOneThird ? 'feature__col feature__col--image feature__col--oneThird' : 'feature__col feature__col--image';
    $textCol = $isOneThird ? 'feature__col feature__col--text feature__col--twoThird' : 'feature__col feature__col--text';
@endphp
<section class="feature {{ $gridCols }}">
    <div class="feature__grid">
        @if($order === 'text-first')
            @include('article.blocks.partials._feature-text', ['title' => $title, 'price' => $price, 'text' => $text, 'textCol' => $textCol])
            @include('article.blocks.partials._feature-image', ['imageUrl' => $imageUrl, 'imageAlt' => $imageAlt, 'imageCol' => $imageCol])
        @else
            @include('article.blocks.partials._feature-image', ['imageUrl' => $imageUrl, 'imageAlt' => $imageAlt, 'imageCol' => $imageCol])
            @include('article.blocks.partials._feature-text', ['title' => $title, 'price' => $price, 'text' => $text, 'textCol' => $textCol])
        @endif
    </div>
</section>

