<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'categories',
        'color',
        'size',
        'storage',
        'description',
        'price'
    ];

    // set relations with table photo product
    public function photos(): HasMany{
        return $this->hasMany(Photo_product::class, "id_product", "id");
    }

    // set relations with table cart
    public function cart(): BelongsTo{
        return $this->belongsTo(Cart::class, "id", "id_product");
    }

    // set relations with table order
    public function order(): BelongsTo{
        return $this->belongsTo(Order::class, "id", "id_product");
    }
}
