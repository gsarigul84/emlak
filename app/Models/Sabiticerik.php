<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sabiticerik extends Model
{
	use HasFactory;

	protected $table = 'sabiticerik';

	protected $fillable = ['icerikadi', 'anahtar'];

	public function ceviriler()
	{
		return $this->hasMany(SabiticerikDetay::class, 'icerik_id', 'id');
	}
}
