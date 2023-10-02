<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model implements Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password'
    ];

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
