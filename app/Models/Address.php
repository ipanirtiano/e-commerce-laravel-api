<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'name',
        'phone',
        'address',
        'city'
    ];

    // set relations with table user
    public function user(): BelongsTo{
        return $this->belongsTo(Address::class, "id", "id_user");
    }

    // set relations with table order
    public function order(): BelongsTo{
        return $this->belongsTo(Order::class, "id", "id_user");
    }

}
