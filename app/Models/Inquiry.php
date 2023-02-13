<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $table = 'inquiries';
    
    protected $fillable = [
        'name',
        'number',
        'email',
        'subject',
        'message',
        'status',
        'is_deleted',
        'is_starred',
    ];

    public function reply()
    {
        return $this->hasOne('App\Models\Reply', 'inquiry_id', 'id');
    }
}
