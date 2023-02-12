<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'reply',
        'inquiry_id'
    ];


    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }
}
