<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model implements Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'password',
        'token'
    ];

     // set relations with table photo address
     public function addresses(): HasMany{
        return $this->hasMany(Address::class, "id_user", "id");
    }

    // set relations with table order user has many order
    public function orders(): HasMany{
        return $this->hasMany(Order::class, "id_user", "id");
    }

    // implement Authanticable method
    public function getAuthIdentifierName(){
        return 'email';
    }

    public function getAuthIdentifier(){
        return $this->email;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {   
        return $this->token;
    }

    public function setRememberToken($value)
    {
        $this->token = $value;
    }

    public function getRememberTokenName()
    {
        return 'token';
    }
}
