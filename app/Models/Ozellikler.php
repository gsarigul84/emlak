<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ozellikler extends Model
{
    use HasFactory;
    protected $table = 'ozellikler';
    protected $fillable = ['ozellikadi','grup_id'];

    public function grup(){
      return $this->belongsTo(Ozellikgruplari::class,'grup_id','id');
    }
}
