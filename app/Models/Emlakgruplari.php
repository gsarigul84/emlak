<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Rennokki\QueryCache\Traits\QueryCacheable;

class Emlakgruplari extends Model
{
	use HasFactory, QueryCacheable;

	protected $table = 'emlakgruplari';

	protected $fillable = ['grupadi', 'ozellikgruplari', 'nitelikler'];

	public $casts = [
		'ozellikgruplari' => 'array',
		'nitelikler' => 'array',
	];

  public $cacheFor = 3600;
  protected static $flushCacheOnUpdate = true;
}
