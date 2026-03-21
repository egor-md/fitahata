<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleBlock;
use App\Models\Category;
use App\Models\Block;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(): Response
    {
        $articles = Article::with('category')->orderByDesc('updated_at')->get();

        return Inertia::render('admin/articles/index', [
            'articles' => $articles,
        ]);
    }

    public function create(): Response
    {
        $categories = Category::orderBy('sort_order')->orderBy('name')->get();
        $blocks = Block::orderBy('name')->get();

        return Inertia::render('admin/articles/create', [
            'categories' => $categories,
            'blocks' => $blocks,
            'errors' => session()->get('errors')?->getBag('default')->getMessages() ?? [],
            'old' => request()->old(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:articles,slug'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_visible' => ['boolean'],
            'is_main_for_category' => ['boolean'],
            'blocks' => ['nullable', 'array'],
            'blocks.*.type' => ['required', 'in:heading,text,image,gallery,carousel,feature,main_info'],
            'blocks.*.content' => ['nullable'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        $validated['is_visible'] = $request->boolean('is_visible');
        $validated['is_main_for_category'] = $request->boolean('is_main_for_category');
        $validated['category_id'] = $validated['category_id'] ?? null;
        $validated['blocks'] = $this->normalizeBlocksContent($validated['blocks'] ?? []);

        if ($validated['is_main_for_category'] && $validated['category_id']) {
            Article::where('category_id', $validated['category_id'])->update(['is_main_for_category' => false]);
        }

        $article = Article::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'category_id' => $validated['category_id'],
            'is_visible' => $validated['is_visible'],
            'is_main_for_category' => $validated['is_main_for_category'],
        ]);

        $this->syncArticleBlocks($article, $validated['blocks']);

        return redirect()->route('admin.articles.index');
    }

    public function edit(Article $article): Response
    {
        $article->load('articleBlocks');
        $categories = Category::orderBy('sort_order')->orderBy('name')->get();
        $blocks = Block::orderBy('name')->get();

        return Inertia::render('admin/articles/edit', [
            'article' => $article,
            'categories' => $categories,
            'blocks' => $blocks,
            'errors' => session()->get('errors')?->getBag('default')->getMessages() ?? [],
            'old' => request()->old(),
        ]);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:articles,slug,'.$article->id],
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_visible' => ['boolean'],
            'is_main_for_category' => ['boolean'],
            'blocks' => ['nullable', 'array'],
            'blocks.*.id' => ['nullable', 'integer'],
            'blocks.*.type' => ['required', 'in:heading,text,image,gallery,carousel,feature,main_info'],
            'blocks.*.content' => ['nullable'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        $validated['is_visible'] = $request->boolean('is_visible');
        $validated['is_main_for_category'] = $request->boolean('is_main_for_category');
        $validated['category_id'] = $validated['category_id'] ?? null;
        $validated['blocks'] = $this->normalizeBlocksContent($validated['blocks'] ?? []);

        if ($validated['is_main_for_category'] && $validated['category_id']) {
            Article::where('category_id', $validated['category_id'])->where('id', '!=', $article->id)->update(['is_main_for_category' => false]);
        }

        $article->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'category_id' => $validated['category_id'],
            'is_visible' => $validated['is_visible'],
            'is_main_for_category' => $validated['is_main_for_category'],
        ]);

        $this->syncArticleBlocks($article, $validated['blocks']);

        return redirect()->route('admin.articles.index');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.articles.index');
    }

    public function toggleVisibility(Article $article): RedirectResponse
    {
        $article->update(['is_visible' => ! $article->is_visible]);

        return redirect()->route('admin.articles.index');
    }

    private function normalizeBlocksContent(array $blocks): array
    {
        foreach ($blocks as &$block) {
            $content = $block['content'] ?? null;
            if (is_string($content)) {
                $decoded = json_decode($content, true);
                $block['content'] = is_array($decoded) ? $decoded : [];
            } elseif (! is_array($content)) {
                $block['content'] = [];
            }
        }

        return $blocks;
    }

    private function syncArticleBlocks(Article $article, array $blocks): void
    {
        $article->articleBlocks()->delete();

        foreach ($blocks as $position => $block) {
            ArticleBlock::create([
                'article_id' => $article->id,
                'position' => $position,
                'type' => $block['type'],
                'content' => $block['content'] ?? [],
            ]);
        }
    }
}
