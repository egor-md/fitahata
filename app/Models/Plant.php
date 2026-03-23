<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plant extends Model
{
    public const KIND_MICROGREEN = 'microgreen';

    public const KIND_BABY_LEAF = 'baby_leaf';

    public const KIND_MATURE = 'mature';

    public const KIND_EDIBLE_FLOWERS = 'edible_flowers';

    protected $fillable = [
        'name',
        'subtitle',
        'slug',
        'kind',
        'is_visible',
        'description',
        'dishes_text',
        'price',
        'price_unit_label',
        'compare_at_price',
        'discount_label',
        'growing_period_label',
        'category_label',
        'sku',
        'is_bestseller',
        'rating',
        'reviews_count',
        'facts',
        'nutrition_section_title',
        'nutrition_section_lead',
        'nutrition_tip_text',
        'recipes_section_pill',
        'recipes_section_title',
        'recipes_section_lead',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'is_bestseller' => 'boolean',
            'price' => 'decimal:2',
            'compare_at_price' => 'decimal:2',
            'rating' => 'decimal:2',
            'facts' => 'array',
        ];
    }

    public function images(): HasMany
    {
        return $this->hasMany(PlantImage::class)->orderBy('sort_order');
    }

    public function nutritionItems(): HasMany
    {
        return $this->hasMany(PlantNutritionItem::class)->orderBy('sort_order');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'plant_tag');
    }

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'plant_recipe')
            ->orderBy('recipes.sort_order');
    }
}
