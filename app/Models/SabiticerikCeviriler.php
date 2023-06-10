<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SabiticerikCeviriler extends Model
{
    use HasFactory;
    protected $table = 'sabiticerik_ceviriler';
    protected $fillable = ['icerik_id', 'dilkodu', 'sefuri', 'description', 'baslik', 'aciklama'];

    public function icerik()
    {
        return $this->belongsTo(Sabiticerik::class, 'icerik_id', 'id');
    }
}
