<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Rennokki\QueryCache\Traits\QueryCacheable;

class Emlakdetay extends Model
{
	use HasFactory;

	protected $table = 'emlakdetay';

	protected $fillable = ['emlak_id', 'dilkodu', 'sef', 'baslik', 'aciklama', 'detay'];

	public function emlak()
	{
		return $this->belongsTo(Emlak::class);
	}

  public $cacheFor = 3600;
  protected static $flushCacheOnUpdate = true;
}
