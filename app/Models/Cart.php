<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_product',
        'id_user',
        'amount'
    ];

    // set relations with table product
    public function products(): HasMany{
        return $this->hasMany(Product::class, "id", "id_product");
    }

    // set relations with table photo product
    public function photos(): HasMany{
        return $this->hasMany(Photo_product::class, "id_product", "id_product");
    }

}
