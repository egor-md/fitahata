<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Block;
use Illuminate\View\View;

class PublicController extends Controller
{
    /**
     * Show article by slug. Only visible articles.
     */
    public function article(string $slug): View
    {
        $article = Article::where('slug', $slug)
            ->where('is_visible', true)
            ->with('articleBlocks')
            ->firstOrFail();

        $blocksData = [];
        foreach ($article->articleBlocks as $block) {
            if (in_array($block->type, ['gallery', 'carousel'], true)) {
                $content = $block->content ?? [];
                $blockId = $content['blockId'] ?? null;
                if ($blockId) {
                    $blocksData[$block->id] = Block::find($blockId)?->settings ?? ['images' => []];
                }
            }
        }

        return view('article.show', [
            'article' => $article,
            'blocksData' => $blocksData,
        ]);
    }
}
