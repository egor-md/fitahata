<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Block;
use App\Models\Category;
use Illuminate\Support\Str;
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

            $imageUrl = $content['imageUrl'] ?? ($article->cover_path ?: '');
            $webpSrcset = null;

            if (is_string($imageUrl) && Str::startsWith($imageUrl, '/images/catalog/') && Str::endsWith($imageUrl, '.png')) {
                $base = Str::beforeLast($imageUrl, '.png');
                $webpSrcset = collect([320, 640, 960, 1376])
                    ->map(fn (int $width) => "{$base}-{$width}.webp {$width}w")
                    ->implode(', ');
            }

            return [
                'title' => $content['productName'] ?? $article->title,
                'slug' => $article->slug,
                'image_url' => $imageUrl,
                'image_webp_srcset' => $webpSrcset,
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

    public function contacts(): View
    {
        return view('contacts');
    }

    public function testCard(): View
    {
        return view('test_card');
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
