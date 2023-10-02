<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo_product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_product',
        'image'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    
    // set belongs to table product
    public function product(): BelongsTo{
       return $this->belongsTo(Product::class, "id_product", "id");
    }
}
