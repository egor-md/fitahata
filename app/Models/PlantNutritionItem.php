<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlantNutritionItem extends Model
{
    public const SECTION_ENERGY = 'energy';

    public const SECTION_PROTEIN = 'protein';

    public const SECTION_VITAMINS = 'vitamins';

    public const SECTION_MINERALS = 'minerals';

    public const SECTION_ANTIOXIDANTS = 'antioxidants';

    protected $fillable = [
        'plant_id',
        'section',
        'label',
        'meta',
        'value',
        'bar_percent',
        'bar_variant',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'bar_percent' => 'integer',
        ];
    }

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }
}
