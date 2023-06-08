<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emlakgruplari extends Model
{
    use HasFactory;
    protected $table = 'emlakgruplari';
    protected $fillable = ['grupadi', 'ozellikgruplari'];
    public $casts = [
        'ozellikgruplari' => 'array'
    ];
}
