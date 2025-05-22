<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($orderItem) {
            $orderItem->total = $orderItem->quantity * $orderItem->price;
        });

        static::saved(function ($orderItem) {
            $orderItem->order->calculateTotal();
        });

        static::deleted(function ($orderItem) {
            $orderItem->order->calculateTotal();
        });
    }
}