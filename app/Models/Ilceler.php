<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Rennokki\QueryCache\Traits\QueryCacheable;
class Ilceler extends Model
{
	use HasFactory, QueryCacheable;

	protected $table = 'ilceler';

	protected $fillable = ['il_id', 'ilceadi'];

	public function il()
	{
		return $this->belongsTo(Iller::class, 'il_id', 'id');
	}

	public function semtler()
	{
		return $this->hasMany(Semtler::class, 'ilce_id');
	}

	public function mahalleler()
	{
		return $this->hasMany(Mahalleler::class, 'ilce_id');
	}

  
  public $cacheFor = 3600;
  protected static $flushCacheOnUpdate = true;
}
