<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class BusinessAdmin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'no',
        'fullname',
        'dob',
        'status',
        'email',
        'photo',
        'telephone',
        'business',
        'department',
    ];
    
    protected $hidden = [
        'password',
    ];
}
