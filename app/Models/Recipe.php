<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipe extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image_url',
        'time_label',
        'calories_label',
        'difficulty_label',
        'tag_top',
        'tag_bottom',
        'excerpt',
        'body',
        'ingredients',
        'cta_label',
        'cta_url',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'ingredients' => 'array',
        ];
    }

    public function plants(): BelongsToMany
    {
        return $this->belongsToMany(Plant::class, 'plant_recipe');
    }
}
