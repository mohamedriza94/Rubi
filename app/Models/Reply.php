<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $table = 'replies';
    
    protected $fillable = [
        'reply',
        'inquiry_id'
    ];


    public function inquiry()
    {
        return $this->belongsTo('App\Models\Inquiry', 'id', 'inquiry_id');
    }
}
