<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Ayarlar extends Model
{
	use HasFactory;
  
	protected $table = 'ayarlar';
  
	protected $fillable = [
		'anahtar',
		'deger',
		'ekdeger',
	];

	protected $casts = [
		'ekdeger' => 'array',
	];

  public $cacheFor = 3600;
  protected static $flushCacheOnUpdate = true;
}
