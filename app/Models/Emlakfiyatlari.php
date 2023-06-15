<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emlakfiyatlari extends Model
{
	use HasFactory;

	protected $table = 'emlakfiyatlari';

	protected $fillable = [
		'emlak_id',
		'fiyat',
		'sembol',
	];

	public function emlak()
	{
		return $this->belongsTo(Emlaklar::class, 'emlak_id', 'id');
	}

	// public function Fiyat(): Attribute
	// {
	//   return Attribute::make(
	//     get: fn ($value) => $value / 100 ,
	//     set: fn ($value) => $value * 100 ,
	//   );
	// }
}
