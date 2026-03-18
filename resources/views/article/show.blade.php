@extends('layouts.site')

@section('title', $article->title)

@section('content')
<div class="article-page site-container">
    <h1 class="article-title">{{ $article->title }}</h1>

    <article class="article-content">
        @foreach($article->articleBlocks ?? [] as $block)
            @includeFirst(['article.blocks.' . $block->type, 'article.blocks.text'], [
                'block' => $block,
                'blocksData' => $blocksData ?? [],
            ])
        @endforeach
    </article>
</div>
@endsection
