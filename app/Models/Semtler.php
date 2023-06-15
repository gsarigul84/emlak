<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semtler extends Model
{
	use HasFactory;

	protected $table = 'semtler';

	protected $fillable = ['il_id', 'ilce_id', 'semtadi'];

	public function il()
	{
		return $this->belongsTo(Iller::class, 'il_id');
	}

	public function ilce()
	{
		return $this->belongsTo(Ilceler::class, 'ilce_id');
	}

	public function mahalleler()
	{
		return $this->hasMany(Mahalleler::class, 'semt_id');
	}
}
