<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Emlaklar extends Model
{
    use InteractsWithMedia;
    use HasFactory;
    protected $table = 'emlak';
    protected $fillable = [
        'grup_id',
        'tip_id',
        'ilantipi',
        'ilan_no',
        'il_id',
        'ilce_id',
        'mahalle_id',
        'kooordinatlar',
    ];

    protected $casts = [
        'kooordinatlar' => 'array',
    ];

    public function grup()
    {
        return $this->belongsTo(EmlakGruplari::class, 'grup_id');
    }

    public function tip()
    {
        return $this->belongsTo(EmlakTipleri::class, 'tip_id');
    }

    public function detay()
    {
        return $this->hasMany(EmlakDetaylari::class, 'emlak_id');
    }

    public function gorseller()
    {
        return $this->hasMany(EmlakGorselleri::class, 'emlak_id');
    }

    public function ozellikler()
    {
        return $this->hasMany(EmlakOzellikleri::class, 'emlak_id');
    }

    public function nitelikler()
    {
        return $this->hasMany(EmlakNitelikleri::class, 'emlak_id');
    }

    public function il()
    {
        return $this->belongsTo(Iller::class, 'il_id');
    }

    public function ilce()
    {
        return $this->belongsTo(Ilceler::class, 'ilce_id');
    }

    public function mahalle()
    {
        return $this->belongsTo(Mahalleler::class, 'mahalle_id');
    }


}
