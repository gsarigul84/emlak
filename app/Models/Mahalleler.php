<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahalleler extends Model
{
	use HasFactory;

	protected $table = 'mahalleler';

	protected $fillable = ['il_id', 'ilce_id', 'mahalleadi','semt_id'];

	public function il()
	{
		return $this->belongsTo(Iller::class, 'il_id');
	}

	public function ilce()
	{
		return $this->belongsTo(Ilceler::class, 'ilce_id');
	}

	public function semt()
	{
		return $this->belongsTo(Semtler::class, 'semt_id');
	}
}
