<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emlakozellikleri extends Model
{
	use HasFactory;

	protected $table = 'emlakozellikleri';

	protected $fillable = [
		'emlak_id',
		'ozellik_id',
	];

	public function ozellik()
	{
		return $this->belongsTo(Ozellikler::class, 'ozellik_id');
	}

	public function emlak()
	{
		return $this->belongsTo(Emlak::class, 'emlak_id');
	}
}
