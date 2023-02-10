<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RubiAdmin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'no',
        'fullname',
        'age',
        'dob',
        'status',
        'email',
        'photo',
        'photoPath',
        'telephone',
    ];
    
    protected $hidden = [
        'password',
    ];
}
