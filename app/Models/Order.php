<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUS_NEW = 'new';

    public const STATUS_CONFIRMED = 'confirmed';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'status',
        'total',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (self $order): void {
            if ($order->order_number) {
                return;
            }

            $order->forceFill([
                'order_number' => 'FH-'.str_pad((string) $order->id, 6, '0', STR_PAD_LEFT),
            ])->saveQuietly();
        });
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_NEW,
            self::STATUS_CONFIRMED,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELLED,
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class)->orderBy('id');
    }
}
