@php
    $content = $block->content ?? [];
    $level = min(3, max(1, (int) ($content['level'] ?? 1)));
    $text = $content['text'] ?? '';
@endphp
@if($level === 1)<h1 class="article-h1">{{ $text }}</h1>
@elseif($level === 2)<h2 class="article-h2">{{ $text }}</h2>
@else<h3 class="article-h3">{{ $text }}</h3>
@endif
