<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Block;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        $category = Category::where('slug', 'microzelen')->first();

        $articles = collect();
        if ($category) {
            $articles = Article::where('category_id', $category->id)
                ->where('is_visible', true)
                ->with('articleBlocks')
                ->orderBy('title')
                ->take(8)
                ->get();
        }

        $catalogItems = $articles->map(function (Article $article) {
            $mainInfo = $article->articleBlocks
                ->firstWhere('type', 'main_info');

            $content = is_array($mainInfo?->content) ? $mainInfo->content : [];

            return [
                'title' => $content['productName'] ?? $article->title,
                'slug' => $article->slug,
                'image_url' => $content['imageUrl'] ?? ($article->cover_path ?: ''),
                'description' => $content['taste'] ?? '',
                'benefit' => $content['benefit'] ?? '',
                'price' => $content['price'] ?? '',
                'badge' => $content['badge'] ?? null,
            ];
        })->values();

        return view('welcome', [
            'catalogItems' => $catalogItems,
        ]);
    }

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
