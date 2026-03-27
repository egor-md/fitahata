<?php

namespace App\Support\Microgreen;

use App\Models\Plant;
use App\Models\PlantImage;
use App\Models\PlantNutritionItem;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

/**
 * Idempotent plant + nutrition + recipe seeding for migration use.
 *
 * Nutrition ranges for microgreens are aggregated from public summaries
 * (e.g. microgreensworld.com, microgreens.net.au, USDA food data patterns)
 * and rounded for demo cards — not a substitute for lab analysis.
 */
class PlantCultureImporter
{
    public static function import(string $slug): void
    {
        $profile = PlantCultureProfiles::get($slug);
        if ($profile === null) {
            throw new \InvalidArgumentException("Unknown microgreen culture slug: {$slug}");
        }

        $profile['images'] = [
            [
                'url' => '/images/catalog/'.$slug.'.webp',
                'sort_order' => 0,
                'is_primary' => true,
            ],
        ];

        DB::transaction(function () use ($profile, $slug) {
            self::ensureBaseTags();

            $plant = Plant::query()->updateOrCreate(
                ['slug' => $slug],
                array_merge($profile['plant'], ['slug' => $slug])
            );

            $plant->images()->delete();
            foreach ($profile['images'] as $i => $row) {
                PlantImage::query()->create([
                    'plant_id' => $plant->id,
                    'url' => $row['url'],
                    'sort_order' => $row['sort_order'] ?? $i,
                    'is_primary' => (bool) ($row['is_primary'] ?? false),
                ]);
            }

            $plant->nutritionItems()->delete();
            $order = 0;
            foreach ($profile['nutrition_rows'] as $r) {
                PlantNutritionItem::query()->create([
                    'plant_id' => $plant->id,
                    'section' => $r['section'],
                    'label' => $r['label'],
                    'meta' => $r['meta'] ?? null,
                    'value' => $r['value'],
                    'bar_percent' => (int) $r['bar_percent'],
                    'bar_variant' => $r['bar_variant'] ?? '',
                    'sort_order' => $order++,
                ]);
            }

            if (! empty($profile['tag_slugs'])) {
                $ids = Tag::query()->whereIn('slug', $profile['tag_slugs'])->pluck('id');
                $plant->tags()->sync($ids->all());
            } else {
                $plant->tags()->sync([]);
            }

            $recipe = $profile['recipe'];
            $recipeModel = Recipe::query()->updateOrCreate(
                ['slug' => $recipe['slug']],
                [
                    'title' => $recipe['title'],
                    'image_url' => $recipe['image_url'],
                    'time_label' => $recipe['time_label'] ?? null,
                    'calories_label' => $recipe['calories_label'] ?? null,
                    'difficulty_label' => $recipe['difficulty_label'] ?? null,
                    'tag_top' => $recipe['tag_top'] ?? null,
                    'tag_bottom' => $recipe['tag_bottom'] ?? null,
                    'excerpt' => $recipe['excerpt'] ?? null,
                    'body' => $recipe['body'] ?? null,
                    'ingredients' => $recipe['ingredients'] ?? [],
                    'cta_label' => $recipe['cta_label'] ?? null,
                    'cta_url' => $recipe['cta_url'] ?? url('/').'#catalog',
                    'sort_order' => (int) ($recipe['sort_order'] ?? 0),
                ]
            );
            $plant->recipes()->sync([$recipeModel->id]);
        });
    }

    public static function revert(string $slug): void
    {
        $plant = Plant::query()->where('slug', $slug)->first();
        if (! $plant) {
            return;
        }

        DB::transaction(function () use ($plant, $slug) {
            $profile = PlantCultureProfiles::get($slug);
            $plant->recipes()->detach();
            if ($profile !== null && isset($profile['recipe']['slug'])) {
                Recipe::query()->where('slug', $profile['recipe']['slug'])->delete();
            }
            $plant->delete();
        });
    }

    private static function ensureBaseTags(): void
    {
        $defs = [
            ['name' => 'Витамин К', 'slug' => 'vitamin-k', 'group' => 'benefit'],
            ['name' => 'Кальций', 'slug' => 'calcium', 'group' => 'mineral'],
            ['name' => 'Фолиевая кислота', 'slug' => 'folate', 'group' => 'benefit'],
            ['name' => 'Антиоксиданты', 'slug' => 'antioxidants', 'group' => 'quality'],
            ['name' => 'Без ГМО', 'slug' => 'no-gmo', 'group' => 'quality'],
            ['name' => 'Витамин E', 'slug' => 'vitamin-e', 'group' => 'benefit'],
            ['name' => 'Витамин D', 'slug' => 'vitamin-d', 'group' => 'benefit'],
            ['name' => 'Витамин B1', 'slug' => 'vitamin-b1', 'group' => 'benefit'],
            ['name' => 'Витамин B6', 'slug' => 'vitamin-b6', 'group' => 'benefit'],
            ['name' => 'Витамин B12', 'slug' => 'vitamin-b12', 'group' => 'benefit'],
            ['name' => 'Ниацин', 'slug' => 'niacin', 'group' => 'benefit'],
            ['name' => 'Пантотеновая кислота', 'slug' => 'pantothenic-acid', 'group' => 'benefit'],
            ['name' => 'Цинк', 'slug' => 'zinc', 'group' => 'mineral'],
            ['name' => 'Селен', 'slug' => 'selenium', 'group' => 'mineral'],
            ['name' => 'Фосфор', 'slug' => 'phosphorus', 'group' => 'mineral'],
            ['name' => 'Марганец', 'slug' => 'manganese', 'group' => 'mineral'],
            ['name' => 'Медь', 'slug' => 'copper', 'group' => 'mineral'],
            ['name' => 'Йод', 'slug' => 'iodine', 'group' => 'mineral'],
            ['name' => 'Железо', 'slug' => 'iron', 'group' => 'mineral'],
            ['name' => 'Клетчатка', 'slug' => 'fiber', 'group' => 'quality'],
            ['name' => 'Омега-3', 'slug' => 'omega-3', 'group' => 'benefit'],
            ['name' => 'Белок', 'slug' => 'protein-tag', 'group' => 'benefit'],
            ['name' => 'Витамин C', 'slug' => 'vitamin-c', 'group' => 'benefit'],
            ['name' => 'Магний', 'slug' => 'magnesium', 'group' => 'mineral'],
            ['name' => 'Калий', 'slug' => 'potassium', 'group' => 'mineral'],
        ];

        foreach ($defs as $d) {
            Tag::query()->updateOrCreate(
                ['slug' => $d['slug']],
                ['name' => $d['name'], 'group' => $d['group']]
            );
        }
    }
}
