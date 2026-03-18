@php
    $body = $block->content['body'] ?? '';
@endphp
<div class="article-text">{!! nl2br(e($body)) !!}</div>
