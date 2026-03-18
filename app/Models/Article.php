<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'is_visible',
        'is_main_for_category',
        'cover_path',
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'is_main_for_category' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function articleBlocks(): HasMany
    {
        return $this->hasMany(ArticleBlock::class)->orderBy('position');
    }
}
