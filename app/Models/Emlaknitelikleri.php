<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emlaknitelikleri extends Model
{
    use HasFactory;

    protected $table = 'emlaknitelikleri';
    protected $fillable = ['emlak_id', 'nitelik_id', 'deger'];

    public function nitelik()
    {
        return $this->belongsTo(Nitelikler::class, 'nitelik_id');
    }

    public function emlak()
    {
        return $this->belongsTo(Emlak::class, 'emlak_id');
    }

}
