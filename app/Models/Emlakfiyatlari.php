<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Emlakfiyatlari extends Model
{
	use HasFactory, QueryCacheable;

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

  
  public $cacheFor = 3600;
  protected static $flushCacheOnUpdate = true;
}
