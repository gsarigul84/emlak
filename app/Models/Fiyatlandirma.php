<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Rennokki\QueryCache\Traits\QueryCacheable;

class Fiyatlandirma extends Model
{
	use HasFactory;

	protected $table = 'fiyatlandirma';

	protected $fillable = ['sembol', 'durum'];
  
  public $cacheFor = 3600;
  protected static $flushCacheOnUpdate = true;
}
