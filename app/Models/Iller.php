<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Rennokki\QueryCache\Traits\QueryCacheable;
class Iller extends Model
{
	use HasFactory, QueryCacheable;

	protected $table = 'iller';

	protected $fillable = ['iladi'];

	public function semtler()
	{
		return $this->hasMany(Semtler::class, 'il_id');
	}

	public function ilceler()
	{
		return $this->hasMany(Ilceler::class, 'il_id');
	}

	public function mahalleler()
	{
		return $this->hasMany(Mahalleler::class, 'il_id');
	}

  public $cacheFor = 3600;
  protected static $flushCacheOnUpdate = true;
}
