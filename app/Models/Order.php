<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'uuid',
        'date',
        'products',
        'amount',
        'name',
        'phone',
        'address',
        'package',
        'status',
    ];

    protected $casts = [
        'products' => 'array',
    ];

     // set relations with table user
     public function user(): BelongsTo{
        return $this->belongsTo(Order::class, "id", "id_user");
    }
}

