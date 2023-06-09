<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emlakgorselleri extends Model
{
    use HasFactory;
    protected $table = 'emlakgorselleri';
    protected $fillable = [
        'emlak_id',
        'dosyadi',
        'aciklama',
        'sira',
        'vitrin',
    ];

    public function emlak()
    {
        return $this->belongsTo(Emlak::class, 'emlak_id', 'id');
    }
    
}
