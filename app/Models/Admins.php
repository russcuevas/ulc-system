<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admins extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'email',
        'password',
        'phone',
        'gender',
        'status',
        'verification_token',
        'created_by',
    ];

    protected $hidden = [
        'password'
    ];
}
