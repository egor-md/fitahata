<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\Recipe;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PublicController extends Controller
{
    /**
     * @return array<int, array<string, mixed>>
     */
    private function mapPlantsForCatalog(\Illuminate\Support\Collection $plants): array
    {
        return $plants->map(function (Plant $plant) {
            $primaryImg = $plant->images->firstWhere('is_primary') ?? $plant->images->first();
            $imageUrl = $primaryImg?->url ?? '';

            $webpSrcset = null;
            if (is_string($imageUrl) && Str::startsWith($imageUrl, '/images/catalog/') && Str::endsWith($imageUrl, '.png')) {
                $base = Str::beforeLast($imageUrl, '.png');
                $webpSrcset = collect([320, 640, 960, 1376])
                    ->map(fn (int $width) => "{$base}-{$width}.webp {$width}w")
                    ->implode(', ');
            }

            $priceDisplay = '';
            if ($plant->price !== null) {
                $priceDisplay = number_format((float) $plant->price, 2, ',', ' ') . ' BYN';
            }

            return [
                'id' => $plant->id,
                'title' => $plant->name,
                'slug' => $plant->slug,
                'image_url' => $imageUrl,
                'image_webp_srcset' => $webpSrcset,
                'subtitle' => $plant->subtitle,
                'description' => Str::limit((string) $plant->description, 110),
                'benefit' => $plant->growing_period_label ?? $plant->category_label ?? '',
                'price' => $priceDisplay,
                'price_raw' => (float) ($plant->price ?? 0),
                'category' => $plant->category_label ?? '',
                'badge' => $plant->discount_label ?? ($plant->is_bestseller ? 'Хит' : null),
                'rating' => $plant->rating ? (float) $plant->rating : null,
                'reviews_count' => $plant->reviews_count ?? 0,
                'tags' => $plant->relationLoaded('tags')
                    ? $plant->tags->pluck('name')->all()
                    : [],
                'weight' => $plant->price_unit_label ?? '',
            ];
        })->values()->all();
    }

    public function home(): View
    {
        $plants = Plant::query()
            ->where('is_visible', true)
            ->with('images')
            ->orderBy('name')
            ->take(8)
            ->get();

        $catalogItems = $this->mapPlantsForCatalog($plants);

        $sliderRecipes = collect();
        $recipesPool = Recipe::query()
            ->get([
                'id',
                'title',
                'image_url',
                'time_label',
                'calories_label',
                'difficulty_label',
                'tag_top',
                'tag_bottom',
                'excerpt',
                'ingredients',
                'sort_order',
            ]);

        if ($recipesPool->isNotEmpty()) {
            if ($recipesPool->count() >= 5) {
                $sliderRecipes = $recipesPool->shuffle()->take(5)->values();
            } else {
                for ($i = 0; $i < 5; $i++) {
                    $sliderRecipes->push($recipesPool[$i % $recipesPool->count()]);
                }
            }
        }

        return view('welcome', [
            'catalogItems' => $catalogItems,
            'sliderRecipes' => $sliderRecipes,
        ]);
    }

    public function catalog(): View
    {
        $plants = Plant::query()
            ->where('is_visible', true)
            ->with(['images', 'tags'])
            ->orderBy('name')
            ->get();

        $items = $this->mapPlantsForCatalog($plants);

        $categories = collect($items)
            ->pluck('category')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        return view('catalog', [
            'catalogItems' => $items,
            'categories' => $categories,
        ]);
    }

    public function contacts(): View
    {
        return view('contacts');
    }

    public function show(string $slug): View
    {
        $plant = Plant::query()
            ->where('slug', $slug)
            ->where('is_visible', true)
            ->with(['images', 'tags', 'nutritionItems', 'recipes'])
            ->firstOrFail();

        return view('microzelen', [
            'plant' => $plant,
        ]);
    }
}
