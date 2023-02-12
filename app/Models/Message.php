<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'subject',
        'message',
    ];

    public function reply()
    {
        return $this->hasOne(Reply::class);
    }
}
