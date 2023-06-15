<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SabiticerikDetay extends Model
{
	use HasFactory;

	protected $table = 'sabiticerik_detay';

	protected $fillable = ['icerik_id', 'dilkodu', 'sef', 'aciklama', 'baslik', 'icerik'];

	public function icerik()
	{
		return $this->belongsTo(Sabiticerik::class, 'icerik_id', 'id');
	}
}
