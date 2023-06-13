<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ayarlar extends Model
{
    use HasFactory;
    protected $table = 'ayarlar';
    protected $fillable = [
        'anahtar',
        'deger',
        'ekdeger',
    ];

    protected $casts = [
      'ekdeger' => 'array',
    ];
}
