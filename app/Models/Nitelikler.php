<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nitelikler extends Model
{
    use HasFactory;
    protected $table = 'nitelikler';
    protected $fillable = ['nitelikadi', 'degerler'];
    protected $casts = [
        'degerler' => 'array',
    ];
}
