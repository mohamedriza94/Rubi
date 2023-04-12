<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'department',
        'business',
        'employee',
        'purpose',
        'note',
        'amount',
    ];
}
