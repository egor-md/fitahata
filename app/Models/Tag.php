<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'group',
    ];

    public function plants(): BelongsToMany
    {
        return $this->belongsToMany(Plant::class, 'plant_tag');
    }
}
