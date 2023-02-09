<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'period',
        'status',
    ];

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_packages', 'package_no', 'business_no');
    }
}
