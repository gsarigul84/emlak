<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emlakdetay extends Model
{
	use HasFactory;

	protected $table = 'emlakdetay';

	protected $fillable = ['emlak_id', 'dilkodu', 'sef', 'baslik', 'aciklama', 'detay', 'dilkodu'];

	public function emlak()
	{
		return $this->belongsTo(Emlak::class);
	}
}
