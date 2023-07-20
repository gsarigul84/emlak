<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Rennokki\QueryCache\Traits\QueryCacheable;

class Diller extends Model
{
	use HasFactory, QueryCacheable;

	protected $table = 'diller';

	protected $fillable = ['diladi', 'dilkodu'];
  
  public $cacheFor = 3600;
  protected static $flushCacheOnUpdate = true;
}
