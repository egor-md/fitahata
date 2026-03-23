<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        $plants = Plant::query()
            ->where('is_visible', true)
            ->with('images')
            ->orderBy('name')
            ->get();

        $catalogItems = $plants->map(function (Plant $plant) {
            $primary = $plant->images->firstWhere('is_primary') ?? $plant->images->first();

            return [
                'title' => $plant->name,
                'slug' => $plant->slug,
                'image_url' => $primary?->url ?? '',
                'image_webp_srcset' => null,
                'description' => trim(strip_tags((string) $plant->description)),
                'benefit' => trim(strip_tags((string) $plant->dishes_text)),
                'price' => number_format((float) $plant->price, 2, ',', ' ') . ' BYN',
                'badge' => $plant->is_bestseller ? 'Хит' : null,
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
