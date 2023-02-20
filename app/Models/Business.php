<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Business extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'type',
        'product',
        'email',
        'website',
        'country',
        'photo',
        'photoPath',
        'no',
        'status',
        'verifiedDate',
    ];

    protected $hidden = [
        'password',
    ];

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'business_packages', 'business_no', 'package_no');
    }
}
