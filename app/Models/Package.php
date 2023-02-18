<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'photo',
        'photoPath',
        'name',
        'description',
        'price',
        'periodDuration',
        'periodUnit',
        'status',
        'is_deleted'
    ];
    
    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_packages', 'package_no', 'business_no');
    }
}
