<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    
    protected $table = 'tasks';
    
    protected $fillable = [
        'no',
        'title',
        'description',
        'business',
        'department',
        'admin',
        'status',
        'start',
        'end'
    ];
}
