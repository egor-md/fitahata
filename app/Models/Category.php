<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'show_in_menu',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'show_in_menu' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /** Главная статья пункта меню — по клику на категорию открывается сразу она (без подменю). */
    public function mainArticle(): HasOne
    {
        return $this->hasOne(Article::class)->where('is_main_for_category', true)->where('is_visible', true);
    }
}
