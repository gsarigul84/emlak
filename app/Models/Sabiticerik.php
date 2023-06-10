<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sabiticerik extends Model
{
    use HasFactory;
    protected $table = 'sabiticerik';
    protected $fillable = ['icerikadi'];

    public function ceviriler()
    {
        return $this->hasMany(SabiticerikCeviriler::class, 'icerik_id', 'id');
    }
}
