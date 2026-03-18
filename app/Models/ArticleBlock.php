<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleBlock extends Model
{
    protected $fillable = [
        'article_id',
        'position',
        'type',
        'content',
    ];

    protected function casts(): array
    {
        return [
            'position' => 'integer',
            'content' => 'array',
        ];
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
