<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emlaktipleri extends Model
{
    use HasFactory;
    protected $table = 'emlaktipleri';
    protected $fillable = ['emlaktipi', 'grup_id'];

    public function grup()
    {
        return $this->belongsTo(Emlakgruplari::class, 'grup_id', 'id');
    }
}
